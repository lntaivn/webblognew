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
    echo "<script language=javascript>
            alert('Vui lòng đăng nhập!');
            window.location='login.html';
            </script>";
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
    <style>
        .modify_card_list_port {
            display: flex;
            gap: 5px;
            justify-content: space-between;
            align-items: center;
            button {
                border: none !important;;
            }
            
        }
        .delete{
            width: 20px;
            font-size: 1.2em;

        }
        .delete:hover {
            background-color: blueviolet;
        }

    </style>
</head>

<body>
    <div class="profile__main">
        <header class="header">
            <div class="header-with-search">
                <div class="header__logo">
                    <a href="../index.php">
                        <div class="header__logo-img">
                        <a href="../index.php" style="text-decoration: none; color: #333; font-weight: bold;"><img src="../img/Asset 2.png" alt="" class="header__logo-img--maxwithimg" /></a>

                        </div>
                    </a>
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
            <?php
            $email = $_SESSION["user"];

            $query1 = "SELECT
                (SELECT COUNT(*) FROM blog b WHERE b.id_user = u.id_user) AS total_blogs,
                (SELECT COUNT(*) FROM comment c WHERE c.id_user = u.id_user) AS total_comments
              FROM user u
              WHERE u.email = '$email'";

            $result = mysqli_query($kn, $query1);

            if ($result) {
                $data = mysqli_fetch_assoc($result);
                $totalBlogs = $data["total_blogs"];
                $totalComments = $data["total_comments"];
            } else {
                echo "Không thể lấy thông tin người dùng: " . mysqli_error($kn);
            }
            ?>
            <div class="profile__body">
                <div class="profile__stats">
                    <div class="stats__item">
                        <i class="fas fa-newspaper stats__icon"></i>
                        <?php echo ($totalBlogs) ?> post published
                    </div>
                    <div class="stats__item">
                        <i class="fas fa-comments stats__icon"></i>
                        <?php echo ($totalComments) ?> comments written
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
                                        echo '<div class="modify_card_list_port"><h2 class="post-preview__author">' . $userName . '</h2><button onclick="deleteBlog(' . $id_blog . ')"><i class="fa-regular fa-delete-left delete"></i></button></div>';
                                        echo '<time class="post-preview__date">' . date('M d', strtotime($date)) . '</time>';
                                        echo '</div>';
                                        echo '</div>';


                                        echo '<h3 class="post-preview__title"><a href="../content/blog.php?id=' . $id_blog . '">' . $title . '<a/></h3>';
                                        echo '<div class="post-preview__footer">';
                                        echo '<a href="../content/blog.php?id='.$id_blog.'#comment'.'" style="text-decoration: none; color: #333; font-weight: bold;"><button class="post-preview__comment-btn"><i class="fa-regular fa-comment"></i>Add
                                        Comment</button></a>';
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
<script>
    function deleteBlog(id) {
    if (confirm('Are you sure you want to delete this blog?')) {
        var formData = new FormData();
        formData.append('id_blog', id);

        fetch('./deleteBlog.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log(response);
            alert("Success!");
            location.reload(); 
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
</script>