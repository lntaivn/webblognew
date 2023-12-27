<?php
session_start();
?>
<?php
include("../config/dbconfig.php");
if (isset($_SESSION["user"])) {
    $userId = $_SESSION["user"];

    // Đặt dấu nháy đơn xung quanh giá trị email
    $query = "SELECT * FROM user WHERE email = '$userId'";
    $result = mysqli_query($kn, $query);

    if ($result) {
        $userData = mysqli_fetch_assoc($result);
        $userName = $userData["name"];
        $userBio = !empty($userData["bio"]) ? $userData["bio"] : "404 bio not found";
        $avt = $userData["avt"];
        $userJoinDate = date("M d, Y", strtotime($userData["join_date"]));
    } else {
        echo "Không thể lấy thông tin người dùng: " . mysqli_error($kn);
    }
} else {
    // Redirect hoặc hiển thị thông báo nếu người dùng chưa đăng nhập
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="../css/header.css">
</head>

<body>
    <div class="profile__main">
        <header class="header">
            <div class="header-with-search">
                <div class="header__logo">
                    <div class="header__logo-img">
                        <img src="../img/Asset 2.png" alt="" class="header__logo-img--maxwithimg" />
                    </div>
                    <div class="header__search-input-wrap">
                        <input type="text" class="header__seach-input" placeholder="Search..." />
                        <button type="submit" class="btn-icon__search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>

                <div class="header__Login-Screate">
                    <a href="../CreateBlog.php" class="header__login">
                        <p>Create Blog</p>
                    </a>
                    <?php
                    if (isset($_SESSION["user"])) {
                        echo ("<a href='../logout.php' class='header__login'>Logout</a>
                            <a class='header__login' href='../user/profileUser.php'><i class='fa-regular fa-user'></i></i></a>
                        </a>");
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
        <div class="header__layout_profile">
            <div class="header__layout_profile_1"></div>
            <div class="header__layout_profile_2"></div>
        </div>
        <div class="profile">
            <header class="profile__header">
                <a href="edit_profil.php" class="profile__edit-button">Edit profile</a>
                <img src="<?php echo $avt; ?>" alt="Profile" class="profile__picture">
                <h1 class="profile__name">
                    <?php echo $userName; ?>
                </h1>
                <p class="profile__bio">
                    <?php echo $userBio; ?>
                </p>
                <p class="profile__joined"><i class="fa-solid fa-cake-candles"></i>Joined on Dec 14, 2023</p>
            </header>
 <!-- đây là phần làm -->

            <div class="profile__body">
                <div class="profile__stats">
                    <div class="stats__item">
                        <i class="fas fa-newspaper stats__icon"></i> 1 post published
                    </div>
                    <div class="stats__item">
                        <i class="fas fa-comments stats__icon"></i> 0 comments written
                    </div>
                    <div class="stats__item">
                        <i class="fas fa-tags stats__icon"></i> 0 tags followed
                    </div>
                </div>









         <!-- #region-->








                <div class="post-preview-grid">
                    <?php if (isset($_SESSION["user"])) {
                        $email = $_SESSION["user"];

                        // Find id_user based on email
                        $queryUser = "SELECT id_user, name, avt FROM user WHERE email = '$email'";
                        $resultUser = mysqli_query($kn, $queryUser);

                        if ($resultUser) {
                            $rowUser = mysqli_fetch_assoc($resultUser);

                            if ($rowUser) {
                                $id_user = $rowUser['id_user'];
                                $userName = $rowUser['name'];
                                $avt = $rowUser['avt'];

                                // Fetch blog posts for the user with status = 1
                                $queryBlog = "SELECT id_blog, title, summary, content, date, banner FROM blog WHERE id_user = $id_user AND status = 1";
                                $resultBlog = mysqli_query($kn, $queryBlog);

                                if ($resultBlog) {
                                    while ($rowBlog = mysqli_fetch_assoc($resultBlog)) {
                                        $id_blog = $rowBlog['id_blog'];
                                        $title = $rowBlog['title'];
                                        $summary = $rowBlog['summary'];
                                        $content = $rowBlog['content'];
                                        $date = $rowBlog['date'];
                                        $banner = $rowBlog['banner'];

                                        // Output the HTML for each blog post
                                        echo '<div class="post-preview">';
                                        echo '<img src="' . $avt . '" alt="Avatar" class="post-preview__avatar">';
                                        echo '<div class="post-preview__header">';

                                        echo '<div>';
                                        echo '<div class="post-preview__meta">';
                                        echo '<h2 class="post-preview__author">' . $userName . '</h2>';
                                        echo '<time class="post-preview__date">' . date('M d', strtotime($date)) . '</time>';
                                        echo '</div>';
                                        echo '</div>';


                                        echo '<h3 class="post-preview__title">' . $title . '</h3>';
                                        echo '<div class="post-preview__footer">';
                                        echo '<button class="post-preview__comment-btn"><i class="fa-regular fa-comment"></i>Add
                                Comment</button>';
                                        echo '<span class="post-preview__read-time"></span>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "Error fetching blog posts: " . mysqli_error($kn);
                                }
                            } else {
                                echo "No user found with the provided email.";
                            }
                        } else {
                            echo "Error fetching user data: " . mysqli_error($kn);
                        }
                    } else {
                        echo "User not logged in.";
                    } ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>