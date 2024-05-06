<?php
include '../../connect.php';

$sql = "SELECT `id`, `username`, `mobile`, `email` FROM user";
$result = mysqli_query($conn, $sql);
$rows = array();

if (!$result) {
    $response = [
        'status' => 400,
        'message' => 'Không thể thực hiện truy vấn'
    ];
} else {
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    
    if (!empty($row)) {
        $response = [
            'status' => 201,
            'message' => 'Không có người dùng nào' 
        ];
    } else {
        $response = [
            'status' => 200,
            'message' => 'Lấy danh sách người dùng thành công',
            'result' => $rows
        ];
    }    
}
header("Content-Type: application/json");
echo json_encode($response);

mysqli_close($conn);
?>
