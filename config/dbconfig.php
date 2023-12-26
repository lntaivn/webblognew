<?php
$kn = mysqli_connect("localhost:3307", "root", "") or die("Không thể kết nối đến server");
$csdl = mysqli_select_db($kn, "blogweb") or die("Không thể chọn được được csdl online_shop" . mysqli_error($kn));
mysqli_query($kn, "SET NAMES 'utf8'");
?>