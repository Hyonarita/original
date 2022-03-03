<?php
try {
    $db = new PDO('mysql:dbname=chat;host=127.0.0.1;charset=utf8', 'root', '');
    //exit("DB:OK");
} catch (PDOException $e) {
    $msg = $e->getMessage();
}
$details=$db->prepare('SELECT * FROM members id=?');
$details->execute(array($_REQUEST['id']));
$detail=$details->fetch();
?>