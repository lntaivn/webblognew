<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Display</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="./../css/LayoutDetail.css">
    <link rel="stylesheet" href="./../css/UserProfile.css">
    <link rel="stylesheet" href="./../css/ContentArea.css">
    <link rel="stylesheet" href="./../css/interaction-panel.css">
    <script type="module" src="https://md-block.verou.me/md-block.js"></script>

</head>

<body>
    <div class="page-wrapper">

        <nav class="interaction-panel">
            <!-- Dynamic social icon data could be inserted here -->
        </nav>

        <div class="content-area">
            <header class="content-header">
                <!-- Additional header content -->
            </header>
            <div class="content-body">
                <?php
                include("../config/dbconfig.php");
                require './../vendor/autoload.php';

                function showBlog($id)
                {
                    global $kn;

                    $sql = "SELECT blog.*, user.name AS author_name, user.id_user FROM blog JOIN user ON blog.id_user = user.id_user WHERE id_blog = ?";
                    $stmt = mysqli_prepare($kn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);


                    if ($row = mysqli_fetch_assoc($result)) {
                        // Tạo một đối tượng Parsedown mới
                        $parsedown = new Parsedown();

                        // Chuyển đổi Markdown sang HTML
                        $htmlContent = $parsedown->text($row['content']);
                        // Display the blog content dynamically
                        echo '<img src="./../img/hinhanhdemo2.png" alt="Banner Image" class="wizard-image">';
                        echo '<div class="article-info">';
                        echo '<div class="author-info">';
                        echo '<img src="./../img/logo.png" alt="' . htmlspecialchars($row['author_name']) . '" class="author-image">';
                        echo '<div class="author-details">';
                        echo '<span class="author-name">' . htmlspecialchars($row['author_name']) . '</span>';
                        echo '<span class="post-date">Posted on ' . htmlspecialchars($row['date']) . '</span>';
                        echo '</div></div>';
                        echo '<h1 class="article-title">' . htmlspecialchars($row['title']) . '</h1>';
                        echo '<p class="article-summary">' . htmlspecialchars($row['summary']) . '</p>';
                        echo '<div class="article-content">' . $htmlContent . '</div>';
                        echo '<div class="tags">';
                        // Tags or other elements could be added here
                        echo '</div></div>';
                    } else {
                        echo 'Blog post not found.';
                    }
                }

                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                    showBlog($_GET['id']);
                } else {
                    echo 'Invalid blog ID.';
                }
                ?>
            </div>
        </div>

        <?php
        include("../config/dbconfig.php");
        // Giả sử bạn muốn hiển thị thông tin người dùng có id_user là 1
        $id_user = 1;

        // Truy vấn cơ sở dữ liệu để lấy thông tin người dùng
        $sql = "SELECT * FROM user WHERE id_user = ?";
        $stmt = $kn->prepare($sql);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Lấy thông tin người dùng và hiển thị
            $row = $result->fetch_assoc();
            ?>
            <aside class="user-profile">
                <!-- <img src="./img/<?php //echo htmlspecialchars($row['profile_picture']); ?>" alt="Profile Picture" -->
                <img src="./../img/logo.png" alt="Profile Picture"
                    class="profile-picture">
                <h2 class="user-name">
                    <?php echo htmlspecialchars($row['name']); ?>
                </h2>
                <button class="follow-button">Follow</button>
                <p class="user-bio">
                    <?php echo htmlspecialchars($row['bio']); ?>
                </p>
                <!-- Thông tin về công việc và ngày tham gia có thể không có sẵn trong cơ sở dữ liệu bạn cung cấp -->
                <div class="user-info">
                    <strong>WORK</strong>
                    <p>Head of Growth @ Novu</p> <!-- Đây là giả định, thay thế bằng dữ liệu thực từ cơ sở dữ liệu -->
                </div>
                <div class="user-info">
                    <strong>JOINED</strong>
                    <p>Feb 23, 2022</p> <!-- Đây là giả định, thay thế bằng dữ liệu thực từ cơ sở dữ liệu -->
                </div>
            </aside>
            <?php
        } else {
            echo "User not found.";
        }
        // Đóng kết nối
        $kn->close();
        ?>

    </div>
</body>

</html>