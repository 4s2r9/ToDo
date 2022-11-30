<?php

if($_POST["task_name"] == "" || !isset($_POST["task_name"])){
    session_start();
    $_SESSION['error_task'] = '未入力項目があります';
    header("Location: main.php?character_id={$_GET['character_id']}");
    exit;
}

require ("db_connect.php");
try{
    $sql = "INSERT INTO tasks(character_id,name,memo,priority,monster_id) values(:character_id,:task_name,:task_memo,:priority,:monster_id)";
    $prepare = $pdo -> prepare($sql);
    
    //値の設定
    $prepare -> bindValue(':character_id',$_GET["character_id"]);
    $prepare -> bindValue(':task_name',$_POST["task_name"]);
    $prepare -> bindValue(':task_memo',$_POST["task_memo"]);
    $prepare -> bindValue(':priority',$_POST["priority"]);
    $prepare -> bindValue(':monster_id',mt_rand(1, 20));

    //SQL実行
    $prepare -> execute();

    //リダイレクト
    header("Location: main.php?character_id={$_GET['character_id']}");
}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}