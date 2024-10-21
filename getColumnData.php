<?php
// 로그 파일 경로 설정
$logFile = 'getColumnData.log';

// 디버그 함수 정의
function debugLog($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

debugLog("스크립트 시작");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

debugLog("헤더 설정 완료");

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "chicline";
$password = "tlzmfkdls!23";
$dbname = "chicline";

debugLog("데이터베이스 설정 정보 로드");

// MySQL 연결
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    debugLog("데이터베이스 연결 실패: " . $conn->connect_error);
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

debugLog("데이터베이스 연결 성공");

// 부스 번호 가져오기
$boothNumber = isset($_GET['boothNumber']) ? $_GET['boothNumber'] : '';
debugLog("요청된 부스 번호: " . $boothNumber);

// 쿼리 수행
$sql = "SELECT booth_number, company_name, description, youtubeurl, postimageurl FROM ContentsKorea WHERE booth_number = ?";
debugLog("SQL 쿼리: " . $sql);

$stmt = $conn->prepare($sql);
if (!$stmt) {
    debugLog("SQL 준비 실패: " . $conn->error);
    die(json_encode(["error" => "SQL preparation failed: " . $conn->error]));
}

$stmt->bind_param("s", $boothNumber);
debugLog("매개변수 바인딩 완료");

$stmt->execute();
if ($stmt->error) {
    debugLog("쿼리 실행 실패: " . $stmt->error);
    die(json_encode(["error" => "Query execution failed: " . $stmt->error]));
}

debugLog("쿼리 실행 완료");

$result = $stmt->get_result();
debugLog("결과 행 수: " . $result->num_rows);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    debugLog("데이터 찾음: " . json_encode($row));
    echo json_encode($row);
} else {
    debugLog("데이터를 찾을 수 없음: " . $boothNumber);
    echo json_encode(["error" => "No data found for booth number: " . $boothNumber]);
}

$stmt->close();
$conn->close();
debugLog("데이터베이스 연결 종료");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    debugLog("OPTIONS 요청 처리");
    header("HTTP/1.1 200 OK");
    exit;
}

debugLog("스크립트 종료");
?>
