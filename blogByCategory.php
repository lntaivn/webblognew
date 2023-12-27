<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dev.io</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
        integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/base.css" />
    <link rel="stylesheet" href="./css/header.css" />
    <link rel="stylesheet" href="./css/bodyFlex.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;1,100;1,200;1,300&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="./css/responsive__bodyFlex.css" />
    <link rel="stylesheet" href="styles.css" />
    <script type="module" src="https://md-block.verou.me/md-block.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="path/to/your/script.js"></script>
</head>

<body>
    <div class="app">
        <header class="header">
            <div class="header-with-search">
                <div class="header__logo">
                    <div class="header__logo-img">
                        <img src="img/Asset 2.png" alt="" class="header__logo-img--maxwithimg" />
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
                        echo ("<a href='logout.php' class='header__login'>
                                <p>Logout</p>
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

        <div class="main-flex">
            <!-- <div class="body-flexFist__ row row1">
                <div class="body-flexFist__login">
                    <div class="body-flexFist__login-content">
                        <h1>DEV Community is a</h1>
                        <h1>community of</h1>
                        <h1>1,161,805 amazing</h1>
                        <h1>developers</h1>
                        <p>
                            We're a place where coders share, stay
                            up-to-date and grow their careers.
                        </p>
                    </div>
                    <div class="body-flexFist__login-button">
                        <a href="#" class="flexFist__login-button-Create">Create</a>

                        <a href="#" class="flexFist__login-button-login">login</a>
                    </div>
                </div>
            </div> -->
            <?php include 'content/leftContent.php'; ?>



            <div class="body-flexSecond__ row row2">

                <!-- time top -->
                <div class="body-flexSecond__header-time">
                    <a href="#" class="body-flexSecond__header-time-one">Relevent</a>
                    <a href="#" class="body-flexSecond__header-time-two">Latest</a>
                    <a href="#" class="body-flexSecond__header-time-three">Top</a>
                </div>

                


                <?php
                include("content/cardByCategory.php");
                ?>

            </div>
            <?php
            include('content/rightContent.php');
            ?>
        </div>
    </div>
    // Đoạn mã này nên được đặt trong một thẻ
    <script> hoặc một file.js riêng
        function loadPostsByCategory(categoryId) {
            $.ajax({
                url: 'content/cardByCategory.php', // Đảm bảo đường dẫn đến file PHP là đúng
                type: 'GET',
                data: { id: categoryId },
                success: function (response) {
                    // Giả sử bạn có một container trong HTML để chứa các bài viết
                    document.getElementById('blogContainer').innerHTML = response;
                },
                error: function (error) {
                    console.error('Error fetching posts:', error);
                }
            });
        }

        // Bắt sự kiện click trên các category
        document.querySelectorAll('.category-list li').forEach(function (li) {
            li.addEventListener('click', function () {
                var categoryId = this.getAttribute('data-category-id');
                loadPostsByCategory(categoryId);
            });
        });

</body >

</html >