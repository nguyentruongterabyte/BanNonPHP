<?php
include "connect.php";
$userId = $_POST["userId"];

// Đảm bảo truy vấn an toàn
$userId = mysqli_real_escape_string($conn, $userId);

$query = "SELECT * FROM `giohang` WHERE `userId` = $userId";
$data = mysqli_query($conn, $query);
$result = array();

while($row = mysqli_fetch_assoc($data)) {
	$result[] = ($row);
}

if (!empty($result)) {
	$arr = [
		'success' => true,
		'message' => "thành công",
		'result' => $result
	];
} else {
	$arr = [
		'success' => false,
		'message' => "không thành công",
		'result' => $result
	];
}

print_r(json_encode($arr))
?>