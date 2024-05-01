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
?>
