<?php
// Directory where the uploaded database file will be stored
$uploadDirectory = 'DATABASE/';

// Check if the request is for uploading a file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['db_file']) && $_FILES['db_file']['error'] === UPLOAD_ERR_OK) {
    // Get file info
    $fileTmpPath = $_FILES['db_file']['tmp_name'];
    $fileName = $_FILES['db_file']['name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    // Ensure that the uploaded file is a .db file
    if ($fileExtension !== 'db') {
        echo 'Error: Only .db files are allowed.';
        exit;
    }

    // Define the path to overwrite the existing database file
    $destPath = $uploadDirectory . 'fram_attendance.db';

    // Move the uploaded file to the destination directory (will overwrite existing file)
    if (move_uploaded_file($fileTmpPath, $destPath)) {
        echo '<script>alert("Database updated successfully"); window.location.href="dashboard.php"</script>.';
    } else {
        echo 'Error: There was an issue uploading the file.';
    }
}

// Check if the request is for downloading the database file
elseif (isset($_GET['download']) && $_GET['download'] === 'true') {
    // Define the path to the database file
    $filePath = 'DATABASE/school_management.db'; // Assuming you want to download this specific file

    // Check if the file exists
    if (file_exists($filePath)) {
        // Set headers to initiate a download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="school_management.db"');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: no-cache');
        header('Pragma: no-cache');

        // Output the file content
        readfile($filePath);
        exit;
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Invalid request.';
}
?>