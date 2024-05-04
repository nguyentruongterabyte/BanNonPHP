<?php 
include "../../connect.php";

if (isset($_GET["maDonHang"])) {
  $maDonHang = $_GET["maDonHang"];

  $maDonHang = mysqli_real_escape_string($conn, $maDonHang);

  $query = "SELECT * FROM `donhang` WHERE `maDonHang` = $maDonHang";

  $data = mysqli_query($conn, $query);

  if ($data) {
    $row = mysqli_fetch_assoc($data);
    $order = $row;
    
    // Lấy chi tiết đơn hàng
    $orderDetailQuery = "SELECT ct.maSanPham, sp.tenSanPham, sp.giaSanPham, ct.soLuong, sp.mauSac, sp.hinhAnh\n" 
                        ."FROM `chitietdonhang` AS ct INNER JOIN `sanpham` AS sp\n" 
                        ."ON ct.maSanPham = sp.maSanPham\n"
                        .'WHERE maDonHang = '.$order["maDonHang"].'';
                        $orderDetailData = mysqli_query($conn, $orderDetailQuery);
    $items = array();
    if ($orderDetailData) {
                          
      while ($rowOrderDetail = mysqli_fetch_assoc($orderDetailData)) {
        $items[] = ($rowOrderDetail);
      }
  
      $order['items'] = $items;
      
    } 
  }

  if (!empty($order)) {
    $response = [
      'status' => 200,
      'message' => "Lấy hóa đơn thành công",
      'result' => $order
    ];
  } else {
    $response = [
      'status' => 201,
      'message' => "Không có dữ liệu"
    ];
  }

  header("Content-Type: application/json");
  echo json_encode($response);
} else {  
  http_response_code(400);
  echo json_encode(['message' => 'maDonHang is required']);
}
?>