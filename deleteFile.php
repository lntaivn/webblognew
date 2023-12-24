<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $filename = $data['filename'];
    echo "File: ".$filename;
    // Đường dẫn đến file
    $filePath = "upload_Banner/" . $filename;
    echo "$filePath";
    // Xóa file
    if (file_exists($filePath)) {
        unlink($filePath);
        echo "File deleted successfully.";
    } else {
        echo "File not found.";
    }
}
?>
