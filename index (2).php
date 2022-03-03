<?php
session_start();
try {
    $db = new PDO('mysql:dbname=chat;host=127.0.0.1;charset=utf8', 'root', '');
    //exit("DB:OK");
} catch (PDOException $e) {
    $msg = $e->getMessage();
}



$members=$db->query('SELECT * FROM members ORDER BY id DESC');
while ($member = $members->fetch()):
 if($member['id'] == $_SESSION["id"]){
    continue;
  }
?>
 
 
 
 
<p><a href="chat.php?name=<?php print($member['name']);?>"><?php print(mb_substr($member['name'],0,50)); ?></a></p>
<?php endwhile; ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
ログイン中のユーザー<br>
<?=$_SESSION["mail"]; ?>
    
    
</body>
</html>