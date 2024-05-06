<?php 
include "../../connect.php";
$tenViTri =  $_POST['tenViTri'];
$kinhDo = $_POST['kinhDo'];
$viDo = $_POST['viDo'];

$query = "INSERT INTO `toado` (tenViTri, kinhDo, viDo) VALUES ('$tenViTri', $kinhDo, $viDo)";

$data = mysqli_query($conn, $query);

if ($data) {
    // Xử lý khi thêm vào giỏ hàng thành công
    $response['status'] = 200;
    $response['message'] = "Thành công";
} else {
    // Xử lý khi thêm vào giỏ hàng thất bại
    $response['status'] = 400; // bad request
    $response['message'] = "Không thể thực hiện truy vấn.";
}

// Trả về JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>