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

// 데이터 업데이트 쿼리 준비
// 각 데이터 값을 update.log에 기록
file_put_contents('update.log', "Step3Data: " . $data['Step3Data'] . "\n", FILE_APPEND);
file_put_contents('update.log', "Step4Data: " . $data['Step4Data'] . "\n", FILE_APPEND);
file_put_contents('update.log', "Step5Data: " . $data['Step5Data'] . "\n", FILE_APPEND);
file_put_contents('update.log', "BoothNumber: " . $data['BoothNumber'] . "\n", FILE_APPEND);

// 쿼리 실행 전 로그 기록
file_put_contents('update.log', "쿼리 실행 시작\n", FILE_APPEND);
file_put_contents('update.log', "SQL 쿼리: UPDATE ContentsKorea SET description = ?, youtubeurl = ?, profileimage_url = ? WHERE booth_number = ?\n", FILE_APPEND);

$stmt = $conn->prepare("UPDATE ContentsKorea SET description = ?, youtubeurl = ?, postimageurl = ? WHERE booth_number = ?");


file_put_contents('update.log', "123\n", FILE_APPEND);
file_put_contents('update.log', "4321\n", FILE_APPEND);
// - 's': 문자열 타입 (string). MySQL의 CHAR, VARCHAR, TEXT 등의 문자열 타입에 해당합니다.
// - 'i': 정수 타입 (integer). MySQL의 INT, SMALLINT, MEDIUMINT, BIGINT 등의 정수 타입에 해당합니다.
// - 'd': 실수 타입 (double). MySQL의 FLOAT, DOUBLE 등의 실수 타입에 해당합니다.
// - 'b': BLOB 타입. MySQL의 BLOB, MEDIUMBLOB 등의 이진 데이터 타입에 해당합니다.

// 이 구문이 제대로 수행되지 않은 이유를 확인하기 위해 오류 로깅을 추가합니다.
try {
    // 바인딩 파라미터 확인
    $step3Data = isset($data['Step3Data']) ? $data['Step3Data'] : '';
    $step4Data = isset($data['Step4Data']) ? $data['Step4Data'] : '';
    $step5Data = isset($data['Step5Data']) ? $data['Step5Data'] : '';
    $boothNumber = isset($data['BoothNumber']) ? $data['BoothNumber'] : '';

    // 바인딩 전 파라미터 로깅
    file_put_contents('update.log', "바인딩 전 파라미터:\n", FILE_APPEND);
    file_put_contents('update.log', "Step3Data: $step3Data\n", FILE_APPEND);
    file_put_contents('update.log', "Step4Data: $step4Data\n", FILE_APPEND);
    file_put_contents('update.log', "Step5Data: $step5Data\n", FILE_APPEND);
    file_put_contents('update.log', "BoothNumber: $boothNumber\n", FILE_APPEND);

    file_put_contents('update.log', "bind param 전\n", FILE_APPEND);
    $stmt->bind_param("ssss", $step3Data, $step4Data, $step5Data, $boothNumber);
    file_put_contents('update.log', "bind param 후\n", FILE_APPEND);
} catch (Exception $e) {
    file_put_contents('update.log', "바인딩 오류: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(["error" => "파라미터 바인딩 실패"]);
    exit;
}

file_put_contents('update.log', "바인딩 후\n", FILE_APPEND);

file_put_contents('update.log', "쿼리 실행 시도 중...\n", FILE_APPEND);
if ($stmt->execute()) {
    file_put_contents('update.log', "쿼리 실행 성공\n", FILE_APPEND);
    echo json_encode(["success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "데이터 업데이트 실패"]);
}

$stmt->close();
$conn->close();
