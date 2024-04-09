<?php 
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers

include "connect.php";

// Query to count the total number of products
$query = "SELECT COUNT(maSanPham) AS total FROM `sanpham` WHERE 1";
$result = mysqli_query($conn, $query);

if (!$result) {
	$response = [
		'success' => false,
		'message' => 'Error fetching data'
	];

	echo json_encode($response);
	exit;
}

$row = mysqli_fetch_assoc($result);
$totalProducts = $row['total'];

$response = [
	'success' => true,
	'message' => 'Successfully fetched data',
	'totalProducts' => $totalProducts
];

echo json_encode($response);
?>