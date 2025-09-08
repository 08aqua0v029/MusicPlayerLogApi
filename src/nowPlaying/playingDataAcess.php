<?php

    header('Content-Type: text/event-stream');
    header('Cache-Control: no-store');

    set_time_limit(0);  // サーバー仕様で規定時間内に処理が止まらないようにする

    // 継続処理
    while (true) {
        $json = file_get_contents('../test/nowPlaying.json');   // JSONファイル取得
        $decoded = json_decode($json, true);    // JSONを1行表記にデコード

        if ($decoded === null) {
            echo "data: {}\n\n";
        } else {
            echo "data: " . json_encode($decoded, JSON_UNESCAPED_UNICODE) . "\n\n"; // エンコードしたデータをクライアント側に渡す
        }

        ob_flush();
        flush();
        sleep(1);
    }