<?php 
include "../../connect.php";


$query = "SELECT * FROM `donhang` ORDER BY `maDonHang` DESC";
$result = array();
$data = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($data)) {

	// Lấy chi tiết đơn hàng 
	$orderDetailQuery = 'SELECT chitietdonhang.maSanPham, tenSanPham, sanpham.giaSanPham, chitietdonhang.soLuong, gioiTinh, mauSac, hinhAnh FROM `chitietdonhang` INNER JOIN `sanpham` ON chitietdonhang.maSanPham = sanpham.maSanPham WHERE maDonHang = '.$row["maDonHang"].'';
	$items = array();
	$orderDetailData = mysqli_query($conn, $orderDetailQuery);

	while ($rowOrderDetail = mysqli_fetch_assoc($orderDetailData)) {
		$items[] = ($rowOrderDetail);
	}

	$row['items'] = $items; 

	$result[] = ($row);
}

if (!empty($result)) {
	$response = [
		'status' => 200,
		'message' => "Lấy lịch sử đơn hàng thành công",
		'result' => $result
	];
} else {
	$response = [
		'status' => 201,
		'message' => "Đơn hàng trống",
		'result' => $result

	];
}

header("Content-Type: application/json");
echo json_encode($response) 	;

?>