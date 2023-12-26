<?php
include 'config/dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_blog = $_POST['id_blog'];
    $new_status = $_POST['new_status'];

    $query = "UPDATE blog SET status = ? WHERE id_blog = ?";
    if ($stmt = mysqli_prepare($kn, $query)) {
        mysqli_stmt_bind_param($stmt, "ii", $new_status, $id_blog);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "Bạn có chắc sẽ cập nhật trạng thái chứ.";
    } else {
        echo "Oh có lỗi rồi.";
    }
}
?>
