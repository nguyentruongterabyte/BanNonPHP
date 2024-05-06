<?php 
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers
include "../../connect.php";
$page = $_GET['page']; 
$total = $_GET['amount']; 
$pos = ($page - 1) * $total;
$query = 'SELECT sp.*, COALESCE(SUM(ct.soLuong), 0) AS daBan
					FROM `sanpham` sp
					LEFT JOIN `chitietdonhang` ct ON sp.maSanPham = ct.maSanPham
					WHERE sp.soLuong > 0
					GROUP BY sp.maSanPham
					ORDER BY sp.maSanPham DESC 
					LIMIT '.$pos.', '.$total.'';
$data = mysqli_query($conn, $query);
$result = array();

while($row = mysqli_fetch_assoc($data)) {
	$result[] = ($row);
}

if (!empty($result)) {
	$arr = [
		'status' => 200,
		'message' => "thành công", 
		'result' => $result
	];
} else {
	$arr = [
		'status' => 201,
		'message' => "Danh sách sản phẩm trống", 
		'result' => $result
	];
} 

header("Content-Type: application/json");
echo json_encode($arr);
?>