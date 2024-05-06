<?php
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers
include "../../connect.php";

// Get the values from the request
$tenSanPham = $_POST['tenSanPham'];
$giaSanPham = $_POST['giaSanPham'];
$soLuong = $_POST['soLuong'];
$mauSac = $_POST['mauSac'];
$hinhAnh = $_POST['hinhAnh'];
$gioiTinh = $_POST['gioiTinh'];

// Ensure data safety before executing the query
$tenSanPham = mysqli_real_escape_string($conn, $tenSanPham);
$soLuong = mysqli_real_escape_string($conn, $soLuong);
$gioiTinh = mysqli_real_escape_string($conn, $gioiTinh);
$mauSac = mysqli_real_escape_string($conn, $mauSac);
$hinhAnh = mysqli_real_escape_string($conn, $hinhAnh);
$giaSanPham = mysqli_real_escape_string($conn, $giaSanPham);

// Create the SQL INSERT query
$query = "INSERT INTO sanpham (tenSanPham, soLuong, gioiTinh, mauSac, hinhAnh, giaSanPham) 
          VALUES ('$tenSanPham', '$soLuong', '$gioiTinh', '$mauSac', '$hinhAnh', '$giaSanPham')";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Query executed successfully
    $response = [
        'status' => 200,
        'message' => 'Thêm sản phẩm mới thành công'
    ];
} else {
    // Query failed
    $response = [
        'status' => 400,
        'message' => 'Thêm sản phẩm thất bại'
    ];
}

// Return the response as JSON
header("Content-Type: application/json");
echo json_encode($response);
?>
