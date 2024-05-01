<?php 
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers
include "../../connect.php";
$page = $_GET['page']; 
$total = $_GET['amount']; 
$pos = ($page - 1) * $total;
$query = 'SELECT * FROM `sanpham` WHERE `soLuong` > 0 ORDER BY `maSanPham` DESC LIMIT '.$pos.', '.$total.'';
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

header("Content-Type: application/json");
echo json_encode($arr);
?>