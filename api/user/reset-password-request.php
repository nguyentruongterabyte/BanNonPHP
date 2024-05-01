<?php 
include "../../connect.php";
include "../../secret.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';


$email = $_POST["email"];

// Đảm bảo rằng dữ liệu là an toàn trước khi thêm câu truy vấn
$email = mysqli_real_escape_string($conn, $email);

// Kiểm tra nếu tài khoản tồn tại
$checkEmailQuery = "SELECT * FROM `user` WHERE `email` = '$email'";
$checkEmailResult = mysqli_query($conn, $checkEmailQuery);


if ($checkEmailResult && mysqli_num_rows($checkEmailResult) > 0) {
	// send mail
	$user = mysqli_fetch_assoc($checkEmailResult);
	$emailResult = $user["email"];
	$passwordResult = $user["password"];

	// Tạo link khi người dùng nhấn vào sẽ gọi api reset mật khẩu
	$link = "http://10.252.5.172/bannon/user-reset-password.php?key=".$emailResult."&reset=".$passwordResult."";
	// HTML email body
$body = '
	<!DOCTYPE html>
	<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title>Password Reset</title>
	    <style>
	        body {
	            font-family: Arial, sans-serif;
	            line-height: 1.6;
	            margin: 0;
	            padding: 0;
	            background-color: #f4f4f4;
	        }
	        .container {
	            max-width: 600px;
	            margin: 30px auto;
	            padding: 20px;
	            background-color: #fff;
	            border-radius: 8px;
	            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
	        }
	        .logo {
	            text-align: center;
	            margin-bottom: 20px;
	        }
	        .logo img {
	            width: 120px;
	        }
	        .message {
	            padding: 20px;
	            border-radius: 8px;
	            background-color: #f0f0f0;
	            text-align: center;
	        }
	        .btn {
	            display: inline-block;
	            padding: 10px 20px;
	            text-decoration: none;
	            background-color: #007bff;
	            color: #fff;
	            border-radius: 5px;
	        }
	    </style>
	</head>
	<body>
	    <div class="container">
	        <div class="logo">
	            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQWpi3Ta6z2nsp0z0JbzozBH83y-LJjwIqm1xipJl8V5_IJMcSlbOjmLWX88Q&s" alt="Logo">
	        </div>
	        <div class="message">
	            <p>Chào bạn,</p>
	            <p>Bạn nhận được email này vì bạn đã yêu cầu đặt lại mật khẩu cho tài khoản của mình.</p>
	            <p>Vui lòng nhấn vào nút bên dưới để đặt lại mật khẩu của bạn:</p>
	            <p><a class="btn" href="'.$link .'">Đặt lại mật khẩu</a></p>
	            <p>Nếu bạn không yêu cầu thay đổi mật khẩu, vui lòng bỏ qua email này.</p>
	        </div>
	    </div>
	</body>
	</html>
	';

	$mail = new PHPMailer();
	$mail -> CharSet = 'utf-8';
	$mail -> isSMTP();
	// enable SMTP authentication
	$mail -> SMTPAuth = true;

	// Gmail username
	$mail -> Username = $smtpEmail;
	// Gmail password
	$mail -> Password = $smtpPassword;
	$mail -> SMTPSecure = "ssl";

	// Set gmail as the SMTP server
	$mail -> Host = "smtp.gmail.com";
	// Set the SMTP port for the gmail server
	$mail -> Port = "465";
	$mail -> From = $smtpEmail;
	$mail -> FromName = "App bán nón";
	$mail -> AddAddress($emailResult, 'receiver_name');
	$mail -> Subject = "Đặt lại mật khẩu";	
	$mail -> IsHTML(true);
	$mail -> Body = $body;

	if ($mail -> Send()) {
		$arr = [
			'success' => true,
			'message' => "Vui lòng kiểm tra email của bạn để đặt mật khẩu"
		];
	} else {
		$arr = [
			'success' => false,
			'message' => "Đã có lỗi xảy ra với gửi mail"
		];
	}

} else {
	$arr = [
		'success' => false,
		'message' => 'Email không tồn tại'
	];
}

// Send JSON response
    header("Content-Type: application/json");
    echo json_encode($arr);
?>