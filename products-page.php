<?php 
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers
include "connect.php";
$page = $_POST['page'];
$total = $_POST['amount']; // cần lấy 6 sản phẩm trên 1 trang 
$pos = ($page - 1) * $total;
$query = 'SELECT * FROM `sanpham` LIMIT '.$pos.', '.$total.'';
$data = mysqli_query($conn, $query);
$result = array();

while($row = mysqli_fetch_assoc($data)) {
	$result[] = ($row);
	// code...
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

