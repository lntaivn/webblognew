<?php
include 'config/dbconfig.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Mã hóa mật khẩu với MD5

    if (!empty($email) && !empty($password)) {
        $query = "SELECT id_user, password FROM user WHERE email = ? and position = 'admin'";
        if ($stmt = mysqli_prepare($kn, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                if ($password === $row['password']) { // So sánh hash MD5
                    // $_SESSION['user_id'] = $row['id_user'];
                    $_SESSION["admin"] = $email;
                    header("Location: index.php");
                    exit;
                } else {
                    echo "<script language=javascript>
                            alert('Mật khẩu không chính xác!');
                            window.location='login.html';
                            </script>";

                }
            } else {
                echo "<script language=javascript>
                        alert('Email không tồn tại!');
                        window.location='login.html';
                        </script>";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "<script language=javascript>
                alert('Không được để trống email và password!');
                window.location='login.html';
                </script>";
    }
}
?>