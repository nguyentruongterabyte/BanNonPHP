<?php 
include "../../connect.php";
if (isset($_GET["year"])) {
  $year = $_GET["year"];

  $year = mysqli_real_escape_string($conn, $year);

  $query = "SELECT
        cdh.maSanPham,
        sp.tenSanPham,
        sp.soLuong AS soLuongTon,
        sp.hinhAnh,
        SUM(cdh.soLuong) AS tongSoLuong
    FROM
        chitietdonhang cdh
    JOIN
        donhang dh ON cdh.maDonHang = dh.maDonHang
    JOIN
        sanpham sp ON cdh.maSanPham = sp.maSanPham
    WHERE
        YEAR(dh.ngayTao) = $year
    GROUP BY
        cdh.maSanPham
    ORDER BY
        SUM(cdh.soLuong) DESC
    LIMIT 10;";

  $data = mysqli_query($conn, $query);
  $result = array();

  while ($row = mysqli_fetch_assoc($data)) {
    $result[] = $row;
  }

  if (!empty($result)) {
    $response = [
      'status' => 200,
      'message' => 'Lấy báo cáo thành công',
      'result' => $result
    ];
  } else {
    $response = [
      'status' => 201,
      'message' => 'Không có dữ liệu'
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