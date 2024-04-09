<?php 
include "connect.php";
$token = $_POST['token'];
$idDonHang = $_POST['id'];

$query = 'UPDATE `donhang` SET `token`= "'.$token.'" WHERE `maDonHang` = '.$idDonHang.'';
$data = mysqli_query($conn, $query);

if ($data) {
	$arr = [
		'success' => true,
		'message' => 'Thành công'
	];
} else {
	$arr = [
		'success' => false,
		'message' => 'Không thể thực hiện được truy vấn'
	];
}

print_r(json_encode($arr));
?>