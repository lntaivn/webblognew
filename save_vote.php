<?php
include("config/dbconfig.php");

session_start();

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