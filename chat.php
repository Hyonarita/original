<?php session_start();
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
<br>
<?php echo $_REQUEST['name']; ?>

 
　　　<form method="post" action="chat.php">
       <div> 名前　　　　<?php echo $_SESSION["name"]; ?>さん </div>
      <div > メッセージ　<input type="text" name="message"> </div>
       <div><button name="send" type="submit">送信</button> </div>
       
 　　
 　　    <main>
       </main>
         チャット履歴
    </form>
 
        <h2>ファイルアップロードを受信する</h2>
        <form action="chat.php" method="post" enctype="multipart/form-data">
       <input type="text" name="ok">
       写真： <input type="file" name="picture">
        <input type="submit" value="送信する">
       </form>
 
 
</body>
<section>   

 


        <?php  
       // DBからデータ(投稿内容)を取得 
      // echo 'ログインしたアカウントの投稿'.'<br>';
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
            
            
            
 
            // DBから投稿内容を取得SELECT * FROM `message` order by time DESC
            
            function select() {
                $dbh = connectDB();
            $stmt = $dbh->prepare("SELECT * FROM message WHERE name = :username or name =:selectname");
            $stmt->bindValue(':selectname', $_REQUEST['name']);
            $stmt->bindValue(':username', $_SESSION['name']);
             $stmt->execute();
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

            <?php
                 if(empty($_POST["file"])) {
                 error_reporting(0);
                 }
                ?>

            <?php
            // 投稿内容を登録

              $file = $_FILES['picture'];
             ?>
             ファイル名（name）： <?php print($file['name']); ?>

              ファイルタイプ（type）： <?php print($file['type']); ?>

             アップロードされたファイル（tmp_name）： <?php print($file['tmp_name']); ?>

              エラー内容（error）： <?php print($file['error']); ?>

               サイズ（size）： <?php print($file['size']); ?>


                <?php
                 $ext = substr($file['name'], -4);
               if ($ext == '.gif' || $ext == '.jpg' || $ext == '.png') :
                 //$filePath = 'file.' . $file['name'];
                 $filePath = 'file/'. $file['name'];
                   $success = move_uploaded_file($file['tmp_name'], $filePath);

                if ($success) :
               
                   ?>
                    <img src="<?php print($filePath); ?>">
                  <?php else: ?>
                 ※ ファイルアップロードに失敗しました
                  <?php endif; ?>
                 <?php else: ?>
                  ※拡張子が.gif, .jpg, .pngのいずれかのファイルをアップロードしてください
                <?php endif; ?>
                
               <?php
                // リサイズ前画像ファイル名

 

$dst_w = 300;
$dst_h = 300;
 
// コピー先画像作成
$dst_image = imagecreate($dst_w, $dst_h);
 
// コピー元画像読み込み
$src_image = imagecreatefromjpeg($file);
 
// コピー元画像のサイズ取得
$imagesize = getimagesize($file);
$src_w = $imagesize[0];
$src_h = $imagesize[1];
 
// 縦はそのままで左右を削除
$zm = $src_h / $dst_h;
$yoko = $src_w / $zm;
$yohaku = ($yoko - $dst_w) / 2 * -1;
 
// リサイズしてコピー
imagecopyresampled(
	$dst_image, // コピー先の画像
	$src_image, // コピー元の画像
	$yohaku,    // コピー先の x 座標
	0,          // コピー先の y 座標。
	0,          // コピー元の x 座標
	0,          // コピー元の y 座標
	$yoko,      // コピー先の幅
	$dst_h,     // コピー先の高さ
	$src_w,     // コピー元の幅
	$src_h);    // コピー元の高さ
 
// 画像をファイルに出力
imagejpeg($dst_image,$file);
                
            
            
          
          
       
             

            
    
     
    
 