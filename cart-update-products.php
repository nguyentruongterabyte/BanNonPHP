<?php 
include "connect.php";

// Lấy dữ liệu từ request PUT
$maSanPham = $_POST['maSanPham'];
$userId = $_POST['userId'];
$gia = $_POST['gia'];
$soLuong = $_POST['soLuong'];

// Đảm bảo rằng dữ liệu là an toàn trước khi thêm câu truy vấn
$maSanPham = mysqli_real_escape_string($conn, $maSanPham);
$userId = mysqli_real_escape_string($conn, $userId);
$gia = mysqli_real_escape_string($conn, $gia);
$soLuong = mysqli_real_escape_string($conn, $soLuong);


// Kiểm tra số lượng của sản phẩm có mã sản phẩm là `maSanPham`
$checkQuantityQuery = "SELECT soLuong FROM `sanpham` WHERE `maSanPham` = '$maSanPham'";
$checkQuantityResult = mysqli_query($conn, $checkQuantityQuery);

if ($checkQuantityResult) {
	$row = mysqli_fetch_assoc($checkQuantityResult);
	$quantityInDatabase = $row['soLuong'];
	// So sánh số lượng sản phẩm trong csdl với số lượng từ request
	if ($quantityInDatabase >= $soLuong) {
		// Nếu số lượng sản phẩm trong csdl đủ, tiến hành cập nhật giỏ hàng
		// Tạo câu truy vấn UPDATE
		$query = "UPDATE `giohang` SET `giaSanPham` = '$gia', `soLuong` = '$soLuong' WHERE `userId` = $userId AND `maSanPham` = $maSanPham";

	} else {
		// Nếu số lượng trong csdl không đủ thì cập nhật giỏ hàng với số lượng sản phẩm = `$quantityInDatabase`
		// Tạo câu truy vấn UPDATE
		$query = "UPDATE `giohang` SET `giaSanPham` = '$gia', `soLuong` = '$quantityInDatabase' WHERE `userId` = $userId AND `maSanPham` = $maSanPham";
	}
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
} else {
	$response['success'] = false;
	$response['message'] = "Không thể thực hiện được truy vấn";
}


// Trả về JSON response
header("Content-Type: application/json");
echo json_encode($response);
?>