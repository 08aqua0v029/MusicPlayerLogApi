<?php

// TODO:.envなどで保管する方法に変更予定
$username = "7QQHFCNv";     // Basic認証User
$userpass = "B57cJA2m";     // Basic認証Pass

// 認証情報の存在確認
if (!isset($_SERVER['PHP_AUTH_USER']) || !$_SERVER['PHP_AUTH_PW']) {
    exit('401 Unauthorized: No credentials provided.');
}

// ユーザ名・パスワードチェック
if ($_SERVER['PHP_AUTH_USER'] !== $username || $_SERVER['PHP_AUTH_PW'] !== $userpass) {
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    header('HTTP/1.0 401 Unauthorized');
    http_response_code(401);
    exit('401 Unauthorized: Invalid credentials.');
}