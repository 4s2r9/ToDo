<?php

//必須入力チェック
if($_POST["email"] == "" || $_POST["password"] == "" || $_POST["email_confirmation"] == ""){
    session_start();
    $_SESSION['error'] = '未入力項目があります';
    header('Location: index.php?');
    exit;
}
//email再入力確認
if(!($_POST["email"] == $_POST["email_confirmation"])){
    session_start();
    $_SESSION['error_email_confirmation'] = '入力された再確認メールアドレスが違います';
    header('Location: index.php');
    exit;
}


require ("db_connect.php");
try{
    $sql = "INSERT INTO users(email,password) values(:email,:password)";
    $prepare = $pdo -> prepare($sql);
    
    //値の設定
    $prepare -> bindValue(':email',$_POST["email"]);
    $prepare -> bindValue(':password',$_POST["password"]);

    //SQL実行
    $prepare -> execute();

    //インサートされた時のidを取得
    $user_id = $pdo->lastInsertId();

    setcookie("user_id",$user_id,time() + 30 * 24 * 3600);

    //リダイレクト
    header('Location: home.php');
}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}


// SELECT user_id FROM `user` WHERE Email = "2@2";
