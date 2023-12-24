<?php
include("../config/dbconfig.php");
require './../vendor/autoload.php';

function layXepHangTrungBinh($id_bai_viet)
{
    global $kn;
    $sql = "SELECT AVG(count_vote) as average_ranking FROM vote WHERE id_post = ?";
    $stmt = $kn->prepare($sql);
    $stmt->bind_param("i", $id_bai_viet);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return round($row['average_ranking'], 1);
    }
    return 0;
}

function hienThiXepHang($id_bai_viet)
{
    global $kn;
    $xep_hang_tb = layXepHangTrungBinh($id_bai_viet);
    for ($i = 0; $i < 5; $i++) {
        if ($i < $xep_hang_tb) {
            echo '<i class="fa fa-star" style="color: gold;"></i>';
        } else {
            echo '<i class="fa fa-star" style="color: grey;"></i>';
        }
    }
}

$id_bai_viet = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Đây là phần head của tài liệu HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Display</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="./../css/LayoutDetail.css">
    <link rel="stylesheet" href="./../css/UserProfile.css">
    <link rel="stylesheet" href="./../css/ContentArea.css">
    <link rel="stylesheet" href="./../css/interaction-panel.css">
    <link rel="stylesheet" href="./../css/comment.sang.css">
    <script type="module" src="https://md-block.verou.me/md-block.js"></script>

    <style>
        .star-rating {
            display: none;
            color: gray;
            cursor: pointer;
        }

        .star-rating .star:hover,
        .star-rating .star:hover~.star {
            color: gold;
        }

        li:hover .star-rating {
            display: flex;
        }
    </style>
</head>

<body>
    <div class="page-wrapper-main">
        <div class="page-wrapper">
            <nav class="interaction-panel">
                <!-- Đây là phần navigation panel với các biểu tượng xã hội và xếp hạng -->
                <ul class="social-icons">
                    <li>
                        <!-- <i class="fa fa-star" style="color: gold;"></i>
                    <div>
                        <?php
                        // if ($id_bai_viet) {
                        //     echo layXepHangTrungBinh($id_bai_viet);
                        // }
                        ?>
                        
                    </div> -->

                        <div class="star-rating">
                            <span class="star" data-value="1">&#9733;</span>
                            <span class="star" data-value="2">&#9733;</span>
                            <span class="star" data-value="3">&#9733;</span>
                            <span class="star" data-value="4">&#9733;</span>
                            <span class="star" data-value="5">&#9733;</span>
                        </div>
                        <i class="fa fa-star" style="color: gold;"></i>
                    </li>
                    <li><i class="fa fa-comment"></i>
                        <div>19</div>
                    </li>
                    <li>
                        <div>...</div>
                    </li>
                </ul>
            </nav>
            <div class="content-area">
                <header class="content-header">
                    <!-- Đây là phần header của khu vực nội dung -->
                </header>
                <div class="content-body">
                    <!-- Đây là phần nơi nội dung bài viết sẽ được hiển thị -->
                    <!-- Khi truy vấn và hiển thị bài viết, bạn có thể gọi hàm showBlog($id_bai_viet) ở đây -->
                    <?php
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
                            echo '<div class="blog-ranking">';
                            hienThiXepHang($row['id_blog']);
                            echo '</div>';
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

                    if ($id_bai_viet) {
                        showBlog($id_bai_viet);
                    }
                    ?>
                </div>
                <div>

                </div>
            </div>

            <!-- thong tin nguoi dung -->
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
                    <img src="./../img/logo.png" alt="Profile Picture" class="profile-picture">
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

        <div class="page-wrapper-comment">
            <div class="left-comment"></div>
            <div class="center-comment">
                <?php
                include('../comment/comment.php');
                ?>
            </div>
            <div class="right-comment">

            </div>


        </div>

    </div>


</body>
<script>
    window.onload = function () {
        // Bắt sự kiện khi rê chuột vào ngôi sao
        document.querySelectorAll('.star-rating .star').forEach(item => {
            item.addEventListener('mouseover', function () {
                this.style.color = 'gold';
                let rating = this.getAttribute('data-value');
                // Thay đổi màu của tất cả các ngôi sao trước ngôi sao hiện tại
                for (let i = 0; i < rating; i++) {
                    document.querySelectorAll('.star-rating .star')[i].style.color = 'gold';
                }
            });

            item.addEventListener('mouseout', function () {
                let stars = document.querySelectorAll('.star-rating .star');
                stars.forEach(star => {
                    star.style.color = 'gray';
                });
            });

            item.addEventListener('click', function () {
                console.log("dc");
                alert("Bạn đã chọn " + this.getAttribute('data-value') + " sao.");
                // Thêm mã xử lý lưu xếp hạng vào cơ sở dữ liệu ở đây
            });
        });
    };
</script>

</html>