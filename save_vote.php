<header class="header">
            <div class="header-with-search">
                <div class="header__logo">
                    <div class="header__logo-img">
                        <img src="img/Asset 2.png" alt="" class="header__logo-img--maxwithimg" />
                    </div>
                    <div class="header__search-input-wrap">
                        <input type="text" class="header__seach-input" placeholder="Search..." />
                        <button type="submit" class="btn-icon__search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>

                <div class="header__Login-Screate">
                    <a href="CreateBlog.php" class="header__login">
                        <p>Create Blog</p>
                    </a>
                    <?php 
                    if(isset($_SESSION["user"])){
                        echo("<a href='logout.php' class='header__login'>
                            <a class='header__login' href='./user/profileUser.php'><i class='fa-regular fa-user'></i></i></a>
                            <a class='header__login'>Logout</a>
                        </a>");
                    }
                    
                    else{
                        echo("<a href='login.php' class='header__login'>
                                <p>Login</p>
                            </a>
                            
                            <a href='register.php' class='header__CreateAcc'>
                                <p>Create Account</p>
                            </a>");
                    }
                    ?>
                    
                </div>
            </div>
        </header>
session_start();

if (!isset($_SESSION["user"])) {
  echo "<script language=javascript>
alert('Vui lòng đăng nhập!');
window.location='login.php';
</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user'])) {
    // Lấy email từ session
    $email = $_SESSION['user'];
    $id_post = $_POST['id_post'];
    $count_vote = $_POST['count_vote'];

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

            // Kiểm tra và cập nhật bảng vote
            $query = "SELECT id_vote FROM vote WHERE id_user = ? AND id_post = ?";
            if ($stmt = mysqli_prepare($kn, $query)) {
                mysqli_stmt_bind_param($stmt, "ii", $id_user, $id_post);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $existing_vote = mysqli_fetch_assoc($result);
                mysqli_stmt_close($stmt);

                if ($existing_vote) {
                    // Cập nhật bản ghi hiện có
                    $updateQuery = "UPDATE vote SET count_vote = ? WHERE id_vote = ?";
                    if ($updateStmt = mysqli_prepare($kn, $updateQuery)) {
                        mysqli_stmt_bind_param($updateStmt, "ii", $count_vote, $existing_vote['id_vote']);
                        mysqli_stmt_execute($updateStmt);
                        mysqli_stmt_close($updateStmt);
                    }
                } else {
                    // Thêm bản ghi mới
                    $insertQuery = "INSERT INTO vote (id_user, id_post, count_vote) VALUES (?, ?, ?)";
                    if ($insertStmt = mysqli_prepare($kn, $insertQuery)) {
                        mysqli_stmt_bind_param($insertStmt, "iii", $id_user, $id_post, $count_vote);
                        mysqli_stmt_execute($insertStmt);
                        mysqli_stmt_close($insertStmt);
                    }
                }
            }

            echo json_encode(['success' => true]);
        } else {
            // Email không tìm thấy id_user tương ứng
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'User not found']);
            exit;
        }
    } else {
        // Lỗi khi chuẩn bị truy vấn
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Internal server error']);
        exit;
    }
} else {
    // Người dùng chưa đăng nhập hoặc yêu cầu không phải POST
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'User not logged in or invalid request']);
    exit;
}
?>