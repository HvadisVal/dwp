<?php
// Include the database connection file
require_once 'dbcon.php';

// Connect to the database
$conn = dbCon($user, $pass);

// Query to fetch news with associated media
$sql = "
    SELECT 
        News.Title, 
        News.Content, 
        News.DatePosted, 
        Media.FileName, 
        Media.Format 
    FROM News 
    LEFT JOIN Media ON News.News_ID = Media.News_ID
    ORDER BY News.DatePosted DESC
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Page</title>
    <style>
        /* General Body Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            background-image: url('https://t4.ftcdn.net/jpg/04/61/47/03/360_F_461470323_6TMQSkCCs9XQoTtyer8VCsFypxwRiDGU.jpghttps://t4.ftcdn.net/jpg/04/61/47/03/360_F_461470323_6TMQSkCCs9XQoTtyer8VCsFypxwRiDGU.jpg');
            background-size: cover;
            color: #333;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 15px;
        }

        /* News Section Header */
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }

        /* News Articles Grid */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        /* Individual Article Card */
        .news-article {
            background: linear-gradient(to right, #243642, #1a252d);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .news-article:hover {
            transform: translateY(-5px);
        }

        /* News Image */
        .news-article img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* News Content */
        .news-content {
            padding: 15px;
        }

        .news-content h2 {
            font-size: 1.5em;
            color: white;
            margin: 0 0 10px;
        }

        .news-content .date {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 10px;
        }

        .news-content p {
            line-height: 1.6;
            color: #ddd;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Latest News</h1>
        <div class="news-grid">
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $row): ?>
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
    <?php include 'footer.php'; ?>
</body>
</html>
