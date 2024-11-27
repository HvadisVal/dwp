<?php
require_once("./includes/admin_session.php"); 
require_once("./includes/connection.php"); 
require_once("./includes/functions.php"); 
require_once("../dwp/admin/image_functions.php"); 

// CSRF token handling
generate_csrf_token();

// News Manager Class
class NewsManager {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    // Add a news article
// Add a news article
public function addNews($title, $content, $datePosted) {
    // Validate if an image is uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = "Error: An image is required to add news.";
        header("Location: /dwp/admin/manage-news");
        exit();
    }

    // Proceed with inserting the news if the image is valid
    $sql = "INSERT INTO News (Title, Content, DatePosted) VALUES (?, ?, ?)";
    $stmt = $this->connection->prepare($sql);

    if ($stmt->execute([$title, $content, $datePosted])) {
        $newsId = $this->connection->lastInsertId();

        // Handle image upload after adding the news
        uploadImage($newsId, 'news', $this->connection);

        $_SESSION['message'] = "News added successfully!";
        header("Location: /dwp/admin/manage-news");
        exit();
    } else {
        $_SESSION['message'] = "Error adding news.";
        header("Location: /dwp/admin/manage-news");
        exit();
    }
}


    // Edit a news article
    public function editNews($newsId, $title, $content, $datePosted) {
        $sql = "UPDATE News SET Title = ?, Content = ?, DatePosted = ? WHERE News_ID = ?";
        $stmt = $this->connection->prepare($sql);

        if ($stmt->execute([$title, $content, $datePosted, $newsId])) {
            // Check if a new image is uploaded and process it
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                deleteImage($newsId, 'news', $this->connection); // Delete old image
                uploadImage($newsId, 'news', $this->connection); // Upload new image
            }

            $_SESSION['message'] = "News article updated successfully!";
            header("Location: /dwp/admin/manage-news"); 
            exit();
        } else {
            $_SESSION['message'] = "Error updating news article.";
            header("Location: /dwp/admin/manage-news"); 
            exit();
        }
    }

    // Delete a news article
    public function deleteNews($newsId) {
        deleteImage($newsId, 'news', $this->connection); // Delete associated image

        $sql = "DELETE FROM News WHERE News_ID = ?";
        $stmt = $this->connection->prepare($sql);

        if ($stmt->execute([$newsId])) {
            $_SESSION['message'] = "News deleted successfully!";
        } else {
            $_SESSION['message'] = "Error deleting news.";
        }

        header("Location: /dwp/admin/manage-news"); 
        exit();
    }

    // Fetch all news articles
    public function getAllNews() {
        $sql = "SELECT News_ID, Title, Content, DatePosted FROM News";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    validate_csrf_token($_POST['csrf_token']);

    // Refresh CSRF token to avoid reuse
    refresh_csrf_token();

    // Create instance of NewsManager class
    $newsManager = new NewsManager($connection);

    // Determine action and process accordingly
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'add':
            $title = htmlspecialchars(trim($_POST['title']));
            $content = htmlspecialchars(trim($_POST['content']));
            $datePosted = $_POST['dateposted'];
            $newsManager->addNews($title, $content, $datePosted);
            break;

        case 'edit':
            $newsId = (int)$_POST['news_id'];
            $title = htmlspecialchars(trim($_POST['title']));
            $content = htmlspecialchars(trim($_POST['content']));
            $datePosted = $_POST['dateposted'];
            $newsManager->editNews($newsId, $title, $content, $datePosted);
            break;

        case 'delete':
            $newsId = (int)$_POST['news_id'];
            $newsManager->deleteNews($newsId);
            break;

        default:
            $_SESSION['message'] = "Invalid action.";
            header("Location: /dwp/admin/manage-news");
            exit();
    }
}

// Fetch all news articles
$newsManager = new NewsManager($connection);
$newsArticles = $newsManager->getAllNews();

// Fetch associated images
$images = [];
foreach ($newsArticles as $news) {
    $newsId = $news['News_ID'];
    $mediaSql = "SELECT FileName FROM Media WHERE News_ID = ?";
    $mediaStmt = $connection->prepare($mediaSql);
    $mediaStmt->execute([$newsId]);
    $images[$newsId] = $mediaStmt->fetchAll(PDO::FETCH_COLUMN);
}

// Display messages if available
if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']);
}

include('news_content.php');

