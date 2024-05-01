<?php
include "../../connect.php";

// Check if userId is provided in the URL
if (isset($_GET["userId"])) {
    $userId = $_GET["userId"];

    // Sanitize the userId
    $userId = mysqli_real_escape_string($conn, $userId);

    $query = "SELECT giohang.`maSanPham`, `userId`, giohang.`tenSanPham`, giohang.`giaSanPham`, giohang.`hinhAnh`, giohang.`soLuong`, sanpham.`soLuong` AS soLuongToiDa FROM `giohang` INNER JOIN `sanpham` ON userId = $userId AND giohang.maSanPham = sanpham.maSanPham";
    $data = mysqli_query($conn, $query);
    $result = array();

    while ($row = mysqli_fetch_assoc($data)) {
        $result[] = $row;
    }

    if (!empty($result)) {
        $arr = [
            'success' => true,
            'message' => "Thành công",
            'result' => $result
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => "Không có dữ liệu",
            'result' => $result
        ];
    }

    // Send JSON response
    header("Content-Type: application/json");
    echo json_encode($arr);
} else {
    // If userId is not provided in the URL, return an error response
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "UserId parameter is required"]);
}
?>
