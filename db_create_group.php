<!-- グループを作成する -->
<?php
if($_POST['group_name'] == "" || !isset($_POST['group_name'])){
    session_start();
    $_SESSION['$error_create_group'] = 'グループ名が未入力です';
    header('Location: home.php');
    exit;
}

if($_POST['release'] == 0){
    if($_POST['group_password'] == "" || !isset($_POST['group_password'])){
        session_start();
        $_SESSION['$error_create_group'] = 'パスワードが未入力です';
        header('Location: home.php');
        exit;
    }
}

require ("db_connect.php");
try{
    $sql = "INSERT INTO groups(name,password) values(:name,:password)";
    $prepare = $pdo -> prepare($sql);
    
    //値の設定
    $prepare -> bindValue(':name',$_POST["group_name"]);
    $prepare -> bindValue(':password',$_POST["group_password"]);

    //SQL実行
    $prepare -> execute();

    //インサートされた時のidを取得
    $group_id = $pdo->lastInsertId();


    $sql = "INSERT INTO belong(user_id,group_id,reader) values(:user_id,:group_id,:reader)";
    $prepare = $pdo -> prepare($sql);
    
    //値の設定
    $prepare -> bindValue(':user_id',$_COOKIE["user_id"]);
    $prepare -> bindValue(':group_id',$group_id);
    $prepare -> bindValue(':reader',1);

    //SQL実行
    $prepare -> execute();

    //リダイレクト
    header('Location: main.php');
}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}