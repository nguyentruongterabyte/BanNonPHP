<?php 
include "connect.php";

$sdt = $_POST['sdt'];
$email = $_POST['email'];
$tongTien = $_POST['tongTien'];
$diaChi = $_POST['diaChi'];
$soLuong = $_POST['soLuong'];
// $idUser = $_POST['idUser'];
$chiTiet = $_POST['chiTiet'];

// Đảm bảo rằng dữ liêu là an toàn trước khi thêm câu truy vấn
$sdt = mysqli_real_escape_string($conn, $sdt);
$email = mysqli_real_escape_string($conn, $email);
$tongTien = mysqli_real_escape_string($conn, $tongTien);
$diaChi = mysqli_real_escape_string($conn, $diaChi);
$soLuong = mysqli_real_escape_string($conn, $soLuong);
// $idUser = mysqli_real_escape_string($conn, $idUser);


// Tạo câu truy vấn INSERT
$query = "INSERT INTO `donhang`( `diaChi`, `soLuong`, `tongTien`, `soDienThoai`, `email`) VALUES ('$diaChi','$soLuong','$tongTien','$sdt','$email')";

// $query = "INSERT INTO `donhang`( `idUser`, `diaChi`, `soLuong`, `tongTien`, `soDienThoai`, `email`) VALUES ('$idUser','$diaChi','$soLuong','$tongTien','$sdt','$email')";


// Thực hiện câu truy vấn
$data = mysqli_query($conn, $query);
if ($data) {
	$query = "SELECT maDonHang FROM `donhang` ORDER BY maDonHang DESC LIMIT 1";

	// $query = "SELECT maDonHang FROM `donhang` WHERE `idUser` = '$idUser' ORDER BY maDonHang DESC LIMIT 1";

	$data = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_assoc($data)) {
		// Lấy mã đơn hàng từ câu truy vấn
		$result = ($row);
		// print_r($result['maDonHang']);
	}

	// có đơn hàng
	if (!empty($result)) {
		$mangChiTiet = json_decode($chiTiet, true); // true là để chuyển chuỗi json về mảng
		// Lặp qua tất cả mảng chi tiết đơn hàng
		foreach ($mangChiTiet as $key => $value) {
			// Tạo câu truy vấn INSERT chi tiết đơn hàng
			$query = 'INSERT INTO `chitietdonhang`(`maDonHang`, `maSanPham`, `soLuong`, `gia`) VALUES ('.$result["maDonHang"].','.$value["maSanPham"].','.$value["soLuong"].','.$value["giaSanPham"].')';
			// echo $query;
			$data = mysqli_query($conn, $query);
			if ($data == true) {
				$arr = [
					'success' => true,
					'message' => "Thành công",
					'maDonHang' => $result["maDonHang"]
				];
			} else {
				$arr = [
					'success' => false,
					'message' => "Không thể thực hiện được truy vấn",
					'maDonHang' => -1
				];
			}
		}

	}
	
} else {
	$arr = [
		'success' => false,
		'message' => "Không thể thực hiện được truy vấn",
		'maDonHang' => -1
	];
}


print_r(json_encode($arr));

?>