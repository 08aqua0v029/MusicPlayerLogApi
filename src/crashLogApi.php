<?php

    // リクエスト情報の定義　存在しなければエラー
    if(isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_PW']){
        $_SERVER['PHP_AUTH_USER'];   // リクエストされたUser名
        $_SERVER['PHP_AUTH_PW'];     // リクエストされたPass
    } else {
        echo "401 Unauthorized";
        exit;
    }

    // TODO:.envなどで保管する方法に変更予定
    $username = "u6Kg5t2c";     // Basic認証User
    $userpass = "Zp6uaUzY";     // Basic認証Pass

    if($_SERVER['PHP_AUTH_USER'] == $username
        && $_SERVER['PHP_AUTH_PW'] == $userpass){
        // Content-Type を JSON に設定（任意）
        header('Content-Type: application/json');

        // POSTの生データ（JSON）を受け取る
        $json = file_get_contents('php://input');
        $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');

        // 連想配列化
        $arr=json_decode($json,true);

        // 配列から、DB登録する各種データを取り出す
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

            // prepareでSQL実行の準備
            $sql = $pdo->prepare("INSERT INTO crashLog (crashDate, crashType, crashDetails, crashLocation, buildModel, buildOsVersion)
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

        // すべて成功した場合は201レスポンスとして返す
        header('Content-Type: text/plain; charset=UTF-8');
        header('Status: created');
        http_response_code(201);
    }else {
        header('Content-Type: text/plain; charset=UTF-8');
        header('Status: Unauthorized');
        http_response_code(401);

        echo "401 Unauthorized";
    }