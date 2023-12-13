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
    <link rel="stylesheet" href="styles.css"/>
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
                        <!-- <div class="header__search-history">
            
                            
                            <h3 class="header__search-history-heading">Lich Su Tim Kiem</h3>
                            <ul class="header__search-history-list">
            
                                <li class="header__search-history-item">
                                    <a href="">Kem duong da</a>
                                </li>
                                <li class="header__search-history-item">
                                    <a href="">Kem duong da</a>
                                </li>
                                
                            </ul>
                        </div> -->
                        <button type="submit" class="btn-icon__search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>

                <div class="header__Login-Screate">
                    <a href="#" class="header__login">
                        <p>Login</p>
                    </a>
                    <a href="#" class="header__CreateAcc">
                        <p>Create Account</p>
                    </a>
                </div>
            </div>
        </header>





        <div class="main-flex">
            <div class="body-flexFist__ row row1">
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
            </div>

            <div class="body-flexSecond__ row row2">

                <!-- time top -->
                <div class="body-flexSecond__header-time">
                    <a href="#" class="body-flexSecond__header-time-one">Relevent</a>
                    <a href="#" class="body-flexSecond__header-time-two">Latest</a>
                    <a href="#" class="body-flexSecond__header-time-three">Top</a>
                </div>

                <!-- post top -->
                <div class="body-flexSecond__Post">

                    <div class="body-flexSecond__Post-img"></div>
                    <div class="body-flexSecond__Post-by-user">

                        <div class="body-flexSecond__Post-user-avatar"></div>

                        <div class="body-flexSecond__Post-user-name">
                            <span class="body-flexSecond__Post-user-name-abbreviations">Mamadou DICKO</span>
                            for
                            <span class="body-flexSecond__Post-user-name-fullname">Serverless By Theodo</span>
                            <br />
                            Posted on Oct 10
                        </div>

                    </div>

                    <?php
                    include("content.php");
                    include("config/dbconfig.php");
                    $sql = "select * from  blog";
                    $kq = mysqli_query($kn, $sql);


                    while ($row = mysqli_fetch_array($kq)) {
                        echo ("<div>");

                        echo ("<h3>" . $row["title"]);
                        echo ("</div>");
                    }
                    ?>


                    <!-- <div class="body-flexSecond__Post-by-user-content">

                    </div> -->

                    <div class="body-flexSecond__TOP-Post">
                        <div class="body-flexSecond__Top-name-tags">
                            <a href="#" class="body-flexSecond__Top-name-tags-one">#javascript</a>
                            <a href="#" class="body-flexSecond__Top-name-tags-two">#aws</a>
                            <a href="#" class="body-flexSecond__Top-name-tags-three">#serverless</a>
                            <a href="#" class="body-flexSecond__Top-name-tags-four">#tutorial</a>
                        </div>
                    </div>

                </div>




            </div>

            <!-- <div class="body-flex__third">
                     <h1>hung</h1>
            </div> -->
            <div class="body-flexFist__ row row3">
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
            </div>
        </div>
    </div>
</body>

</html>