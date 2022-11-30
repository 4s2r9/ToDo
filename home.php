<?php
session_start();
$error_create_group = "";
$error_character_name = "";
if(isset($_SESSION['$error_create_group'])){
    $error_create_group= $_SESSION['$error_create_group'];
    unset($_SESSION['$error_create_group']);
}
if(isset($_SESSION['error_character_name'])){
    $error_character_name = $_SESSION['error_character_name'];
    unset($_SESSION['error_character_name']);
}



require ("db_connect.php");
try{

    $user_id = $_COOKIE["user_id"];
    $sql = "SELECT * from characters where deleted_at is NULL AND user_id = $user_id ";
    $stmt = $pdo->query($sql);
    $solo_user = $stmt->fetchAll( PDO::FETCH_ASSOC );

}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}

// var_dump($result);
?>

<!DOCTYPE html>
<html lang="jn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h2>ログイン済</h2>
<h3>ユーザーID : <?php echo $_COOKIE["user_id"]?></h3>

<h3>グループ作成</h3>
<form action="db_create_group.php" method="post">
    <input type="text" name="group_name" placeholder="グループ名を入力"><br>
    <input type="password" id="group_pss_box" name="group_password" placeholder="パスワードを入力"><br>
    <input type="hidden" name="release" value="0" />
    <input type="checkbox" id="private_checked" name="release" value="1"><label for="private_checked">グループを公開</label><br>
    <output style="color:red"><?php echo $error_create_group?></output><br>
    <input type="submit" value="作成">
</form>

<h3>グループに参加</h3>
<form action="db_group_join.php" method="post">
    <input type="text" name="group_id" placeholder="グループidを入力"><br>
    <input type="password" name="password" placeholder="パスワードを入力"><br>
    <input type="submit" value="参加">
</form>

<h3>1人で</h3>
<form action="db_create_character.php" method="post">
    <input type="text" name="character_name" placeholder="キャラクター名を入力"><br>
    <output style="color:red"><?php echo $error_character_name ?></output><br>
    <input type="submit" value="作成">
</form>

<h3>作成キャラ一覧</h3>
<table>
    <thead>
        <tr>
            <td colspan="2"><p>キャラクター名</p></td>
        </tr>
    </thead>
    <tbody>
        <?php
        $sum = 0;
        foreach($solo_user as $row){
            echo "\t<tr>\n";
            echo "\t\t<td>{$row['name']}</td>\n";
            echo "\t\t<td><a href='main.php?character_id={$solo_user[$sum]['character_id']}'>再開</a></td>\n";
            echo "\t</tr>\n";
            $sum ++;
        }
        ?>
    </tbody>
</table>

<script>
    //グループ公開非公開設定
    let saveCheckbox = document.getElementById('private_checked');
    const pss_box_elem = document.getElementById("group_pss_box");
    saveCheckbox.addEventListener('change', valueChange);
    function valueChange(event){
        if(saveCheckbox.checked){
            pss_box_elem.disabled = true;
        }else{
            pss_box_elem.disabled = false;
        }
    }
</script>

</body>
</html>