<?php
// POST 요청 테스트를 위한 코드

// POST 데이터 받기
$postData = file_get_contents("php://input");
$data = json_decode($postData, true);

// 로그 파일에 받은 데이터 기록
$logFile = 'post_test_log.txt';
$logMessage = date('Y-m-d H:i:s') . " - 받은 데이터: " . print_r($data, true) . "\n";
file_put_contents($logFile, $logMessage, FILE_APPEND);

// 응답 보내기
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'POST 데이터가 성공적으로 수신되었습니다.',
    'receivedData' => $data
]);
?>
