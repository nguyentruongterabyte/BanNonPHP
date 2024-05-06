<?php 
include "../../connect.php";


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
	parse_str(file_get_contents("php://input"), $_PUT);
	$token = $_PUT['token'];
	$idDonHang = $_PUT['id'];

	$token = mysqli_real_escape_string($conn, $token);
	$idDonHang = mysqli_real_escape_string($conn, $idDonHang);
	
	$query = 'UPDATE `donhang` SET `token`= "'.$token.'" WHERE `maDonHang` = '.$idDonHang.'';
	$data = mysqli_query($conn, $query);

	if ($data) {
		$response = [
			'status' => 200,
			'message' => 'Thành công'
		];
	} else {
		$response = [
			'status' => 400,
			'message' => 'Không thể thực hiện được truy vấn'
		];
	}

} else {
	$response = [
    'status' => 405,
    'message' => 'Invalid request method'
  ];
}

header('Content-Type: application/json');
echo json_encode($response);

?>