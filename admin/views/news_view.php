<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News</title>
    <link rel="stylesheet" href="/dwp/admin/assets/css/news.css" />
</head>
<body>
    
<a href="/dwp/admin/dashboard" class="back-to-dashboard"><img src="../images/back-button.png" alt=""></a>

<h1>Manage News</h1>

<?php if (isset($_SESSION['message'])): ?>
        <p><?php echo htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<h2>Add New Article</h2>
<form method="POST" enctype="multipart/form-data" class="news-card">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="action" value="add">

    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars(htmlspecialchars_decode($data['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="content">Content:</label>
    <textarea name="content" required><?php echo htmlspecialchars(htmlspecialchars_decode($data['content'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>

    <label for="dateposted">Date Posted:</label>
    <input type="date" name="dateposted" value="<?php echo htmlspecialchars(htmlspecialchars_decode($data['dateposted'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>

    <div class="file-input-container">
        <label for="image">Upload New Image:</label>
        <input type="file" id="image" name="image" accept="image/png, image/jpeg" onchange="displayFileName(event)">
        <label for="image">Choose Image</label>
        <div class="file-name" id="fileNameContainer"></div>
    </div>

    <button type="submit" class="add-button">Add News</button>
</form>

<h2>Existing Articles</h2>
<div id="newsContainer">
    <?php foreach ($newsWithImages as $newsId => $data): ?>
        <div class="news-card">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="news_id" value="<?php echo htmlspecialchars($data['article']['News_ID'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars(htmlspecialchars_decode($data['article']['Title'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="content">Content:</label>
                <textarea name="content" required><?php echo htmlspecialchars(htmlspecialchars_decode($data['article']['Content'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?></textarea>

                <label for="dateposted">Date Posted:</label>
                <input type="date" name="dateposted" value="<?php echo htmlspecialchars(htmlspecialchars_decode($data['article']['DatePosted'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required>

                <label>Current Image:</label>
                <?php if (!empty($data['images'])): ?>
                    <img src="../uploads/news_images/<?php echo htmlspecialchars($data['images'][0], ENT_QUOTES, 'UTF-8'); ?>" alt="News Image" class="image-preview">
                <?php else: ?>
                    <p>No image uploaded for this article.</p>
                <?php endif; ?>

                <div class="file-input-container">
                    <label for="image-<?php echo htmlspecialchars($data['article']['News_ID'], ENT_QUOTES, 'UTF-8'); ?>">Upload New Image:</label>
                    <input type="file" id="image-<?php echo htmlspecialchars($data['article']['News_ID'], ENT_QUOTES, 'UTF-8'); ?>" name="image" accept="image/png, image/jpeg" onchange="displayFileName(event, <?php echo htmlspecialchars($data['article']['News_ID'], ENT_QUOTES, 'UTF-8'); ?>)">
                    <label for="image-<?php echo htmlspecialchars($data['article']['News_ID'], ENT_QUOTES, 'UTF-8'); ?>" class="file-label">Choose Image</label>
                    <div class="file-name" id="fileNameContainer-<?php echo htmlspecialchars($data['article']['News_ID'], ENT_QUOTES, 'UTF-8'); ?>"></div>
                </div>

                <button type="submit" name="action" value="edit" class="edit-button">Edit News</button>
            </form>
            <form method="POST" style="margin-top: 10px;">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="news_id" value="<?php echo htmlspecialchars($data['article']['News_ID'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" name="action" value="delete" class="delete-button">Delete News</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<script src="/dwp/includes/functions.js" defer></script>
</body>
</html>
