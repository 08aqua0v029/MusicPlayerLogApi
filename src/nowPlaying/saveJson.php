<?php

    // 認証系クラス
    require_once('../common/phpFile/auth.php'); 

    // Content-Type を JSON に設定（任意）
    header('Content-Type: application/json');

    // POSTの生データ（JSON）を受け取る
    $json = file_get_contents('php://input');
    $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');

    // Jsonデータをファイル形式で保存
    if ($json) {
        file_put_contents('nowPlaying.json', $json);
        // すべて成功した場合は201レスポンスとして返す
        header('Content-Type: text/plain; charset=UTF-8');
        header('Status: created');
        http_response_code(201);
    } else {
        http_response_code(400);
}