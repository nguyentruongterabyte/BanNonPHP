<?php 
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
			'success' => true,
			'message' => "thành công", 
			'result' => $result
		];
	} else {
			$response = [
			'success' => false,
			'message' => "không thành công", 
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

