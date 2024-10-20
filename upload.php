<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

file_put_contents('debug.log', date('Y-m-d H:i:s') . " - 스크립트 시작\n", FILE_APPEND);
file_put_contents('debug.log', date('Y-m-d H:i:s') . " - REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n", FILE_APPEND);
file_put_contents('debug.log', date('Y-m-d H:i:s') . " - REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);
file_put_contents('debug.log', date('Y-m-d H:i:s') . " - FILES: " . print_r($_FILES, true) . "\n", FILE_APPEND);
file_put_contents('debug.log', date('Y-m-d H:i:s') . " - HTTP_X_HTTP_METHOD_OVERRIDE: " . (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) ? $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] : 'Not set') . "\n", FILE_APPEND);
file_put_contents('debug.log', date('Y-m-d H:i:s') . " - CONTENT_TYPE: " . (isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : 'Not set') . "\n", FILE_APPEND);
file_put_contents('debug.log', date('Y-m-d H:i:s') . " - FILES: " . print_r($_FILES, true) . "\n", FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    file_put_contents('debug.log', date('Y-m-d H:i:s') . " - OPTIONS OK\n", FILE_APPEND);
    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // 업로드 디렉토리 설정
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

        // 디렉토리 존재 여부 확인 및 생성
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to create upload directory.']);
                exit;
            }
        }
 
        // 업로드 파일 경로 설정
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);

        // 파일 이동 시도
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            if (file_exists($uploadFile)) {
                echo json_encode(['status' => 'success', 'url' => '/uploads/' . basename($_FILES['file']['name'])]);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'File upload failed: File not found after move.']);
            }
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid file upload.657567']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.123']);
}

file_put_contents('debug.log', date('Y-m-d H:i:s') . " - 접근 확인\n", FILE_APPEND);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


file_put_contents('debug.log', print_r($_POST, true) . "\n", FILE_APPEND);
file_put_contents('debug.log', print_r($_FILES, true) . "\n", FILE_APPEND);
file_put_contents('debug.log', file_get_contents('php://input') . "\n", FILE_APPEND);





error_log("Request method: " . $_SERVER["REQUEST_METHOD"]);
error_log("POST data: " . print_r($_POST, true));
error_log("FILES data: " . print_r($_FILES, true));

file_put_contents('debug.log', "Request Method: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);
file_put_contents('debug.log', "Content Type: " . $_SERVER['CONTENT_TYPE'] . "\n", FILE_APPEND);
file_put_contents('debug.log', "Raw input: " . file_get_contents('php://input') . "\n", FILE_APPEND);
?>