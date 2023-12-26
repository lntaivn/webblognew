<?php
session_start();
include('../config/dbconfig.php');

if (!isset($_SESSION["user"])) {
    echo "<script language=javascript>
  alert('Vui lòng đăng nhập!');
  window.location='login.php';
  </script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_SESSION['user'];
    $id_post = $_POST['id_post'];


    // Lấy id_user dựa trên email
    $userQuery = "SELECT id_user FROM user WHERE email = ?";
    if ($userStmt = mysqli_prepare($kn, $userQuery)) {
        mysqli_stmt_bind_param($userStmt, "s", $email);
        mysqli_stmt_execute($userStmt);
        $userResult = mysqli_stmt_get_result($userStmt);
        $userRow = mysqli_fetch_assoc($userResult);
        mysqli_stmt_close($userStmt);

        if ($userRow) {
            $id_user = $userRow['id_user'];
        }




        $id_post = $_POST['id_post'];
        $comment_text = $_POST['comment_text'];

        // Tiền xử lý dữ liệu...
        $id_user = mysqli_real_escape_string($kn, $id_user);
        $id_post = mysqli_real_escape_string($kn, $id_post);
        $comment_text = mysqli_real_escape_string($kn, $comment_text);

        $sql = "INSERT INTO comment (id_user, id_post, comment_text) VALUES ('$id_user', '$id_post', '$comment_text')";

        if ($kn->query($sql) === TRUE) {
            header("Location: ../content/blog.php?id=" . $id_post);
            // Có thể chuyển hướng người dùng trở lại trang bài viết
        } else {
            echo "Có lỗi xảy ra: " . $kn->error;
        }

    }
}
?>