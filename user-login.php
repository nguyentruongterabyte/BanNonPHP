<?php 
include "connect.php";
$email= $_POST['email'];
$password = $_POST['password'];

// Đảm bảo rằng dữ liệu là an toàn trước khi thêm câu truy vấn
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

// Kiểm tra nếu tài khoản tồn tại
$checkEmailQuery = "SELECT * FROM `user` WHERE `email` = '$email'";
$checkEmailResult = mysqli_query($conn, $checkEmailQuery);

if ($checkEmailResult && mysqli_num_rows($checkEmailResult) > 0) {
	// Lấy mật khẩu đã được băm từ cơ sở dữ liệu
	$user = mysqli_fetch_assoc($checkEmailResult);
	$hashedPasswordFromDB = $user['password'];

	// So sánh mật khẩu được cung cấp từ người dùng với mật khẩu băn từ cơ sở dữ liệu
	if (password_verify($password, $hashedPasswordFromDB)) {
		// Nếu mật khẩu khớp, trả về thông tin người dùng
		unset($user['password']); // Remove hashed password from the response
		$arr = [
			'success' => true,
			'message' => 'Đăng nhập thành công',
			'result' => $user
		];
	} else {
		// Nếu mật khẩu không khớp, trả về thông báo lỗi
		$arr = [
			'success' => false,
			'message' => 'Email hoặc mật khẩu không đúng'
		];
	}
} else {
	// Nếu email không tồn tại trong cơ sở dữ liệu, trả về thông báo lỗi
	$arr = [
		'success' => false,
		'message' => 'Email hoặc mật khẩu không đúng'
	];
}

print_r(json_encode($arr));
?>