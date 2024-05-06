<?php 
include "../../connect.php";
$query = "SELECT * FROM `danhmuc`";
$data = mysqli_query($conn, $query);
$result = array();

while($row = mysqli_fetch_assoc($data)) {
	$result[] = ($row);
	// code...
}

if (!empty($result)) {
	$response = [
		'status' => 200,
		'message' => "thành công", 
		'result' => $result
	];
} else {
	$response = [
		'status' => 201,
		'message' => "Không có danh mục", 
		'result' => $result
	];

} 

// Send JSON response
	header("Content-Type: application/json");
	echo json_encode($response);
?>
