<?php
include('../config/dbconfig.php');

// Lấy dữ liệu từ request
$commentText = $_POST['commentText'];

// Thực hiện truy vấn Insert vào bảng comment
$sql = "INSERT INTO comment (id_post, id_user, comment_date, comment_text) VALUES (1, 1, NOW(), '$commentText')";

if ($kn->query($sql) === TRUE) {
    echo "Comment saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $kn->error;
}

// Đóng kết nối
$kn->close();
?>