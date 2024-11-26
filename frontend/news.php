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
        * {
            box-sizing: border-box!important;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif!important;
        }
        body {
            margin: 0!important;
            padding: 0!important;
            background-color: black;
            background-image: url('https://t4.ftcdn.net/jpg/04/61/47/03/360_F_461470323_6TMQSkCCs9XQoTtyer8VCsFypxwRiDGU.jpghttps://t4.ftcdn.net/jpg/04/61/47/03/360_F_461470323_6TMQSkCCs9XQoTtyer8VCsFypxwRiDGU.jpg')!important;
            background-size: cover!important;
            color: #333!important;
            top: 50px!important;
            position: relative!important;
        }

        /* Container */
        .container {
            width: 80%!important;
            margin: 40px auto!important;
            padding: 0 15px!important;
        }

        /* News Section Header */
        h1 {
            text-align: center!important;
            margin-bottom: 30px!important;
            color: white!important;
            font-size: 2rem!important;
        }

        /* News Articles Grid */
        .news-grid {
            display: grid!important;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))!important;
            gap: 20px!important;
        }

        /* Individual Article Card */
        .news-article {
            background: linear-gradient(to right, #243642, #1a252d)!important;
            border-radius: 8px!important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1)!important;
            overflow: hidden!important;
            transition: transform 0.3s ease!important;
        }

        .news-article:hover {
            transform: translateY(-5px)!important;
        }

        /* News Image */
        .news-article img {
            width: 100%!important;
            height: 200px!important;
            object-fit: cover!important;
        }

        /* News Content */
        .news-content {
            padding: 15px!important;
        }

        .news-content h2 {
            font-size: 1.5em!important;
            color: white!important;
            margin: 0 0 10px!important;
        }

        .news-content .date {
            font-size: 0.9em!important;
            color: #666!important;
            margin-bottom: 10px!important;
        }

        .news-content p {
            line-height: 1.6!important;
            color: #ddd!important;
        }
    </style>
</head>
<body>
<?php include 'frontend/navbar/navbar_structure.php'; ?>
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
