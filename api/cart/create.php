<?php 
include "../../connect.php";


// Lấy dữ liệu từ request POST
$maSanPham = $_POST['maSanPham'];
$tenSanPham = $_POST['tenSanPham'];
$gia = $_POST['gia'];
$hinhAnh = $_POST['hinhAnh'];
$soLuong = $_POST['soLuong'];
$userId = $_POST['userId'];

// Đảm bảo rằng dữ liệu là an toàn trước khi thêm vào câu truy vấn
$maSanPham = mysqli_real_escape_string($conn, $maSanPham);
$tenSanPham = mysqli_real_escape_string($conn, $tenSanPham);
$gia = mysqli_real_escape_string($conn, $gia);
$hinhAnh = mysqli_real_escape_string($conn, $hinhAnh);
$soLuong = mysqli_real_escape_string($conn, $soLuong);
$userId = mysqli_real_escape_string($conn, $userId);

// Tạo câu truy vấn INSERT
$query = "INSERT INTO `giohang` (`userId`,`maSanPham`, `TenSanPham`, `giaSanPham`, `hinhAnh`, `soLuong`) 
          VALUES ('$userId','$maSanPham', '$tenSanPham', '$gia', '$hinhAnh', '$soLuong')";

// Thực hiện câu truy vấn
$data = mysqli_query($conn, $query);

if ($data) {
    // Xử lý khi thêm vào giỏ hàng thành công
    $response['success'] = true;
    $response['message'] = "Thành công";
} else {
    // Xử lý khi thêm vào giỏ hàng thất bại
    $response['success'] = false;
    $response['message'] = "Không thể thực hiện truy vấn.";
}

// Trả về JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>