<?php 
include "connect.php";
$maSanPham = $_POST['maSanPham'];

// Đảm bảo rằng dữ liêu là an toàn trước khi thêm câu truy vấn
$maSanPham = mysqli_real_escape_string($conn, $maSanPham);

// Tạo câu truy vấn DELETE 
$query = "DELETE FROM `giohang` WHERE `giohang`.`maSanPham` = $maSanPham";

// Thực hiện câu truy vấn
$data = mysqli_query($conn, $query);

if ($data) {
	// Xử lý khi delete sản phẩm trong giỏ hàng thành công
	$response['success'] = true;
	$response['message'] = "Thành công";

} else {
	// Xử lý khi delete sản phẩm trong giỏ hàng thất bại
	$response['success'] = false;
	$response['message'] = "Không thể thực hiện được truy vấn";
}

// Trả về JSON response
header("Content-Type: application/json");
echo json_encode($response);
?>