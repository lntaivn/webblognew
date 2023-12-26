<?php
include 'config/dbconfig.php';
session_start();

$email = $_SESSION['user'];
$id_user = findUserIdByEmail($email);
echo $id_user;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $linkBanner = $_POST['banner'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $id_blog = $_POST['id_Bog'] ?? '';

    $query = "UPDATE blog SET title = ?, content = ?, banner = ? WHERE id_blog = ?";
    if ($stmt = mysqli_prepare($kn, $query)) {
        mysqli_stmt_bind_param($stmt, "sssi", $title, $content, $linkBanner, $id_blog);

        // Thực thi truy vấn
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "Bài viết đã được cập nhật thành công.";
        } else {
            echo "Lỗi cập nhật bài viết: " . mysqli_error($kn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Lỗi chuẩn bị truy vấn: " . mysqli_error($kn);
    }


    // echo "title: " .$title;
    // echo "content: " .$content;
    // echo "id_Bog".$id_blog;
    $tags = $_POST['tags'] ?? [];
    $desiredCategories = findCategoryIdsByNames($tags);
}
function findUserIdByEmail($email) {
    global $kn;
    // Chuẩn bị truy vấn
    $query = "SELECT id_user FROM user WHERE email = ?";
    if ($stmt = mysqli_prepare($kn, $query)) {
        // Gắn tham số cho truy vấn
        mysqli_stmt_bind_param($stmt, "s", $email);

        // Thực thi truy vấn
        mysqli_stmt_execute($stmt);

        // Lưu kết quả
        $result = mysqli_stmt_get_result($stmt);

        // Lấy ra id_user
        if ($row = mysqli_fetch_assoc($result)) {
            $id_user = $row['id_user'];
            mysqli_stmt_close($stmt);
            return $id_user;
        } else {
            // Không tìm thấy user với email này
            mysqli_stmt_close($stmt);
            return null;
        }
    } else {
        // Lỗi chuẩn bị truy vấn
        return null;
    }
}
function findCategoryIdsByNames($names) {
    global $kn;  // Sử dụng biến kết nối cơ sở dữ liệu toàn cục

    $ids = [];
    foreach ($names as $name) {
        $query = "SELECT id_category FROM categories WHERE name = ?";
        if ($stmt = mysqli_prepare($kn, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $ids[$name] = $row['id_category'];
            }
            mysqli_stmt_close($stmt);
        }
    }
    return $ids;
}
 // Ví dụ: [1, 2, 3]

// Lấy danh sách danh mục hiện tại từ cơ sở dữ liệu
$currentCategories = [];
$query = "SELECT id_category FROM blogs_to_categories WHERE id_blog = ?";
if ($stmt = mysqli_prepare($kn, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $id_blog);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $currentCategories[] = $row['id_category'];
    }
    mysqli_stmt_close($stmt);
}

// Thêm danh mục mới
foreach ($desiredCategories as $catId) {
    if (!in_array($catId, $currentCategories)) {
        $insertQuery = "INSERT INTO blogs_to_categories (id_blog, id_category) VALUES (?, ?)";
        if ($insertStmt = mysqli_prepare($kn, $insertQuery)) {
            mysqli_stmt_bind_param($insertStmt, "ii", $id_blog, $catId);
            mysqli_stmt_execute($insertStmt);
            mysqli_stmt_close($insertStmt);
        }
    }
}

// Xóa danh mục không cần thiết
foreach ($currentCategories as $catId) {
    if (!in_array($catId, $desiredCategories)) {
        $deleteQuery = "DELETE FROM blogs_to_categories WHERE id_blog = ? AND id_category = ?";
        if ($deleteStmt = mysqli_prepare($kn, $deleteQuery)) {
            mysqli_stmt_bind_param($deleteStmt, "ii", $id_blog, $catId);
            mysqli_stmt_execute($deleteStmt);
            mysqli_stmt_close($deleteStmt);
        }
    }
}
?>
