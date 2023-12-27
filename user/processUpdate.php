<?php
session_start();
include("../config/dbconfig.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user"])) {
    $email = $_SESSION["user"];
    $query = "SELECT id_user FROM user WHERE email = '$email'";
    $result = mysqli_query($kn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $id_user = $row['id_user'];

            $name = isset($_POST['name']) ? mysqli_real_escape_string($kn, $_POST['name']) : '';
            $formEmail = isset($_POST['email']) ? mysqli_real_escape_string($kn, $_POST['email']) : '';
            $bio = isset($_POST['bio']) ? mysqli_real_escape_string($kn, $_POST['bio']) : '';

            $imagePath = '';
            if (isset($_FILES['profile-image']) && $_FILES['profile-image']['error'] == UPLOAD_ERR_OK) {
                $targetDir = "../upload_Img_User/";
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $targetFile = $targetDir . basename($_FILES['profile-image']['name']);
                if (move_uploaded_file($_FILES['profile-image']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
                } else {
                    echo "Error uploading file.";
                }
            }

            // Cập nhật cơ sở dữ liệu
            $updateQuery = "UPDATE user SET name = ?, email = ?, bio = ?, avt = ? WHERE id_user = ?";
            $stmt = $kn->prepare($updateQuery);
            $stmt->bind_param("ssssi", $name, $formEmail, $bio, $imagePath, $id_user);

            if ($stmt->execute()) {
                echo "Thông tin người dùng đã được cập nhật.";
            } else {
                echo "Lỗi cập nhật thông tin: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "No user found with the provided email.";
        }
    } else {
        echo "Error executing query: " . mysqli_error($kn);
    }
} else {
    echo "Không có dữ liệu để cập nhật";
}
?>
