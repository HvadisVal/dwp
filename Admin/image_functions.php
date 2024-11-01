<?php
// image_functions.php

// Helper function to upload or replace an image for a news article or movie
function uploadImage($id, $type, $connection) {
    // Ensure the file is properly uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo "No image uploaded or there was an upload error.";
        return; // Stop execution if there's an error
    }

    // Retrieve the current image filename before moving the new file
    $mediaSql = "SELECT FileName FROM Media WHERE " . strtoupper($type) . "_ID = ?";
    $mediaStmt = $connection->prepare($mediaSql);
    $mediaStmt->execute([$id]);
    $currentFileName = $mediaStmt->fetchColumn();

    // Define the directory based on type
    if ($type === 'news') {
        $uploadFileDir = '../uploads/news_images/';
    } elseif ($type === 'movie') {
        $uploadFileDir = '../uploads/poster/';
    } else {
        return "Invalid image type.";
    }

    // Proceed with new file upload
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $fileName = $_FILES['image']['name'];
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedTypes = ['jpg', 'png'];

    if (in_array(strtolower($fileType), $allowedTypes)) {
        $newFileName = md5(time() . $fileName) . '.' . $fileType;
        $dest_path = $uploadFileDir . $newFileName;

        // Move the new file
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Delete the old image if one exists
            if ($currentFileName) {
                deleteImage($id, $type, $connection); // Call deleteImage before inserting new one
            }

            // Insert new image record into the Media table
            $mediaSql = "INSERT INTO Media (FileName, Format, " . strtoupper($type) . "_ID) VALUES (?, ?, ?)";
            $mediaStmt = $connection->prepare($mediaSql);
            if ($mediaStmt->execute([$newFileName, $fileType, $id])) {
                echo "Image uploaded successfully.";
            } else {
                echo "Error inserting image into the database.";
            }
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "Invalid file type. Only JPG and PNG are allowed.";
    }
}

function deleteImage($id, $type, $connection) {
    // Retrieve the file name of the current image for this article/movie
    $mediaSql = "SELECT FileName FROM Media WHERE " . strtoupper($type) . "_ID = ?";
    $mediaStmt = $connection->prepare($mediaSql);
    $mediaStmt->execute([$id]);
    $fileName = $mediaStmt->fetchColumn();

    // If an image exists, delete it from the server
    if ($fileName) {
        $filePath = ($type === 'news') ? "../uploads/news_images/" . $fileName : "../uploads/poster/" . $fileName;
        
        // Delete the file if it exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the image record from the Media table
        $deleteSql = "DELETE FROM Media WHERE " . strtoupper($type) . "_ID = ?";
        $deleteStmt = $connection->prepare($deleteSql);
        $deleteStmt->execute([$id]);
    }
}

