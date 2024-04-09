<?php 
include "connect.php";

// Lấy dữ liệu từ request PUT
$maSanPham = $_POST['maSanPham'];
$gia = $_POST['gia'];
$soLuong = $_POST['soLuong'];

// Đảm bảo rằng dữ liệu là an toàn trước khi thêm câu truy vấn
$maSanPham = mysqli_real_escape_string($conn, $maSanPham);
$gia = mysqli_real_escape_string($conn, $gia);
$soLuong = mysqli_real_escape_string($conn, $soLuong);

// Tạo câu truy vấn UPDATE
$query = "UPDATE `giohang` SET `giaSanPham` = '$gia', `soLuong` = '$soLuong' WHERE `giohang`.`maSanPham` = $maSanPham";

// Thực hiện câu truy vấn
$data = mysqli_query($conn, $query);
if ($data) {
	// Xử lý khi update sản phẩm trong giỏ hàng thành công
	$response['success'] = true;
	$response['message'] = "Thành công";
} else {
	// Xử lý khi update sản phẩm trong giỏ hàng thất bại
	$response['success'] = false;
	$response['message'] = "Không thể thực hiện được truy vấn";
}

// Trả về JSON response
header("Content-Type: application/json");
echo json_encode($response);
?>