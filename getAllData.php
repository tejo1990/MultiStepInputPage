<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "chicline";
$password = "tlzmfkdls!23";
$dbname = "chicline";

// MySQL 연결
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$response = array();

if ($conn->connect_error) {
    $response['success'] = false;
    $response['message'] = "연결 실패: " . $conn->connect_error;
} else {
    $response['success'] = true;
    $response['message'] = "데이터베이스 연결 성공!";
}

// 쿼리 수행
$sql = "SELECT * FROM ContentsKorea";
$result = $conn->query($sql);

$booths = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $booths[] = $row;
    }
}

// JSON 반환
echo json_encode($booths);

$conn->close();
?>