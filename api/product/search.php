<?php 
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers

include "../../connect.php";
if (isset($_GET["key"])) {
	$key = $_GET["key"];

	$key = mysqli_real_escape_string($conn, $key);
	
	$query = "SELECT * FROM `sanpham` WHERE `tenSanPham` LIKE '%".$key."%'";
	$data = mysqli_query($conn, $query);

	$result = array();

	while($row = mysqli_fetch_assoc($data)) {
		$result[] = ($row);
		// code...
	}

	if (!empty($result)) {
		$response = [
			'status' => 200,
			'message' => "Thành công", 
			'result' => $result
		];
	} else {
		$response = [
			'status' => 201,
			'message' => "Không tìm thấy kết quả", 
			'result' => $result
		];
	} 

	// Send JSON response
	header("Content-Type: application/json");
	echo json_encode($response);

} else {
	// If key is not provided in the URL, return an error response
	http_response_code(400); // Bad Request
	echo json_encode(["message" => "key parameter is required"]);
}


?>