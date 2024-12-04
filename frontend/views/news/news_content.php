<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Page</title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/news.css">
</head>
<body>
    <?php 
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/NavbarController.php';
        $navbar = new NavbarController();
        $navbar->handleRequest();
    ?>
    <div class="container">
        <h1>Latest News</h1>
        <div class="news-grid">
            <?php if (!empty($news)): ?>
                <?php foreach ($news as $row): ?>
                    <div class="news-article">
                        <?php if (!empty($row['FileName'])): ?>
                            <img src="uploads/news_images/<?= htmlspecialchars($row['FileName']) ?>" alt="News Image">
                        <?php endif; ?>
                        <div class="news-content">
                            <h2><?= htmlspecialchars($row['Title']) ?></h2>
                            <div class="date"><?= htmlspecialchars($row['DatePosted']) ?></div>
                            <p><?= htmlspecialchars($row['Content']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No news available with media.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/footer/footer_content.php'; ?>
</body>
</html>
