<?php
//フォームからの値をそれぞれ変数に代入
$name = $_POST['name'];
$mail = $_POST['mail'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
//$dsn = "mysql:host=localhost; dbname=xxx; charset=utf8";
//$username = "xxx";
//$password = "xxx";

try {
    $db = new PDO('mysql:dbname=chat;host=127.0.0.1;charset=utf8', 'root', '');
    //exit("DB:OK");
} catch (PDOException $e) {
    $msg = $e->getMessage();
}
$sql = "INSERT INTO members(name, email, password) VALUES (:name, :email, :password)";
$stmt = $db->prepare($sql);
$stmt->bindValue(':name', $name);
$stmt->bindValue(':email', $mail);
$stmt->bindValue(':password', $pass);
$stmt->execute();
header('Location:login-form.php');
$msg = '会員登録が完了しました';
$link = '<a href="login-form.php">ログインページ</a>';

$msg = '会員登録が完了しました';
$link = '<a href="login-form.php">ログインページ</a>';
?>

<h1><?php echo $msg; ?></h1><!--メッセージの出力-->
<?php echo $link; ?>