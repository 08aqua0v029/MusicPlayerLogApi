<?php
// Content-Type を JSON に設定（任意）
header('Content-Type: application/json');

// POSTの生データ（JSON）を受け取る
$json = file_get_contents('php://input');

// ログ表示（サーバー側に送信された内容の確認用）
file_put_contents('received_log.json', $json);  // ファイル保存（任意）

// ログ内容をそのままレスポンスとして返す
echo json_encode([
    'status' => 'received',
    'data' => json_decode($json, true)
]);