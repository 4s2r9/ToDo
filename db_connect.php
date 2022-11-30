<?php
$dsn = 'mysql:host=localhost;dbname=todo_adventure;charset=utf8mb4';
$db_user = 'root';
$db_password = '';
$pdo = new PDO($dsn, $db_user, $db_password,);
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);



// $link = pg_connect("host=localhost dbname=db user=usr password=pass");
// pg_close($link);