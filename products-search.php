<?php 
include "connect.php";

$key = $_POST['key'];


if (empty($key)) {
	$arr = [
		'success' => false,
		'message' => "không thành công", 
	];
} else {
	$query = "SELECT * FROM `sanpham` WHERE `tenSanPham` LIKE '%".$key."%'";
	$data = mysqli_query($conn, $query);

	$result = array();

	while($row = mysqli_fetch_assoc($data)) {
		$result[] = ($row);
		// code...
	}

	if (!empty($result)) {
		$arr = [
			'success' => true,
			'message' => "thành công", 
			'result' => $result
		];
	} else {
			$arr = [
			'success' => false,
			'message' => "không thành công", 
			'result' => $result
		];

	} 
}


print_r(json_encode($arr))
?>