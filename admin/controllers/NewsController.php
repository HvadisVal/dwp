<?php
require_once("./includes/admin_session.php");
require_once("./includes/functions.php");
require_once("./admin/models/NewsModel.php");
require_once('./includes/image_functions.php');

class NewsController {
    private $model;
    private $connection;

    public function __construct($connection) {
        $this->model = new NewsModel($connection);
        $this->connection = $connection;  
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            validate_csrf_token($_POST['csrf_token']);
            refresh_csrf_token();

            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'add':
                    $this->addNews();
                    break;

                case 'edit':
                    $this->editNews();
                    break;

                case 'delete':
                    $this->deleteNews();
                    break;

                default:
                    $_SESSION['message'] = "Invalid action.";
                    header("Location: /dwp/admin/manage-news");
                    exit();
            }
        }

        $newsArticles = $this->model->getAllNews();
        $newsWithImages = [];
        foreach ($newsArticles as $news) {
            $images = $this->model->getNewsMedia($news['News_ID']);
            $newsWithImages[$news['News_ID']] = ['article' => $news, 'images' => $images];
        }

        include('./admin/views/news_view.php');
    }

    private function addNews() {
        $title = htmlspecialchars(trim($_POST['title']));
        $content = htmlspecialchars(trim($_POST['content']));
        $datePosted = $_POST['dateposted'];
        if (!validate_date($datePosted)) {
            $_SESSION['message'] = "Please enter a valid  date (YYYY-MM-DD).";
            header("Location: /dwp/admin/manage-coupons");
            exit();
        }

        $newsId = $this->model->addNews($title, $content, $datePosted);

        if ($newsId) {
            uploadImage($newsId, 'news', $this->connection);  
            $_SESSION['message'] = "News added successfully!";
        } else {
            $_SESSION['message'] = "Error adding news.";
        }

        header("Location: /dwp/admin/manage-news");
        exit();
    }

    private function editNews() {
        $newsId = (int)$_POST['news_id'];
        $title = htmlspecialchars(trim($_POST['title']));
        $content = htmlspecialchars(trim($_POST['content']));
        $datePosted = $_POST['dateposted'];
        if (!validate_date($datePosted)) {
            $_SESSION['message'] = "Please enter a valid  date (YYYY-MM-DD).";
            header("Location: /dwp/admin/manage-coupons");
            exit();
        }
        
        if ($this->model->editNews($newsId, $title, $content, $datePosted)) {
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                deleteImage($newsId, 'news', $this->connection); 
                uploadImage($newsId, 'news', $this->connection); 
            }

            $_SESSION['message'] = "News article updated successfully!";
        } else {
            $_SESSION['message'] = "Error updating news article.";
        }

        header("Location: /dwp/admin/manage-news");
        exit();
    }

    private function deleteNews() {
        $newsId = (int)$_POST['news_id'];
        deleteImage($newsId, 'news', $this->connection); 
        $this->model->deleteNews($newsId);

        $_SESSION['message'] = "News deleted successfully!";
        header("Location: /dwp/admin/manage-news");
        exit();
    }
}
