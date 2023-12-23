<?php
session_start();
include("./config/dbconfig.php");

// Kiểm tra xem form đã được gửi hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = $_POST["name"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Kiểm tra dữ liệu nhập vào
    if (empty($name) || empty($email) || empty($gender) || empty($password) || empty($confirm_password)) {
        echo "<script language='javascript'>
                alert('Vui lòng không để trống các trường!');
                window.location='register.php';
              </script>";
    } elseif ($password !== $confirm_password) {
        echo "<script language='javascript'>
                alert('Mật khẩu và mật khẩu nhập lại không khớp!');
                window.location='register.php';
              </script>";
    } else {
        // Mã hóa mật khẩu
        $hashed_password = md5($password);

        // Câu lệnh SQL để chèn dữ liệu người dùng mới
        $sql = "INSERT INTO user (name, email, gender, password) VALUES (?, ?, ?, ?)";

        // Chuẩn bị câu lệnh SQL
        if ($stmt = mysqli_prepare($kn, $sql)) {
            // Gắn các biến vào các tham số trong câu lệnh đã chuẩn bị
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $gender, $hashed_password);

            // Thực hiện câu lệnh
            if (mysqli_stmt_execute($stmt)) {
                echo "<script language='javascript'>
                        alert('Đăng ký thành công!');
                        window.location='login.php';
                      </script>";
            } else {
                echo "<script language='javascript'>
                        alert('Đã xảy ra lỗi. Vui lòng thử lại!');
                        window.location='register.php';
                      </script>";
            }
            // Đóng statement
            mysqli_stmt_close($stmt);
        }
    }
    // Đóng kết nối
    mysqli_close($kn);
}
?>
