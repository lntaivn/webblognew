<?php
include 'config/dbconfig.php';
session_start();


$email = $_SESSION['user'];
$userQuery = "SELECT id_user FROM user WHERE email = ?";
$userStmt = mysqli_prepare($kn, $userQuery) ;
    mysqli_stmt_bind_param($userStmt, "s", $email);
    mysqli_stmt_execute($userStmt);
    $userResult = mysqli_stmt_get_result($userStmt);
    $userRow = mysqli_fetch_assoc($userResult);
    mysqli_stmt_close($userStmt);

    $id_user = $userRow['id_user'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $linkBanner = $_POST['banner'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $tags = $_POST['tags'] ?? [];
    $id_user = $userRow['id_user'];
    $TEMP_summary = ""; // Tóm tắt tạm thời

    // Chèn dữ liệu vào bảng 'blog'
    $query = "INSERT INTO blog (id_user, title, summary, content, banner) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($kn, $query)) {
        mysqli_stmt_bind_param($stmt, "issss", $id_user, $title, $TEMP_summary, $content, $linkBanner);
        mysqli_stmt_execute($stmt);
        $id_blog = mysqli_insert_id($kn); // Lấy ID của bài viết vừa được chèn
        mysqli_stmt_close($stmt);

        // Duyệt qua từng tag và chèn vào blogs_to_categories
        foreach ($tags as $tag) {
            $tag = mysqli_real_escape_string($kn, $tag);
            $query = "SELECT id_category FROM categories WHERE name = ?";
            if ($tagStmt = mysqli_prepare($kn, $query)) {
                mysqli_stmt_bind_param($tagStmt, "s", $tag);
                mysqli_stmt_execute($tagStmt);
                $result = mysqli_stmt_get_result($tagStmt);

                if ($row = mysqli_fetch_assoc($result)) {
                    $id_category = $row['id_category'];
                    $insertQuery = "INSERT INTO blogs_to_categories (id_blog, id_category) VALUES (?, ?)";
                    if ($insertStmt = mysqli_prepare($kn, $insertQuery)) {
                        mysqli_stmt_bind_param($insertStmt, "ii", $id_blog, $id_category);
                        mysqli_stmt_execute($insertStmt);
                        mysqli_stmt_close($insertStmt);
                    }
                }
                mysqli_stmt_close($tagStmt);
            }
        }

        echo "New record and category associations created successfully";
    } else {
        echo "Error: " . mysqli_error($kn);
    }

    mysqli_close($kn);
}

?>
