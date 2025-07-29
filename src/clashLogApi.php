<?php

    $_SERVER['PHP_AUTH_USER'];
    $_SERVER['PHP_AUTH_PW'];

    if($_SERVER['PHP_AUTH_USER'] == "u6Kg5t2c" && $_SERVER['PHP_AUTH_PW'] == "Zp6uaUzY"){
        // Content-Type を JSON に設定（任意）
        header('Content-Type: application/json');

        // POSTの生データ（JSON）を受け取る
        $json = file_get_contents('php://input');

        // ログ表示（サーバー側に送信された内容の確認用）
        file_put_contents('received_log.json', $json);  // ファイル保存（任意）

        // すべて成功した場合は201レスポンスとして返す
        header('Content-Type: text/plain; charset=UTF-8');
        header('Status: created');
        http_response_code(201);
    }else {
        header('Content-Type: text/plain; charset=UTF-8');
        header('Status: Unauthorized');
        http_response_code(401);
    }