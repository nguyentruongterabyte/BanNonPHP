<?php 
include "../../connect.php";
if (isset($_GET["year"])) {
  $year = $_GET["year"];

  $year = mysqli_real_escape_string($conn, $year);

  $query = "SELECT\n"
    . "    cdh.maSanPham,\n"
    . "    sp.tenSanPham,\n"
    . "    sp.soLuong AS soLuongTon,"
    . "    sp.hinhAnh,"
    . "    SUM(cdh.soLuong) AS tongSoLuong\n"
    . "FROM\n"
    . "    chitietdonhang cdh\n"
    . "JOIN\n"
    . "    donhang dh ON cdh.maDonHang = dh.maDonHang\n"
    . "JOIN\n"
    . "    sanpham sp ON cdh.maSanPham = sp.maSanPham\n"
    . "WHERE\n"
    . "    YEAR(dh.ngayTao) = $year\n"
    . "GROUP BY\n"
    . "    cdh.maSanPham\n"
    . "ORDER BY\n"
    . "    SUM(cdh.soLuong) DESC\n"
    . "LIMIT 10;";

  $data = mysqli_query($conn, $query);
  $result = array();

  while ($row = mysqli_fetch_assoc($data)) {
    $result[] = $row;
  }

  if (!empty($result)) {
    $response = [
      'status' => 200,
      'message' => 'Lấy báo cáo thành công',
      'object' => $result
    ];
  } else {
    $response = [
      'status' => 201,
      'message' => 'Không có dữ liệu',
      'object' => []
    ];
  }
  // Send JSON response
    header("Content-Type: application/json");
    echo json_encode($response);
} else {

  http_response_code(400); // Bad Request
  echo json_encode(["message" => "year parameter is required"]);
}
?>