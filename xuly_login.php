<?php
session_start();
include("./config/dbconfig.php");


// Kiểm tra xem form đã được gửi hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem các khóa 'email' và 'password' có tồn tại trong mảng $_POST không
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $pass = md5($_POST["password"]);

        // Câu lệnh SQL kiểm tra đăng nhập
        $sql = "SELECT * FROM user WHERE email='" . $email . "' AND password ='" . $pass . "' and position = 'user'";
        $kq = mysqli_query($kn, $sql) or die("Không thể mở bảng user" . mysqli_error($kn));

        if (mysqli_fetch_array($kq)) {
            $_SESSION["user"] = $email;
            echo "<script language='javascript'>
                alert('Đăng nhập thành công');
                window.location='index.php';
                </script>";
        } else {
            echo "<script language='javascript'>
                alert('Sai tên đăng nhập hoặc mật khẩu');
                window.location='login.php';
                </script>";
        }
    } else {
        echo "<script language='javascript'>
            alert('Email và mật khẩu không được để trống!');
            </script>";
    }
}
?>
