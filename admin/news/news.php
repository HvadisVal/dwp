<?php 
require_once("./includes/admin_session.php"); 
require_once("./includes/connection.php"); 
require_once("./includes/functions.php"); 
require_once("../dwp/admin/image_functions.php"); 

// Generate CSRF token
generate_csrf_token();

// Handle the form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    validate_csrf_token($_POST['csrf_token']);

    // Refresh CSRF token to avoid reuse
    refresh_csrf_token();
    
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
            
            // Only call uploadImage if the news was added successfully
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                uploadImage($newsId, 'news', $connection); // Include 'news' as type
            }
            else {
                $_SESSION['message'] = "Error: An image is required to add news.";
                header("Location: /dwp/admin/manage-news"); 
                exit();
            }
            
            $_SESSION['message'] = "News added successfully!";
            header("Location: /dwp/admin/manage-news"); 
            exit();
        } else {
            echo "Error adding news.";
        }
    }
     // Inside the POST request handling
if (isset($_POST['edit_news'])) {
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
            // Delete the existing image before uploading the new one
            deleteImage($newsId, 'news', $connection);
            uploadImage($newsId, 'news', $connection); // Pass the type as 'news'
        }

        $_SESSION['message'] = "News article updated successfully!";
        header("Location: /dwp/admin/manage-news"); 
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
    
        header("Location: /dwp/admin/manage-news");
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
include('news_content.php');