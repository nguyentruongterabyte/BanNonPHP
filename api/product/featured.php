<?php 
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers
include "../../connect.php";

if (isset($_GET["amount"])) {
	$amount = $_GET["amount"];

	$amount = mysqli_real_escape_string($conn, $amount);

	$query = "SELECT * FROM `sanpham` WHERE `soLuong` > 0 ORDER BY maSanPham DESC LIMIT $amount";
	$data = mysqli_query($conn, $query);
	$result = array();
	while($row = mysqli_fetch_assoc($data)) {
		$result[] = ($row);
	}

	if (!empty($result)) {
		$response = [
			'status' => 200,
			'message' => "Lấy danh sách sản phẩm mới thành công", 
			'result' => $result
		];
	} else {
			$response = [
			'status' => 201,
			'message' => "Danh sách sản phẩm trống", 
			'result' => $result
		];

	} 

	// Send JSON response
	header("Content-Type: application/json");
	echo json_encode($response);
} else {
	http_response_code(400);
	echo json_decode(["message" => "amount parameter is required"]);
}

?>

