<!-- news_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News</title>
    <link rel="stylesheet" href="/dwp/admin/assets/css/news.css" />
</head>
<body>

<h1>Manage News</h1>

<?php if (isset($_SESSION['message'])): ?>
        <p><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

<!-- Add News Section -->
<h2>Add New Article</h2>
<form method="POST" enctype="multipart/form-data" class="news-card">
    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
    <input type="hidden" name="action" value="add">

    <label for="title">Title:</label>
    <input type="text" name="title" required>

    <label for="content">Content:</label>
    <textarea name="content" required></textarea>

    <label for="dateposted">Date Posted:</label>
    <input type="date" name="dateposted" required>

    <div class="file-input-container">
        <label for="image">Upload New Image:</label>
        <input type="file" id="image" name="image" accept="image/png, image/jpeg" onchange="displayFileName(event)">
        <label for="image">Choose Image</label>
        <div class="file-name" id="fileNameContainer"></div>
    </div>

    <button type="submit" class="add-button">Add News</button>
</form>

<!-- Existing News Section -->
<h2>Existing Articles</h2>
<div id="newsContainer">
    <?php foreach ($newsWithImages as $newsId => $data): ?>
        <div class="news-card">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="news_id" value="<?php echo $data['article']['News_ID']; ?>">

                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($data['article']['Title']); ?>" required>

                <label for="content">Content:</label>
                <textarea name="content" required><?php echo htmlspecialchars($data['article']['Content']); ?></textarea>

                <label for="dateposted">Date Posted:</label>
                <input type="date" name="dateposted" value="<?php echo htmlspecialchars($data['article']['DatePosted']); ?>" required>

                <label>Current Image:</label>
                <?php if (!empty($data['images'])): ?>
                    <img src="../uploads/news_images/<?php echo htmlspecialchars($data['images'][0]); ?>" alt="News Image" class="image-preview">
                <?php else: ?>
                    <p>No image uploaded for this article.</p>
                <?php endif; ?>

                <div class="file-input-container">
                    <label for="image-<?php echo $data['article']['News_ID']; ?>">Upload New Image:</label>
                    <input type="file" id="image-<?php echo $data['article']['News_ID']; ?>" name="image" accept="image/png, image/jpeg" onchange="displayFileName(event, <?php echo $data['article']['News_ID']; ?>)">
                    <label for="image-<?php echo $data['article']['News_ID']; ?>" class="file-label">Choose Image</label>
                    <div class="file-name" id="fileNameContainer-<?php echo $data['article']['News_ID']; ?>"></div>
                </div>

                <button type="submit" name="action" value="edit" class="edit-button">Edit News</button>
            </form>
            <form method="POST" style="margin-top: 10px;">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="news_id" value="<?php echo $data['article']['News_ID']; ?>">
                <button type="submit" name="action" value="delete" class="delete-button">Delete News</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<script src="/dwp/includes/functions.js" defer></script>
</body>
</html>