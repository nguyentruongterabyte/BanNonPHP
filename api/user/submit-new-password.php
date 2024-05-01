<?php
include "../../connect.php";
if (isset($_POST['submit_password']) && $_POST['key'] && $_POST['reset']) {
	$email = $_POST['key'];
	$password = $_POST['password'];
	$oldPassword = $_POST['reset'];

	// Băm mật khẩu
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	// Kiểm tra nếu tài khoản tồn tại
	$checkEmailQuery = "SELECT * FROM `user` WHERE `email` = '$email'";
	$checkEmailResult = mysqli_query($conn, $checkEmailQuery);

	if ($checkEmailResult && mysqli_num_rows($checkEmailResult) > 0) {
		// Lấy mật khẩu đã được băm từ cơ sở dữ liệu
		$user = mysqli_fetch_assoc($checkEmailResult);
		$hashedPasswordFromDB = $user['password'];

		if ($oldPassword == $hashedPasswordFromDB) {
			// Lệnh UPDATE mật khẩu
			$updateQuery = "UPDATE `user` SET `password` = '$hashedPassword' WHERE `email` = '$email'";
			
			$data = mysqli_query($conn, $updateQuery);

			if ($data) {
				echo "Thay đổi mật khẩu thành công. Bạn có thể thoát khỏi trang web này";
			} 
		} else {
			echo "Không được resubmit biểu mẫu này";
		}
	} else {
		echo "Thay đổi mật khẩu thất bại";
	}

} else {
	echo "Biểu mẫu không hợp lệ";
}

?>