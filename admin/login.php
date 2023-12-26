<?php
include 'config/dbconfig.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Mã hóa mật khẩu với MD5

    if (!empty($email) && !empty($password)) {
        $query = "SELECT id_user, password FROM user WHERE email = ?";
        if ($stmt = mysqli_prepare($kn, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                if ($password === $row['password']) { // So sánh hash MD5
                    $_SESSION['user_id'] = $row['id_user'];
                    $_SESSION["user"] = $email;
                    header("Location: index.php");
                    exit;
                } else {
                    echo "Mật khẩu không đúng!";
                }
            } else {
                echo "Không tìm thấy người dùng với email này!";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Email và mật khẩu không thể để trống!";
    }
}
?>
