<?php
$target_dir = "uploads/";
$uploadOk = 1;

// Check if the uploads directory exists, if not create it
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// Continue with the upload process
if(isset($_POST["submit"])) {
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

    $hashedName = uniqid('img_') . '.' . $imageFileType;
    $target_file = $target_dir . $hashedName;

    // Continue with the checks...
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) { // Allow up to 5MB files
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            echo "<img src='$target_file' alt='Uploaded Image' style='max-width: 500px;'>";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
