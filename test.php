<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
</head>
<body>
    <h2>Upload an Image</h2>
    <form action="test.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image" id="image">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</body>
</html>
<?php
if (isset($_POST["submit"])) {
    // Check if the file was uploaded without errors
    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        // Get the file details
        $file_name = $_FILES["image"]["name"];
        $file_tmp = $_FILES["image"]["tmp_name"];
        $file_size = $_FILES["image"]["size"];
        $file_type = $_FILES["image"]["type"];
        
        // Specify the directory where you want to store the uploaded image
        $target_dir = "uploads/";
        
        // Generate a unique name for the image to avoid overwriting existing files
        $file_new_name = uniqid() . "_" . $file_name;

        // Check if the file is an image (optional, but recommended)
        $allowed_types = array("image/jpeg", "image/png", "image/gif");
        if (!in_array($file_type, $allowed_types)) {
            die("Error: Only JPG, PNG, and GIF images are allowed.");
        }

        // Check if the file size is within the allowed limit (optional, but recommended)
        $max_file_size = 2 * 1024 * 1024; // 2MB
        if ($file_size > $max_file_size) {
            die("Error: File size exceeds the maximum allowed limit (2MB).");
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file_tmp, $target_dir . $file_new_name)) {
            // File uploaded successfully
            echo "Image uploaded successfully. File name: " . $file_new_name;
        } else {
            // File upload failed
            die("Error: Failed to upload the image.");
        }
    } else {
        // File upload error
        die("Error: " . $_FILES["image"]["error"]);
    }
}
?>
