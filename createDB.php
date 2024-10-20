<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// CORS preflight 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "잘못된 입력 데이터"]);
    exit;
}

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "chicline";
$password = "tlzmfkdls!23";
$dbname = "chicline";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "데이터베이스 연결 실패"]);
    exit;
}
file_put_contents('create.log', "쿼리 준비 시작\n", FILE_APPEND);
$stmt = $conn->prepare("INSERT INTO ContentsKorea (booth_number, description, youtubeurl, postimageurl) VALUES (?, ?, ?, ?)");
file_put_contents('create.log', "쿼리 준비 완료\n", FILE_APPEND);

file_put_contents('create.log', "파라미터 바인딩 시작\n", FILE_APPEND);
$stmt->bind_param("isss", $data['BoothNumber'], $data['Step3Data'], $data['Step4Data'], $data['Step5Data']);
file_put_contents('create.log', "파라미터 바인딩 완료\n", FILE_APPEND);

file_put_contents('create.log', "쿼리 실행 시작\n", FILE_APPEND);
if ($stmt->execute()) {
    file_put_contents('create.log', "쿼리 실행 성공\n", FILE_APPEND);
    echo json_encode(["success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "데이터 생성 실패"]);
}

$stmt->close();
$conn->close();