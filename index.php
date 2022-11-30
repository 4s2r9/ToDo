<?php
session_start();
$error_login = "";
$error_sign_up = "";

//セッションセット
if(isset($_SESSION['email'])){
    $error_sign_up = $_SESSION['error_email'];
    unset($_SESSION['error_email']);
}
if(isset($_SESSION['error_email_confirmation'])){
    $error_sign_up = $_SESSION['error_email_confirmation'];
    unset($_SESSION['error_email_confirmation']);
}
if(isset($_SESSION['error_password'])){
    $error_sign_up = $_SESSION['error_password'];
    unset($_SESSION['error_password']);
}
if(isset($_SESSION['error'])){
    $error_sign_up = $_SESSION['error'];
    unset($_SESSION['error']);
}
if(isset($_SESSION['error_login'])){
    $error_login = $_SESSION['error_login'];
    unset($_SESSION['error_login']);
}

?>

<!DOCTYPE html>
<html lang="jn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>ToDo新規登録</title>
</head>
<body>

    <h2>ユーザー情報を入力</h2>

    <div class="input_box">
        <h3>新規登録</h3>
        <form action="db_sign_up.php" method="post">
            <input type="email" name="email" placeholder="メールアドレスを入力"><br>
            <input type="email" name="email_confirmation" placeholder="メールアドレスを再確認"><br>
            <input type="password" name="password" placeholder="パスワードを入力"><br>
            <output style="color:red"><?php echo $error_sign_up ?></output><br>
            <input type="submit" value="新規登録"><br>
        </form>

        <hr>

        <h3>ログイン</h3>
        <form action="db_login.php" method="post">
            <input type="email" name="email" placeholder="メールアドレスを入力"><br>
            <input type="password" name="password" placeholder="パスワードを入力"><br>
            <output style="color:red"><?php echo $error_login ?></output><br>
            <input type="submit" value="ログイン"><br>
        </form>
    </div>

</body>
</html>