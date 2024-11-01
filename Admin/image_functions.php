<?php
// image_functions.php

// Helper function to upload or replace an image for a news article or movie
function uploadImage($id, $type, $connection) {
    // Define the directory based on type
    if ($type === 'news') {
        $uploadFileDir = '../uploads/news_images/';
        $fileLimit = 1;
        $foreignKeyColumn = 'News_ID'; // Use News_ID for news articles
    } elseif ($type === 'movie') {
        $uploadFileDir = '../uploads/poster/';
        $fileLimit = 1;
        $foreignKeyColumn = 'Movie_ID'; // Use Movie_ID for movies
    } elseif ($type === 'gallery') {
        $uploadFileDir = '../uploads/gallery/';
        $fileLimit = 5;
    } else {
        echo "Invalid image type.";
        return;
    }

    // Ensure we're not exceeding the limit for gallery images
    if ($type === 'gallery') {
        $galleryCountSql = "SELECT COUNT(*) FROM Media WHERE Movie_ID = ? AND IsFeatured = 0";
        $galleryCountStmt = $connection->prepare($galleryCountSql);
        $galleryCountStmt->execute([$id]);
        $existingGalleryCount = (int)$galleryCountStmt->fetchColumn();

        $uploadedFilesCount = is_array($_FILES['image']['name']) ? count($_FILES['image']['name']) : 1;
        if ($uploadedFilesCount + $existingGalleryCount > $fileLimit) {
            echo "Cannot upload more than $fileLimit images to the gallery.";
            return;
        }
    }

    // Process single or multiple file uploads
    $files = is_array($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : [$_FILES['image']['tmp_name']];
    $fileNames = is_array($_FILES['image']['name']) ? $_FILES['image']['name'] : [$_FILES['image']['name']];
    $fileErrors = is_array($_FILES['image']['error']) ? $_FILES['image']['error'] : [$_FILES['image']['error']];

    foreach ($files as $index => $fileTmpPath) {
        if ($fileErrors[$index] === UPLOAD_ERR_OK) {
            $fileName = $fileNames[$index];
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedTypes = ['jpg', 'png'];

            if (in_array(strtolower($fileType), $allowedTypes)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileType;
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Insert new image record into the Media table
                    $isFeatured = ($type === 'movie') ? 1 : 0; // 1 for poster, 0 for gallery images
                    if ($type === 'news') {
                        // For news, use News_ID as foreign key
                        $mediaSql = "INSERT INTO Media (FileName, Format, News_ID, IsFeatured) VALUES (?, ?, ?, ?)";
                        $mediaStmt = $connection->prepare($mediaSql);
                        $mediaStmt->execute([$newFileName, $fileType, $id, $isFeatured]);
                    } else {
                        // For movies or galleries, use Movie_ID as foreign key
                        $mediaSql = "INSERT INTO Media (FileName, Format, Movie_ID, IsFeatured) VALUES (?, ?, ?, ?)";
                        $mediaStmt = $connection->prepare($mediaSql);
                        $mediaStmt->execute([$newFileName, $fileType, $id, $isFeatured]);
                    }
                    echo "Image $fileName uploaded successfully.";
                } else {
                    echo "Error moving the uploaded file $fileName.";
                }
            } else {
                echo "Invalid file type for $fileName. Only JPG and PNG are allowed.";
            }
        } else {
            echo "Upload error for $fileName.";
        }
    }
}

function deleteImage($id, $type, $connection) {
    // Retrieve all file names for this article/movie
    $mediaSql = "SELECT FileName, IsFeatured FROM Media WHERE " . strtoupper($type) . "_ID = ?";
    $mediaStmt = $connection->prepare($mediaSql);
    $mediaStmt->execute([$id]);
    $mediaRecords = $mediaStmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through each media record
    foreach ($mediaRecords as $mediaRecord) {
        $fileName = $mediaRecord['FileName'];
        $isFeatured = $mediaRecord['IsFeatured'];

        // Determine the correct directory based on the type and whether it's featured
        if ($type === 'news') {
            $uploadFileDir = '../uploads/news_images/';
        } elseif ($type === 'movie') {
            $uploadFileDir = ($isFeatured == 1) ? '../uploads/poster/' : '../uploads/gallery/';
        } else {
            return "Invalid image type.";
        }

        // Construct the full path of the file to delete
        $filePath = $uploadFileDir . $fileName;

        // Delete the file if it exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Delete the image records from the Media table
    $deleteSql = "DELETE FROM Media WHERE " . strtoupper($type) . "_ID = ?";
    $deleteStmt = $connection->prepare($deleteSql);
    $deleteStmt->execute([$id]);
}
function deleteGalleryImage($fileName, $movieId, $connection) {
    // Delete the file from the server
    $filePath = '../uploads/gallery/' . $fileName;
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Delete the record from the Media table
    $deleteSql = "DELETE FROM Media WHERE FileName = ? AND Movie_ID = ?";
    $deleteStmt = $connection->prepare($deleteSql);
    $deleteStmt->execute([$fileName, $movieId]);
}
function deletePosterImage($movieId, $connection) {
    // Retrieve the poster image for the movie
    $mediaSql = "SELECT FileName FROM Media WHERE Movie_ID = ? AND IsFeatured = 1"; // Assuming IsFeatured = 1 indicates the poster
    $mediaStmt = $connection->prepare($mediaSql);
    $mediaStmt->execute([$movieId]);
    $mediaRecord = $mediaStmt->fetch(PDO::FETCH_ASSOC);

    if ($mediaRecord) {
        $fileName = $mediaRecord['FileName'];
        $uploadFileDir = '../uploads/poster/';
        $filePath = $uploadFileDir . $fileName;

        // Delete the file if it exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the record from the Media table
        $deleteSql = "DELETE FROM Media WHERE Movie_ID = ? AND IsFeatured = 1";
        $deleteStmt = $connection->prepare($deleteSql);
        $deleteStmt->execute([$movieId]);
    }
}
