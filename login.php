<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CodePen - Finance Mobile Application-UX/UI Design Screen One</title>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet'
        href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
    <link rel="stylesheet" href="./css/login.css">

</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="screen-1">
        <form action="xuly_login.php" method="post">
            <svg class="logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                version="1.1" width="300" height="300" viewbox="0 0 640 480" xml:space="preserve">
                <g transform="matrix(3.31 0 0 3.31 320.4 240.4)">
                    <circle
                        style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(61,71,133); fill-rule: nonzero; opacity: 1;"
                        cx="0" cy="0" r="40"></circle>
                </g>
                <g transform="matrix(0.98 0 0 0.98 268.7 213.7)">
                    <circle
                        style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                        cx="0" cy="0" r="40"></circle>
                </g>
                <g transform="matrix(1.01 0 0 1.01 362.9 210.9)">
                    <circle
                        style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                        cx="0" cy="0" r="40"></circle>
                </g>
                <g transform="matrix(0.92 0 0 0.92 318.5 286.5)">
                    <circle
                        style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                        cx="0" cy="0" r="40"></circle>
                </g>
                <g transform="matrix(0.16 -0.12 0.49 0.66 290.57 243.57)">
                    <polygon
                        style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                        points="-50,-50 -50,50 50,50 50,-50 "></polygon>
                </g>
                <g transform="matrix(0.16 0.1 -0.44 0.69 342.03 248.34)">
                    <polygon
                        style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                        vector-effect="non-scaling-stroke" points="-50,-50 -50,50 50,50 50,-50 "></polygon>
                </g>
            </svg>
            <div class="email">
                <label for="email">Email Address</label>
                <div class="sec-2">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" id="email" name="email" placeholder="Username@gmail.com" />
                </div>
            </div>
            <div class="password">
                <label for="password">Password</label>
                <div class="sec-2">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input class="pas" type="password" id="password" name="password" placeholder="············" />
                    <ion-icon class="show-hide" id="togglePassword" name="eye-outline"></ion-icon>
                </div>
            </div>
            <button class="login" type="submit">Login</button>
        </form>
        
        <div class="footer">
            <span>Signup</span>
            <span>Forgot Password?</span>
        </div>
    </div>
    <!-- partial -->

</body>
<script>
// JavaScript để bắt sự kiện click trên icon mắt và toggle trường mật khẩu
document.getElementById('togglePassword').addEventListener('click', function (e) {
    // Lấy trường input mật khẩu
    const passwordInput = document.getElementById('password');
    // Kiểm tra kiểu hiện tại của input và chuyển đổi nó
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // Bạn có thể thêm mã để thay đổi icon nếu muốn
    } else {
        passwordInput.type = 'password';
        // Bạn có thể thêm mã để thay đổi icon nếu muốn
    }
});
</script>

</html>