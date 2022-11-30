<?php
//入力チェック
if($_POST["email"] == "" || $_POST["password"] == ""){
    session_start();
    $_SESSION['error_login'] = '未入力項目があります';
    header('Location: index.php?');
    exit;
}


require ("db_connect.php");
try{
    //emailでユーザーのパスワードを持ってくる
    $sql = "SELECT * FROM `users` WHERE email = :email;";
    $prepare = $pdo -> prepare($sql);
    
    //値の設定
    $prepare -> bindValue(':email',$_POST["email"]);

    //SQL実行
    $prepare -> execute();


    //値格納
    // $password = $prepare->fetchColumn();
    foreach ($prepare as $row) {
        setcookie ("user_id",$row['user_id'],time() + 30 * 24 * 3600);
    }
    

}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}

//データベースにあるパスワードと入力されたパスワードを比較
if($row['password'] == "" || !($row['password'] == $_POST["password"])){
    session_start();
    $_SESSION['error_login'] = 'メールアドレスが間違っているかパスワードが違います';
    header('Location: index.php');
    exit;
}

header('Location: home.php');