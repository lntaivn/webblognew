
<?php
include 'config/dbconfig.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form  
    $linkBanner = isset($_POST['banner']) ? $_POST['banner'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
    $Temp_Id_User =  1;
    // Biến lưu danh sách các id_category
    $TEMP_summary = "HUNGTRAN"; // Tóm tắt tạm thời

    // Chèn dữ liệu vào bảng 'blog'

    $query = "INSERT INTO blog (id_user, title, summary, content, banner) VALUES ('$Temp_Id_User', '$title', '$TEMP_summary', '$content', '$linkBanner')";

    if (mysqli_query($kn, $query)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($kn);
    }

    $categoryIds = [];

    // Duyệt qua từng tag
    foreach ($tags as $tag) {
        // Thực hiện truy vấn để tìm id_category dựa trên tag
        $tag = mysqli_real_escape_string($kn, $tag); // Use the $kn variable from your dbconfig.php
        $query = "SELECT id_category FROM categories WHERE name = '$tag'";
        $result = mysqli_query($kn, $query);

        // Kiểm tra kết quả truy vấn
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                // Lấy id_category từ kết quả truy vấn và thêm vào mảng
                $categoryIds[] = $row['id_category'];
            }
        }
    }

    // Trả về phản hồi
    echo "Title: " . $title . "<br>";
    echo "Content: " . $content . "<br>";

    if (!empty($categoryIds)) {
        echo "Category IDs: " . implode(', ', $categoryIds);
    } else {
        echo "No category IDs found for the specified tags.";
    }
}
?>
