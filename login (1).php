<?php
session_start();
$_SESSION['mail'] = $_POST['mail'];
try {
    $db = new PDO('mysql:dbname=chat;host=127.0.0.1;charset=utf8', 'root', '');
    //exit("DB:OK");
} catch (PDOException $e) {
    $msg = $e->getMessage();
}
$sql = "SELECT * FROM members WHERE email = :mail";
$stmt=$db->prepare($sql);
$stmt->bindvalue(':mail',$_SESSION['mail']);
$stmt->execute();
$member = $stmt->fetch();



if (password_verify($_POST['pass'], $member['password'])) {
    $_SESSION['id'] = $member['id'];
    $_SESSION['name'] = $member['name'];
     $_SESSION['mail'] = $member['email'];
    $msg='ログインしました';
   header('Location:index.php');
} else {
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $link = '<a href="login-form.php">戻る</a>';
}
?>
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>
