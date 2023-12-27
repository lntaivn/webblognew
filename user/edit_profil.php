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
        $userBio = $userData["bio"];
        $avt = $userData["avt"];
        $avt_temp = $avt;
        $email = $userData["email"];
        $password = $userData["password"];
    } else {
        echo "Không thể lấy thông tin người dùng: " . mysqli_error($kn);
    }
} else {

    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    $target_dir = "../upload_Img_User/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    if (isset($_SESSION['temp_avt']) && file_exists($_SESSION['temp_avt'])) {
        unlink($_SESSION['temp_avt']);
    }

    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $hashedFilename = uniqid('img_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $hashedFilename;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $_SESSION['temp_avt'] = $target_file;
        echo $target_file;
    } else {
        echo "Error uploading file.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

      <link rel="stylesheet" href="../css/header.css">
      <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="edit_profil.css">
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
    <div class="edit__profile_main">
        <div class="sidebar">
            <ul class="sidebar__menu">
                <li class="menu__item">
                    <i class="fas fa-smile menu__icon"></i>
                    Profile
                </li>
                <li class="menu__item">
                    <i class="fas fa-paint-brush menu__icon"></i>
                    Customization
                </li>
                <li class="menu__item">
                    <i class="fas fa-bell menu__icon"></i>
                    Notifications
                </li>
                <li class="menu__item">
                    <i class="fas fa-user menu__icon"></i>
                    Account
                </li>
                <li class="menu__item">
                    <i class="fas fa-building menu__icon"></i>
                    Organization
                </li>
                <li class="menu__item">
                    <i class="fas fa-puzzle-piece menu__icon"></i>
                    Extensions
                </li>
            </ul>
        </div>

        <div class="user-form">
            <h2 class="user-form__title">User</h2>
            <form>
                <label for="name" class="user-form__label">Name</label>
                <input type="text" id="name" class="user-form__input" value="<?php echo $userName ?>">

                <label for="email" class="user-form__label">Email</label>
                <input type="email" id="email" class="user-form__input" value="<?php echo $email ?>">

                <label for="bio" class="user-form__label">Bio</label>
                <input type="text" id="bio" class="user-form__input" value="<?php echo $userBio ?>">

                <label for="profile-image" class="user-form__label">Profile image</label>
                <div class="img__user_form">

                    <img src="<?php echo $avt; ?>" alt="Profile" class="profile__picture" id="profileImage">
                    <input type="file" id="profile-image" class="user-form__input user-form__input--file">

                </div>
                <div class="button-container">
                    <button type="submit" class="save-button">Save Profile Information</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<script>

    document.getElementById('profile-image').addEventListener('change', function () {

        var formData = new FormData();
        formData.append('fileToUpload', this.files[0]);

        fetch('edit_profil.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(filePath => {
                document.getElementById('profileImage').src = filePath.trim();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
<script>
    function saveProfile() {
        var fileInput = document.getElementById('profile-image');

        console.log(fileInput.files[0]);
        if (confirm('Bạn có muốn lưu thông tin này không?')) {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var bio = document.getElementById('bio').value;
            var fileInput = document.getElementById('profile-image');

            var formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('bio', bio);

            if (fileInput.files.length > 0) {
                formData.append('profile-image', fileInput.files[0]);
            }
            fetch('processUpdate.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(response => {
                    if (response.includes("thành công")) {
                        var oldImagePath = "<?php echo $avt_temp?>";
                        fetch('delete_image.php', {
                            method: 'POST',
                            body: JSON.stringify({ path: oldImagePath })
                        })
                            .then(response => response.text())
                            .then(deleteResponse => {
                                console.log(deleteResponse);
                            })
                            .catch(error => console.error('Error:', error));
                    } else {
                        console.log(response);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            console.log('Người dùng đã hủy thao tác cập nhật.');
        }
    }
    document.querySelector('.save-button').addEventListener('click', function (event) {
        event.preventDefault();
        saveProfile();
    });
</script>