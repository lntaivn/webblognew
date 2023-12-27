<?php
session_start();
?>
<?php
include("../config/dbconfig.php");
require './../vendor/autoload.php';

$id_bai_viet = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;
$query = "SELECT u.id_user, u.email FROM blog b JOIN user u ON b.id_user = u.id_user WHERE b.id_blog = ?";
$stmt = $kn->prepare($query);
$stmt->bind_param("i", $id_bai_viet);
$stmt->execute();

$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
      $id_user = $row['id_user'];
      $email = $row['email'];
} else {
      echo "Không tìm thấy bài viết với ID: " . $id_bai_viet;
}

$stmt->close();

$sql = "SELECT 
    (SELECT round(AVG(count_vote),0) FROM vote WHERE id_post = $id_bai_viet) AS average_ranking,
    (SELECT COUNT(*) FROM comment WHERE id_post = $id_bai_viet) AS number_of_comments;";
$stmt = $kn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$ranking = $row["average_ranking"];
$comment = $row["number_of_comments"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
      <!-- Đây là phần head của tài liệu HTML -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Blog Display</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 
      <link rel="stylesheet" href="./../css/LayoutDetail.css">
      <link rel="stylesheet" href="./../css/UserProfile.css">
      <link rel="stylesheet" href="./../css/ContentArea.css">
      <link rel="stylesheet" href="./../css/interaction-panel.css">
      <link rel="stylesheet" href="./../css/comment.sang.css">
      <link rel="stylesheet" href="./../css/header.css">
      <link rel="stylesheet" href="./../css/base.css">
      <script type="module" src="https://md-block.verou.me/md-block.js"></script>

      <style>
            html {
                  scroll-behavior: smooth;
            }

            .interaction-panel {
                  text-align: center;
            }

            .content-start-rating {
                  display: flex;
                  position: relative;
            }

            .star-rating {
                  display: none;
                  color: gray;
                  cursor: pointer;
                  z-index: 1;
                  position: absolute;
                  top: 0;
                  left: 0;
                  margin-left: 28px;
            }

            .star {
                  font-size: 1.5em;
            }

            .star-rating .star:hover,
            .star-rating .star:hover~.star {
                  color: gold;
            }

            li:hover .star-rating {
                  display: flex;

            }

            a i {
                  color: black;
            }

            .wizard-image,.user-list-img{
                  max-width: 100%;
                  max-height: 339px;
             
            }
            .article-content img {
                  max-width: 100%;
                  max-height: 339px;
            }
            .user-list-img {
                  max-width: 50px !important;
                  max-height: 50px !important;
                  border-radius: 50%;
            }
            .article-content {
                  
                  max-width: 950px;
                  overflow-wrap: break-word; /* Breaks the words to prevent overflow */
                  word-wrap: break-word; /* Deprecated version of the above property for cross-browser support */
                  margin: auto; /* Centers the content if it's smaller than the max-width */
                  font-size: 1.06em;
                  font-family:sans-serif;
                  line-height: 1.15;
                  text-align: justify;
                  }
            .edit_bloger {
                  max-width: 950px;
                  width: 950px;
                  display: flex;
                  justify-content: end;

                  a {
                        margin-right: 20px;
                        margin-top: 20px;
                  }
            }

            .tags_list {
                  display: flex;
                  gap: 5px;
            }
            .page-wrapper {
                  margin-top: 60px;
            }
      </style>
</head>

<body>
<header class="header">
            <div class="header-with-search">
                <div class="header__logo">
                    <div class="header__logo-img">
                    <a href="../index.php" style="text-decoration: none; color: #333; font-weight: bold;">
                        <img src="../img/Asset 2.png" alt="" class="header__logo-img--maxwithimg" />
                    </a>
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
                    if (isset($_SESSION["user"])) {
                        echo ("<a href='logout.php' class='header__login'>Logout</a>
                            <a class='header__login' href='../user/profileUser.php'><i class='fa-regular fa-user'></i></i></a>
                            ");
                    } else {
                        echo ("<a href='login.php' class='header__login'>
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
      <div class="page-wrapper">
            <nav class="interaction-panel">
                  <!-- Đây là phần navigation panel với các biểu tượng xã hội và xếp hạng -->
                  <ul class="social-icons">
                        <li>

                              <div class="content-start-rating">
                                    <i class="fa fa-star" style="color: gold;"></i>

                                    <div class="star-rating">
                                          <span class="star" data-value="1">&#9733;</span>
                                          <span class="star" data-value="2">&#9733;</span>
                                          <span class="star" data-value="3">&#9733;</span>
                                          <span class="star" data-value="4">&#9733;</span>
                                          <span class="star" data-value="5">&#9733;</span>
                                    </div>

                              </div>
                              <div>
                                    <?php
                                    echo $ranking;
                                    ?>
                              </div>

                        </li>
                        <li><a href="#comment"><i class="fa fa-comment"></i></a>
                              <div>
                                    <?php echo $comment; ?>
                              </div>
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
                        function getBlogTags($id_blog)
                        {
                              global $kn;

                              $query = "SELECT c.name FROM categories c 
                             JOIN blogs_to_categories btc ON c.id_category = btc.id_category 
                             WHERE btc.id_blog = ?";
                              $stmt = mysqli_prepare($kn, $query);
                              mysqli_stmt_bind_param($stmt, "i", $id_blog);
                              mysqli_stmt_execute($stmt);
                              $result = mysqli_stmt_get_result($stmt);

                              $tags = [];
                              while ($row = mysqli_fetch_assoc($result)) {
                                    $tags[] = $row['name'];
                              }

                              return $tags;
                        }
                        function showBlog($id, $email)
                        {
                              global $kn;

                              $sql = "SELECT blog.*, user.name AS author_name, user.id_user As hung, user.avt as hungave ,  blog.banner FROM blog JOIN user ON blog.id_user = user.id_user WHERE id_blog = ?";
                              
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
                                    echo '<img src="../' . $row["banner"] . '" alt="Banner Image" class="wizard-image">';
                                    if (isset($_SESSION["user"]) && $_SESSION["user"] == $email) {
                                          // Hiển thị nút chỉnh sửa
                                          echo '<div class="edit_bloger"><a href="../edit_blog.php?id=' . $id . '" class="edit-button">Edit</a></div>';
                                    }
                                    echo '<div class="article-info">';
                                    echo '<div class="blog-ranking">';
                                    echo '</div>';
                                    echo '<div class="author-info">';
                                    echo '<img src="' . $row["hungave"] . '" alt="User Avatar" class="user-list-img">';
                                    echo '<div class="author-details">';
                                    echo '<span class="author-name">' . htmlspecialchars($row['author_name']) . '</span>';
                                    echo '<span class="post-date">Posted on ' . htmlspecialchars($row['date']) . '</span>';
                                    echo '</div></div>';
                                    echo '<h1 class="article-title">' . htmlspecialchars($row['title']) . '</h1>';
                                    echo '<p class="article-summary">' . htmlspecialchars($row['summary']) . '</p>';

                                    echo '<div class="article-content">' . $htmlContent . '</div>';
                                    echo '<div class="tags">';
                                    $tags = getBlogTags($id);
                                    echo '<div class="tags_list">';
                                    foreach ($tags as $tag) {
                                          $tagId = str_replace(' ', '-', $tag);
                                          echo '<span class="tag" id="tag-' . htmlspecialchars($tagId) . '">' . htmlspecialchars($tag) . '</span>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                    
                                    echo '</div>';
                              } else {
                                    echo 'Blog post not found.';
                              }
                        }

                        if ($id_bai_viet) {
                              showBlog($id_bai_viet, $email);
                        }
                        ?>

                  </div>
                  <div class="center-comment">
                        <?php
                        include('../comment/comment.php');
                        ?>
                  </div>
            </div>

            <!-- thong tin nguoi dung -->
            <?php
            include("../config/dbconfig.php");

            $sql = "SELECT * FROM user WHERE id_user = ?";
            $stmt = $kn->prepare($sql);
            $stmt->bind_param("i", $id_user);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                  $row = $result->fetch_assoc();
                  ?>
                  <aside class="user-profile">
                        <!-- <img src="./img/<?php //echo htmlspecialchars($row['profile_picture']); ?>" alt="Profile Picture" -->

                        <img src="<?php echo htmlspecialchars($row['avt']); ?>" alt="Profile Picture" class="profile-picture">
                        <?php
                        if (isset($_SESSION["user"]) && $_SESSION["user"] == $email) {
                              ?>
                              <a href="../user/profileUser.php" style="text-decoration: none; color: #333; font-weight: bold;">
                                    <h2 class="user-name">
                                          <?php echo htmlspecialchars($row['name']); ?>
                                    </h2>
                              </a>
                              <a href="../user/profileUser.php" style="text-decoration: none; color: #333; font-weight: bold;">
                              <button class="follow-button">Edit profile</button></a>
                              <p class="user-bio">
                                    <?php echo htmlspecialchars($row['bio']); ?>
                              </p>
                              <?php
                        } else {
                              ?>
                              <a href="../user/profile.php?id_user=<?php echo htmlspecialchars($row['id_user']); ?>"
                                    style="text-decoration: none; color: #333; font-weight: bold;">
                                    <h2 class="user-name">
                                          <?php echo htmlspecialchars($row['name']); ?>
                                    </h2>
                              </a>
                              <button class="follow-button">Follow</button>
                              <p class="user-bio">
                                    <?php echo htmlspecialchars($row['bio']); ?>
                              </p>
                              <?php
                        }
                        ?>


                        <div class="user-info">
                              <strong>WORK</strong>
                              <p>Head of Growth @ Novu</p>

                        </div>
                        <div class="user-info">
                              <strong>JOINED</strong>
                              <p>Feb 23, 2022</p>
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
<script>
      window.onload = function () {
            // Bắt sự kiện khi rê chuột vào ngôi sao
            document.querySelectorAll('.star-rating .star').forEach(item => {
                  item.addEventListener('mouseover', function () {
                        this.style.color = 'gold';
                        let rating = this.getAttribute('data-value');
                        // Thay đổi màu của tất cả các ngôi sao trước ngôi sao hiện tại
                        for (let i = 0; i < rating; i++) {
                              document.querySelectorAll('.star-rating .star')[i].style.color =
                                    'gold';
                        }
                  });

                  item.addEventListener('mouseout', function () {
                        let stars = document.querySelectorAll('.star-rating .star');
                        stars.forEach(star => {
                              star.style.color = 'gray';
                        });
                  });

                  item.addEventListener('click', function () {
                        let count_vote = this.getAttribute('data-value');
                        let id_post = 1;

                        fetch('../save_vote.php', {
                              method: 'POST',
                              headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                              },
                              body: `id_post=${id_post}&count_vote=${count_vote}`
                        })
                              .then(response => {
                                    if (!response.ok) {
                                          throw new Error('Network response was not ok ' +
                                                response.statusText);
                                    }
                                    return response
                                          .text(); // Sử dụng text() nếu bạn nghi ngờ kết quả không phải JSON
                              })
                              .then(text => {
                                    try {
                                          const data = JSON.parse(
                                                text); // Cố gắng parse text thành JSON
                                          alert("Bạn đã chọn " + count_vote + " sao.");
                                    } catch (error) {
                                          console.error('Error parsing JSON:', text);
                                          throw new Error('Error parsing JSON: ' + error);
                                    }
                              })
                              .catch(error => {
                                    console.error('Error:', error);
                              });

                  });
            });
      };
</script>

</html>