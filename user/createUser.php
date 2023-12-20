<?php
include("../config/dbconfig.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ biểu mẫu
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = $_POST['gender'];

    // Kiểm tra xem tệp ảnh đã được tải lên thành công
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $avatar = $_FILES['avatar']['tmp_name'];
        $avatarData = file_get_contents($avatar);
        $avatarType = mime_content_type($avatar);

        // Chuẩn bị truy vấn SQL để chèn dữ liệu vào cơ sở dữ liệu
        $sql = "INSERT INTO user (name, email, password, gender, avt) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($kn, $sql);

        // Kiểm tra truy vấn đã chuẩn bị thành công
        if ($stmt) {
            // Lưu ý: 'b' trong bind_param nghĩa là blob
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $password, $gender, $avatarData);
            
            // // Binds the blob parameter
            // mysqli_stmt_send_long_data($stmt, 4, $avatarData);

            // Thực hiện truy vấn
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo "Thêm người dùng thành công.";
            } else {
                echo "Lỗi khi thêm người dùng: " . mysqli_stmt_error($stmt);
            }

            // Đóng tuyên bố truy vấn
            mysqli_stmt_close($stmt);
        } else {
            echo "Lỗi khi chuẩn bị truy vấn: " . mysqli_error($kn);
        }
    } else {
        echo "Lỗi khi tải lên tệp ảnh đại diện.";
        // Xử lý lỗi tải lên tệp ở đây
    }
} else {
    echo "Lỗi: Yêu cầu không hợp lệ.";
}

// Đóng kết nối MySQL
mysqli_close($kn);
?>
