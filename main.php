<?php
session_start();
$error_task = "";
if(isset($_SESSION['error_task'])){
    $error_task = $_SESSION['error_task'];
    unset($_SESSION['error_task']);
}

// DBからタスクを全部取得
require ("db_connect.php");
try{

    $character_id = $_GET['character_id'];
    $sql = "SELECT * from tasks where deleted_at is NULL AND character_id = $character_id ";
    $stmt = $pdo->query($sql);
    $task = $stmt->fetchAll( PDO::FETCH_ASSOC );

    $sql = "SELECT * from monsters";
    $stmt = $pdo->query($sql);
    $monster = $stmt->fetchAll( PDO::FETCH_ASSOC );

}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}


// $monster_sum = 0;
// foreach($monster as $row){
//     echo "\t\t<td><img src={$monster[$monster_sum]['image_url']} alt={$monster[$monster_sum]['name']} class=monster_image></td>\n";
//     echo  $monster[$monster_sum]['monster_id'];
//     $monster_sum ++;
// }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>

<!-- モンスター表示 -->
<table>
    <?php
    $task_sum = 0;
    $i = 0;
    foreach($task as $row){
        if(date('Y-m-d') == date('Y-m-d',strtotime($task[$task_sum]['created_at']))){
            $monster_sum = 0;
            foreach($monster as $row){
                if($task[$task_sum]['monster_id'] == $monster[$monster_sum]['monster_id'] && $i < 9){
                    // echo "\t<tr>\n";
                    echo "\t<td>\n";
                    echo "\t\t<div><img src={$monster[$monster_sum]['image_url']} alt={$monster[$monster_sum]['name']} class=monster_image>";
                    echo "\t\t<p>{$monster[$monster_sum]['name']}</p></div>\n";
                    echo "\t\t<div class=hp_back><div id=elem_{$i} class=hp_before></div></div>\n";
                    echo "\t</td>\n";
                    if($i == 2 || $i == 6){
                        echo "\t</tr>\n";
                    }
                    $i ++;
                }
                $monster_sum ++;
            }
        }
        $task_sum ++;
    }

    echo $i;
    ?>
</table>

<h2>タスク作成</h2>
    <form action="db_create_task.php?character_id=<?php echo $_GET['character_id']?>" method="post">
        <input type="text" name="task_name" placeholder="タスク名を入力"><br>
        <input type="text" name="task_memo" placeholder="詳細を入力"><br>
        優先度<select name="priority" onchange="changeColor(this)">
            <option style="color:black;" value="0">●</option>
            <option style="color:red;" value="1">●</option>
            <option style="color:blue;" value="2">●</option>
            <option style="color:orange;" value="3">●</option>
        </select><br>
        <output style="color:red"><?php echo $error_task ?></output><br>
        <input type="submit">
    </form>

    <hr>

    <h2>本日のタスク</h2>
    <table>
        <thead>
            <tr>
                <td><p>タスク名</p></td>
                <td><p>タスク詳細</p></td>
                <td><p>編集</p></td>
                <td><p>削除</p></td>
                <td colspan="2"><p>進捗度</p></td>
                <td><p>ボタン</p></td>
                <td><p>タスク作成日</p></td>
            </tr>
        </thead>

    <tbody>
    <?php
    $sum = 0;
    $i = 0;
    foreach($task as $row){
        echo "\t<tr>\n";
        if(date('Y-m-d') == date('Y-m-d',strtotime($task[$sum]['created_at']))){
            $date = date('Y-m-d',strtotime($task[$sum]['created_at']));
            echo "\t\t<td>{$row['name']}</td>\n";
            echo "\t\t<td>{$task[$sum]['memo']}</td>\n";
            echo "\t\t<td><a href='show.php?id={$task[$sum]['task_id']}'>編集</a></td>\n";
            echo "\t\t<td><a href='destroy.php?id={$task[$sum]['task_id']}'>削除</a></td>\n";
            echo "\t\t<td><input type=range value=0 min=0 max=100 id=ratio{$i} onchange=radio(this.value,{$i})></td>\n";
            echo "\t\t<td><p id=ratio_{$i}>0%</p></td>\n";
            echo "\t\t<td><button onclick=OnButtonClick({$i});>達成</button></td>\n";
            echo "\t\t<td>{$date}</td>\n";
            $i ++;
        }
        echo "\t</tr>\n";
        $sum ++;
    }
    ?>
    </tbody>
    </table>

    <hr>

    <h2>タスク一覧</h2>
    <table>
        <thead>
            <tr>
                <td><p>タスク名</p></td>
                <td><p>タスク詳細</p></td>
                <td><p>編集</p></td>
                <td><p>削除</p></td>
                <td><p>タスク作成日</p></td>
            </tr>
        </thead>

    <tbody>
    <?php
    $sum = 0;
    foreach($task as $row){
        $date = date('Y-m-d',strtotime($task[$sum]['created_at']));
        echo "\t<tr>\n";
        echo "\t\t<td>{$row['name']}</td>\n";
        echo "\t\t<td>{$task[$sum]['memo']}</td>\n";
        echo "\t\t<td><a href='show.php?id={$task[$sum]['task_id']}'>編集</a></td>\n";
        echo "\t\t<td><a href='destroy.php?id={$task[$sum]['task_id']}'>削除</a></td>\n";
        echo "\t\t<td>{$date}</td>\n";
        echo "\t</tr>\n";
        $sum ++;
    }
    ?>
    </tbody>
    </table>

    <script>
        //セレクトボックスのカラー
        function changeColor(hoge){
            if(hoge.value == 0){
                hoge.style.color = 'black';
            }else if( hoge.value == 1 ){
                hoge.style.color = 'red';
            }else if(hoge.value == 2){
                hoge.style.color = 'blue';
            }else if(hoge.value == 3){
                hoge.style.color = 'orange';
            }
        }

        function radio(value, id) {
        console.log(value +":"+ id);
        const ratio = document.getElementById("ratio_" + id);
        console.log(ratio);
        ratio.innerHTML = value + "%";
    }


    function OnButtonClick(id) {
        //スライドの数値取得
        console.log(id);
        const ratio = document.getElementById("ratio" + id);
        //hpバー変動
        console.log(ratio);
        const elem = document.getElementById("elem_" + id);
        console.log(elem);
        elem.style.width = 100 - ratio.value + "%";
    }
    </script>
</body>
</html>