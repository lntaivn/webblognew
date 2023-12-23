<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Đăng ký tài khoản</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- MATERIAL DESIGN ICONIC FONT -->
	<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">

	<!-- STYLE CSS -->
	<link rel="stylesheet" href="css/register.css">
</head>

<body>

	<div class="wrapper" style="background-image: url('img/bg-registration-form-1.jpg');">
		<div class="inner">
			<div class="image-holder">
				<img src="img/registration-form-1.jpg" alt="">
			</div>
			<form onsubmit="return validateForm()" action="xuly_register.php" method="post">

				<h3>Đăng ký</h3>

				<div class="form-wrapper">
					<input type="text" id="name" name="name" placeholder="Tên" class="form-control">
					<i class="zmdi zmdi-account"></i>
				</div>
				<div class="form-wrapper">
					<input type="text" id="email" name="email" placeholder="Email" class="form-control">
					<i class="zmdi zmdi-email"></i>
				</div>
				<div class="form-wrapper">
					<select name="gender" id="gender" class="form-control">
						<option value="" disabled selected>Giới tính</option>
						<option value="M">Nam</option>
						<option value="F">Nữ</option>
						<option value="O">Giới tính khác</option>
					</select>
					<i class="zmdi zmdi-caret-down" style="font-size: 17px"></i>
				</div>
				<div class="form-wrapper">
					<input type="password" name="password" placeholder="Mật khẩu" class="form-control">
					<i class="zmdi zmdi-lock"></i>
				</div>
				<div class="form-wrapper">
					<input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" class="form-control">
					<i class="zmdi zmdi-lock"></i>
				</div>
				<button type="submit">Đăng ký
					<i class="zmdi zmdi-arrow-right"></i>
				</button>
			</form>
		</div>
	</div>

</body>
<script>
	function validateForm() {
		var name = document.getElementById('name').value;
		var email = document.getElementById('email').value;
		var gender = document.getElementById('gender').value;
		var password = document.getElementsByName('password')[0].value;
		var confirmPassword = document.getElementsByName('confirm_password')[0].value;

		if (name == "") {
			alert("Tên không được để trống");
			return false;
		}

		if (email == "") {
			alert("Email không được để trống");
			return false;
		}

		if (!email.match(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/)) {
			alert("Bạn đã nhập địa chỉ email không hợp lệ");
			return false;
		}

		if (gender == "") {
			alert("Vui lòng chọn giới tính");
			return false;
		}

		if (password == "") {
			alert("Mật khẩu không được để trống");
			return false;
		}

		if (password !== confirmPassword) {
			alert("Mật khẩu và xác nhận mật khẩu không khớp");
			return false;
		}

		if (password.length < 6) {
			alert("Mật khẩu phải có ít nhất 6 ký tự");
			return false;
		}

		<?php
		include("./config/dbconfig.php");

		$email = $_POST['email'];

		// Tránh SQL Injection
		$email = mysqli_real_escape_string($kn, $email);

		$sql = "SELECT COUNT(*) AS cnt FROM user WHERE email = '$email'";
		$result = mysqli_query($kn, $sql);
		$row = mysqli_fetch_array($result);

		// Kiểm tra xem có bản ghi nào trả về không
		if ($row['cnt'] > 0) {
			
		} else {
			echo ('
			alert("Email đã tồn tại");
			return false;'
		);
		}

		mysqli_close($kn);
		?>

		// Validation passed
		return true;
	}
</script>

</html>