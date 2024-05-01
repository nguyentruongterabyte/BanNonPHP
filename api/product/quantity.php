<?php 
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers
include "../../connect.php";
$query = "SELECT COUNT(maSanPham) as total from `sanpham` WHERE 1";
$data = mysqli_query($conn, $query);
if (!$data) {
  $response = [
    'success' => false,
    'message' => 'Error fetching data'
  ];
} else {
  $row = mysqli_fetch_assoc($data);
  $totalProducts = $row['total'];
  $response = [
    'success' => true,
    'message' => 'Successfully fetched data',
    'totalProducts' => $totalProducts
  ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>