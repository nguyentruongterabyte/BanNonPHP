<?php 
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers
include "../../connect.php";
if (isset($_GET["maSanPham"])) {
  $maSanPham = $_GET["maSanPham"];

  $maSanPham = mysqli_real_escape_string($conn, $maSanPham);

  $query = "SELECT * FROM `sanpham` WHERE `maSanPham` = $maSanPham";
  $data = mysqli_query($conn, $query);
  if (!$data) {
    $response = [
      'status' => 400,
      'message' => 'Không thể lấy thông tin sản phẩm'
    ];
  } else {
    $row = mysqli_fetch_assoc($data);
    $result = $row;
    $response = [
      'status' => 200,
      'message' => 'Lấy thông tin sản phẩm thành công',
      'result' => $result
    ];
  }
  header('Content-Type: application/json');
  echo json_encode($response);

} else {
  http_response_code(400);
  echo json_encode(["message" => "maSanPham parameter is required"]);
}
?>