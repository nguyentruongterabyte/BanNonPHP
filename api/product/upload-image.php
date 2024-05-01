<?php 
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers
include "../../connect.php";
$targetDir = "../../images/product/";

// Nếu sản phẩm cập nhật 
// lấy mã sản phẩm đặt tên cho file ảnh
if (isset($_POST['maSanPham']) && $_POST['maSanPham'] != -1) {
	$maSanPham = $_POST['maSanPham'];
	$name = $maSanPham .".jpg";
} else {
	// nếu không thì select max id 
	$query = "SELECT max(maSanPham) as id from sanpham";
	$data = mysqli_query($conn, $query);
	$result = array();
	while($row = mysqli_fetch_assoc($data)) {
		$result[] = ($row);
	}
	
	if ($result[0]['id'] == null) {
		$name = 1;
	} else {
		$name = ++$result[0]['id'];
	}
	$name = $name .".jpg"; 
}


$targetFileName = $targetDir .$name;

if (isset($_FILES['file'])) {
	if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFileName)) {
		$response = [
			'success' => true,
			'message' => "Thành công",
			'name' => $name
		];
	} else {
		$response = [
			'success' => false,
			'message' => "Thất bại"
		];
	}
} else {
	$response = [
		'success' => false,
		'message' => "Lỗi upload ảnh"
	];
}

// Send JSON response
header("Content-Type: application/json");
echo json_encode($response);
?>