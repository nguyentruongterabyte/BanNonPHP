<?php
include "../../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $maSanPham = $_PUT['maSanPham'];
    $userId = $_PUT['userId'];
    $gia = $_PUT['gia'];
    $soLuong = $_PUT['soLuong'];

    // Sanitize data before using in SQL query
    $maSanPham = mysqli_real_escape_string($conn, $maSanPham);
    $userId = mysqli_real_escape_string($conn, $userId);
    $gia = mysqli_real_escape_string($conn, $gia);
    $soLuong = mysqli_real_escape_string($conn, $soLuong);

    // Check product quantity
    $checkQuantityQuery = "SELECT soLuong FROM `sanpham` WHERE `maSanPham` = '$maSanPham'";
    $checkQuantityResult = mysqli_query($conn, $checkQuantityQuery);

    if ($checkQuantityResult) {
        $row = mysqli_fetch_assoc($checkQuantityResult);
        $quantityInDatabase = $row['soLuong'];

        if ($quantityInDatabase >= $soLuong) {
            $query = "UPDATE `giohang` SET `giaSanPham` = '$gia', `soLuong` = '$soLuong' WHERE `userId` = $userId AND `maSanPham` = $maSanPham";
        } else {
            $query = "UPDATE `giohang` SET `giaSanPham` = '$gia', `soLuong` = '$quantityInDatabase' WHERE `userId` = $userId AND `maSanPham` = $maSanPham";
        }

        $updateResult = mysqli_query($conn, $query);
        if ($updateResult) {
            $response['success'] = true;
            $response['message'] = "Thành công";
        } else {
            $response['success'] = false;
            $response['message'] = "Không thể thực hiện được truy vấn";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Không thể thực hiện được truy vấn";
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid request method'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
