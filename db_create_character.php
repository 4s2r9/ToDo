<?php
if($_POST["character_name"] == "" || !isset($_POST["character_name"])){
    session_start();
    $_SESSION['error_character_name'] = 'キャラクター名を入力してください';
    header('Location: home.php');
    exit;
}

require ("db_connect.php");
try{
    $sql = "INSERT INTO characters(user_id,group_id,name) values(:user_id,:group_id,:name)";
    $prepare = $pdo -> prepare($sql);
    
    //値の設定
    $prepare -> bindValue(':user_id',$_COOKIE["user_id"]);
    $prepare -> bindValue(':group_id',1);
    $prepare -> bindValue(':name',$_POST["character_name"]);

    //SQL実行
    $prepare -> execute();

    //インサートされた時のidを取得
    $character_id = $pdo->lastInsertId();

    //クッキーに保存
    setcookie("character_id",$character_id,time() + 30 * 24 * 3600);

    //リダイレクト
    header('Location: main.php?character_id='.$character_id);
}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}