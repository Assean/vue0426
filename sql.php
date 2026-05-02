<?php
    // 建立與 MySQL 資料庫的連線
    // 使用 PDO (PHP Data Objects) 驅動，設定主機(localhost)、資料庫名稱(todoapp)、字元集(utf8)，以及帳號(root)與密碼(空)
    $pdo = new PDO("mysql:host=localhost;dbname=todoapp;charset=utf8","root","");

    // 取得 URL 上的 'do' 參數，並使用 isset() 檢查是否存在，若無則給予空字串，避免錯誤訊息
    $geturl = isset($_GET["do"]) ? $_GET["do"] : "";

    // 根據 'do' 的值，透過 if...elseif 執行對應的資料庫操作
    if ($geturl == 'getusers') {
        
        // 情況 1：取得所有使用者資料
        // 執行 SQL 查詢，並將結果全部取出轉為關聯陣列 (fetchAll)
        $users = $pdo->query("select * from users")->fetchAll();
        
        // 將 PHP 陣列轉換為 JSON 格式並輸出，讓前端的 Vue 可以透過 fetch 接收到正確格式的資料
        echo json_encode($users);

    } elseif ($geturl == 'edituser') {
        
        // 情況 2：編輯/更新使用者資料
        // 接收前端表單透過 POST 傳來的資料，並直接寫入 SQL 語法中更新資料庫
        $user = $pdo->query("
        update users set username='{$_POST['username']}',password='{$_POST['password']}',role='{$_POST['role']}'
        where id = {$_POST['id']}
        ");
        // 回傳 true，表示 API 執行完畢
        echo true;

    } elseif ($geturl == 'adduser') {
        
        // 情況 3：新增使用者
        // 將前端傳來的 POST 資料新增到資料庫中
        $user = $pdo->query("
        insert into users values('','{$_POST['username']}','{$_POST['password']}','{$_POST['role']}')
        ");
        echo true;

    } elseif ($geturl == 'deluser') {
        
        // 情況 4：刪除使用者
        // 取得 URL 上傳遞的 'id' 參數
        $user_id = $_GET["id"];
        // 根據 ID 刪除對應的資料表紀錄
        $pdo->query("delete from users where id = $user_id");
        echo true;

    } else {
        
        // 可選：當所有的條件都不符合時（例如亂打網址），可以在這裡設定預設的回應
        // echo "無效的請求";
        
    }
?>