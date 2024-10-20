<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

echo "checkBooth.php 호출";


// 데이터베이스 연결 설정
$servername = "localhost";
$username = "chicline";
$password = "tlzmfkdls!23";
$dbname = "chicline";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

file_put_contents('checkbooth.log', date('Y-m-d H:i:s') . " - boothNumber: " . $_GET['boothNumber'] . "\n", FILE_APPEND);
// 부스 번호 가져오기
// 이 코드는 GET 요청에서 'boothNumber' 파라미터를 가져와 정수로 변환합니다.
// 'boothNumber' 파라미터가 없으면 기본값 0을 사용합니다.
$boothNumber = isset($_GET['boothNumber']) ? intval($_GET['boothNumber']) : 0;

file_put_contents('checkbooth.log', date('Y-m-d H:i:s') . " - 여긴옴?: \n", FILE_APPEND);

// 부스 존재 여부 확인 쿼리
$sql = "SELECT COUNT(*) as count FROM ContentsKorea WHERE booth_number = ?";
file_put_contents('checkbooth.log', date('Y-m-d H:i:s') . " - SQL 쿼리: " . $sql . "\n", FILE_APPEND);
file_put_contents('checkbooth.log', date('Y-m-d H:i:s') . " - 여긴옴1?: \n", FILE_APPEND);
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    file_put_contents('checkbooth.log', date('Y-m-d H:i:s') . " - 여긴옴2?: \n", FILE_APPEND);
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $boothNumber);
file_put_contents('checkbooth.log', date('Y-m-d H:i:s') . " - 쿼리 실행\n", FILE_APPEND);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
file_put_contents('checkbooth.log', date('Y-m-d H:i:s') . " - 결과 가져오기\n", FILE_APPEND);
// 결과 반환
if ($row['count'] > 0) {
    echo "true";
} else {
    echo "false";
}

// 연결 종료
$stmt->close();
$conn->close();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // OPTIONS 요청에 대한 응답
    header("HTTP/1.1 200 OK");
    exit;
}
?>