<?php

    // 各種定義
    // $_SERVER['PHP_AUTH_USER'];   // リクエストされたUser名
    // $_SERVER['PHP_AUTH_PW'];     // リクエストされたPass
    $username = "u6Kg5t2c";     // Basic認証User
    $userpass = "Zp6uaUzY";     // Basic認証Pass

    // JSONファイルのパスを組み立てる（同じディレクトリ内）
    $jsonPath = __DIR__ . '/received_log.json';

    // ファイルの内容を取得
    $json = file_get_contents($jsonPath);
    // JSONデータコンバート
    $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    // 連想配列化
    $arr=json_decode($json,true);

    $crashDate = $arr['crashedTime'];
    $crashType = $arr['crashType'];
    $crashDetails = $arr['crashDetails'];
    $crashLocation = $arr['crashLocation'];
    $buildModel = $arr['buildModel'];
    $osVer = $arr['buildOsVersion'];

    // DB接続設定呼び出し
    require_once('dbConnect.php');

    try {
        // データベースに接続
        $pdo = db_connect();

        //例外処理を投げるようにする（throw）
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("INSERT INTO clashLog (crashDate, crashType, crashDetails, crashLocation, buildModel, buildOsVersion)
            VALUES (:crashDate, :crashType, :crashDetails, :crashLocation, :buildModel, :buildOsVersion)");

        // bindPramで各種指定　:xxxで変数を$xxxに設定　PARAM_はデータ型
        $sql->bindParam(':crashDate', $crashDate, PDO::PARAM_STR);
        $sql->bindParam(':crashType', $crashType, PDO::PARAM_STR);
        $sql->bindParam(':crashDetails', $crashDetails, PDO::PARAM_STR);
        $sql->bindParam(':crashLocation', $crashLocation, PDO::PARAM_STR);
        $sql->bindParam(':buildModel', $buildModel, PDO::PARAM_STR);
        $sql->bindParam(':buildOsVersion', $osVer, PDO::PARAM_STR);

        // SQL実行
        $sql->execute();
    
        //データベース接続切断
        $pdo = null;

    } catch (PDOException $e) {
        header('Content-Type: text/plain; charset=UTF-8', true, 500);
        exit($e->getMessage()); 
    }


    // if($_SERVER['PHP_AUTH_USER'] == $username
    //     && $_SERVER['PHP_AUTH_PW'] == $userpass){
    //     // Content-Type を JSON に設定（任意）
    //     header('Content-Type: application/json');

    //     // POSTの生データ（JSON）を受け取る
    //     $json = file_get_contents('php://input');
    //     $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');

    //     // ログ表示（サーバー側に送信された内容の確認用）
    //     file_put_contents('received_log.json', $json);  // ファイル保存（任意）

    //     // すべて成功した場合は201レスポンスとして返す
    //     header('Content-Type: text/plain; charset=UTF-8');
    //     header('Status: created');
    //     http_response_code(201);
    // }else {
    //     header('Content-Type: text/plain; charset=UTF-8');
    //     header('Status: Unauthorized');
    //     http_response_code(401);
    // }