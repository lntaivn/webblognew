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
                    if(isset($_SESSION["user"])){
                        echo("<a href='logout.php' class='header__login'>
                            <a class='header__login' href='./user/profileUser.php'><i class='fa-regular fa-user'></i></i></a>
                            <a class='header__login'>Logout</a>
                        </a>");
                    }
                    
                    else{
                        echo("<a href='login.php' class='header__login'>
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