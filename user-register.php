<?php 
include "connect.php";
$email = $_POST['email'];
$password = $_POST['password'];
$username = $_POST['username'];
$mobile = $_POST['mobile'];

// Đảm bảo rằng dữ liêu là an toàn trước khi thêm câu truy vấn
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);
$username = mysqli_real_escape_string($conn, $username);
$mobile = mysqli_real_escape_string($conn, $mobile);



// Kiểm tra nếu tài khoản email đã tồn tại
$checkEmailQuery = "SELECT * FROM `user` WHERE `email` = '$email'";
$checkEmailResult = mysqli_query($conn, $checkEmailQuery);

if ($checkEmailResult && mysqli_num_rows($checkEmailResult) > 0) {
	// Nếu email đã tồn tại, trả về error response
    $arr = [
        'success' => false,
        'message' => 'Email đã tồn tại'
    ];
} else {
	// Băm mật khẩu
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	$query = "INSERT INTO `user`(`email`, `password`, `username`, `mobile`) VALUES ('$email','$hashedPassword','$username','$mobile')";

	// Thực hiện truy vấn
	$result = mysqli_query($conn, $query);

	if ($result) {

		// Truy vấn để lấy thông tin user vừa thêm vào
		$getUserQuery = "SELECT * FROM `user` WHERE `email` = '$email'";
		$getUserResult = mysqli_query($conn, $getUserQuery);

		if ($getUserResult && mysqli_num_rows($getUserResult) > 0) {
			$user = mysqli_fetch_assoc($getUserResult);
			$arr = [
	   			'success' => true,
	   			'message' => 'Thành công',
	   			'result' => $user
	   		]; 
		} else {
			$arr = [
				'success' => false,
				'message' => 'Không thể tạo được tài khoản'
			];
		}

	   
	} else {
	   $arr = [
	   		'success' => false,
	   		'message' => 'Không thành công'
	   ];
	}
}



print_r(json_encode($arr));
?>
