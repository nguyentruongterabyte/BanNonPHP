<?php
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
        'success' => true,
        'message' => 'Sanpham inserted successfully'
    ];
} else {
    // Query failed
    $response = [
        'success' => false,
        'message' => 'Failed to insert sanpham'
    ];
}

// Return the response as JSON
header("Content-Type: application/json");
echo json_encode($response);
?>
