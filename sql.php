<?php
    $pdo = new PDO("mysql:host=localhost;dbname=todoapp;charset=utf8","root","");

    $geturl = $_GET["do"];
    switch ($geturl){
        case 'getusers':
            $users = $pdo->query("select * from users")->fetchAll();
            // print_r($users);
            echo json_encode($users);
            break;
        case "edituser":
            $user = $pdo->query("
            update users set username='{$_POST['username']}',password='{$_POST['password']}',role='{$_POST['role']}'
            where id = {$_POST['id']}
            ");
            echo true;
            break;
        case "adduser":
            $user = $pdo->query("
            insert into users values('','{$_POST['username']}','{$_POST['password']}','{$_POST['role']}')
            ");
            echo true;
            break;
        case "deluser":
            $user_id = $_GET["id"];
            $pdo->query("delete from users where id = $user_id");
            echo true;
            break;
    }