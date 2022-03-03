/<?php session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>タイトル</title>
</head>
 
<body>
     <a href="index.php">戻る</a>
<!-- <h1><?php echo $_REQUEST['id'];?></h1>
 -->

<?php echo $_SESSION["mail"]; ?>
 
 
<form method="post" action="chat.php">
       <div> 名前　　　　<?php echo $_SESSION["name"]; ?>さん </div>
      <div > メッセージ　<input type="text" name="message"> </div>
 
       <div><button name="send" type="submit">送信</button> </div>
 
        チャット履歴
    </form>
 
 
 
</body>
<section>   
        <?php  
        
       // DBからデータ(投稿内容)を取得 
        $stmt = select(); foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
                // 投稿内容を表示
                echo $message['time'],"：　",$message['name'],"：",$message['message'];
               //echo $message['name'],"：　",$message['email'],"：",$message['password'];
                echo nl2br("\n");
        }
 
            // 投稿内容を登録
            if(isset($_POST["send"])) {
                insert();
                // 投稿した内容を表示
                $stmt = select_new();
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
                    echo $message['time'],"：　",$message['name'],"：",$message['message'];
                    echo nl2br("\n");
                }
            }
          
          
          
            // DB接続
            function connectDB() {
                $dbh = new PDO('mysql:host=localhost;dbname=chat','root','');
                return $dbh;
            }
            
            
            
 
            // DBから投稿内容を取得
            
            function select() {
                $dbh = connectDB();
                //$stmt = $dbh->prepare("SELECT * FROM members");
            //$stmt = $dbh->prepare("SELECT * FROM members WHERE email = :mail");
            //$stmt->bindValue(':mail', $_SESSION['mail']);


            $stmt = $dbh->prepare("SELECT * FROM message WHERE name = :name");
            $stmt->bindValue(':name', $_SESSION['name']);
            
             $stmt->execute();
            //$stmt->fetchAll();
             return $stmt;
            }
 
            // DBから投稿内容を取得(最新の1件)
            function select_new() {
                $dbh = connectDB();
                $sql = "SELECT * FROM message ORDER BY time desc limit 1";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                return $stmt;
            }
 
            // DBから投稿内容を登録
            function insert() {
                $dbh = connectDB();
                $sql = "INSERT INTO message (name, message, time) VALUES (:name, :message, now())";
                $stmt = $dbh->prepare($sql);
                $params = array(':name'=>$_SESSION['name'], ':message'=>$_POST['message']);
                $stmt->execute($params);
            }
             
        ?>
        
    </section>
    
     
    
 