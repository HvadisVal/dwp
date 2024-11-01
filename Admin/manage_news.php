<?php 
require_once("../includes/session.php"); 
require_once("../includes/connection.php"); 
require_once("../includes/functions.php"); 
require_once("./image_functions.php"); // Include the new file

// CSRF Protection: Generate token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle the form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    // Refresh CSRF token to avoid reuse
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    if (isset($_POST['add_news'])) {
        // Handle adding a news article
        $title = htmlspecialchars(trim($_POST['title']));
        $content = htmlspecialchars(trim($_POST['content']));
        $datePosted = $_POST['dateposted'];
    
        // Insert query with prepared statement
        $sql = "INSERT INTO News (Title, Content, DatePosted) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute([$title, $content, $datePosted])) {
            $newsId = $connection->lastInsertId(); 
            
            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                uploadImage($newsId, 'news', $connection); // Include 'news' as type
            } else {
                echo "Error uploading image: " . $_FILES['image']['error']; // Handle image upload error
            }
    
            $_SESSION['message'] = "News added successfully!";
            header("Location: manage_news.php"); 
            exit();
        } else {
            echo "Error adding news.";
        }
    } elseif (isset($_POST['edit_news'])) {
        // Update news article
        $newsId = (int)trim($_POST['news_id']);
        $title = htmlspecialchars(trim($_POST['title']));
        $content = htmlspecialchars(trim($_POST['content']));
        $datePosted = $_POST['dateposted'];
    
        // Update query with prepared statement
        $sql = "UPDATE News SET Title = ?, Content = ?, DatePosted = ? WHERE News_ID = ?";
        $stmt = $connection->prepare($sql);
    
        if ($stmt->execute([$title, $content, $datePosted, $newsId])) {
            // Check if a new image is uploaded and process it
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                uploadImage($newsId, 'news', $connection); // Pass the type as 'news'
            }
    
            $_SESSION['message'] = "News article updated successfully!";
            header("Location: manage_news.php"); 
            exit();
        } else {
            echo "Error updating news article.";
        }
    }
    
    elseif (isset($_POST['delete_news'])) {
        // Handle deleting a news article
        $newsId = (int)trim($_POST['news_id']);
    
        // Delete associated image from the server and Media table
        deleteImage($newsId, 'news', $connection); // Ensure you're passing the correct type
    
        // Delete the news article
        $sql = "DELETE FROM News WHERE News_ID = ?";
        $stmt = $connection->prepare(query: $sql);
    
        if ($stmt->execute([$newsId])) {
            $_SESSION['message'] = "News deleted successfully!";
        } else {
            echo "Error deleting news.";
        }
    
        header("Location: manage_news.php");
        exit();
    }
    
    
}

// Fetch news and associated images
$sql = "SELECT News_ID, Title, Content, DatePosted FROM News";
$stmt = $connection->prepare($sql);
$stmt->execute();
$newsArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch associated images
$images = [];
foreach ($newsArticles as $news) {
    $newsId = $news['News_ID'];
    $mediaSql = "SELECT FileName FROM Media WHERE News_ID = ?";
    $mediaStmt = $connection->prepare($mediaSql);
    $mediaStmt->execute([$newsId]);
    $images[$newsId] = $mediaStmt->fetchAll(PDO::FETCH_COLUMN);
}

if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News</title>
    <style>
        /* General Styling */
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        h1, h2 {
            color: black;
            text-align: center;
            margin: 25px 0;
        }

        h1 {
            font-size: 2em;
        }

        h2 {
            font-size: 1.5em;
            margin-bottom: 24px;
        }

        /* Form and Container */
        .news-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            background-color: #fff;
        }

        #newsContainer {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            padding: 0 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            margin-top: 16px;
            display: block;
            color: #666;
        }

        input[type="text"], input[type="date"], input[type="file"], textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            font-size: 16px;
            color: #555;
            box-sizing: border-box;
            margin-top: 8px;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .image-preview {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-top: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* Button Styling */
        .add-button, .edit-button, .delete-button {
            background: black;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 24px;
        }

        .add-button {
            background-color: black;

        }
        
        .add-button:hover {
            background: #1a252d; 
            color: white;
            transition:  0.3s ease, color 0.3s ease; 
            transform: translateY(-1px);
        }

        .edit-button {
            background-color: black;
            margin-right: 8px;
            disp
        }

        .edit-button:hover {
            background: #1a252d; 
            color: white;
            transition:  0.3s ease, color 0.3s ease; 
            transform: translateY(-1px);
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
            color: white;
            transition:  0.3s ease, color 0.3s ease; 
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            #newsContainer {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            h1, h2 {
                font-size: 1.5em;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            #newsContainer {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }
    </style>
</head>
<body>

<h1>Manage News</h1>

<!-- Add News Section -->
<h2>Add New Article</h2>
<form method="POST" enctype="multipart/form-data" class="news-card">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <label for="title">Title:</label>
    <input type="text" name="title" required>

    <label for="content">Content:</label>
    <textarea name="content" required></textarea>

    <label for="dateposted">Date Posted:</label>
    <input type="date" name="dateposted" required>

    <label for="image">Upload Image:</label>
    <input type="file" name="image" accept="image/png, image/jpeg" required>

    <button type="submit" name="add_news" class="add-button">Add News</button>
</form>

<!-- Existing News Section -->
<h2>Existing Articles</h2>
<div id="newsContainer">
    <?php foreach ($newsArticles as $news): ?>
        <div class="news-card">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="news_id" value="<?php echo $news['News_ID']; ?>">

                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($news['Title']); ?>" required>

                <label for="content">Content:</label>
                <textarea name="content" required><?php echo htmlspecialchars($news['Content']); ?></textarea>

                <label for="dateposted">Date Posted:</label>
                <input type="date" name="dateposted" value="<?php echo htmlspecialchars($news['DatePosted']); ?>" required>

                <label>Current Image:</label>
                <?php if (!empty($images[$news['News_ID']])): ?>
                    <img src="../uploads/news_images/<?php echo htmlspecialchars($images[$news['News_ID']][0]); ?>" alt="News Image" class="image-preview">
                <?php else: ?>
                    <p>No image uploaded for this article.</p>
                <?php endif; ?>

                <label for="image">Upload New Image:</label>
                <input type="file" name="image" accept="image/png, image/jpeg">

                <button type="submit" name="edit_news" class="edit-button">Save Changes</button>
                <button type="submit" name="delete_news" class="delete-button">Delete News</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>