<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../../css/style.css">

<title>よくわかるPHPの教科書</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">よくわかるPHPの教科書</h1>
</header>

<main>
<h2>ファイルアップロードを受信する</h2>
<pre>
<?php
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
    $filePath = './user_img/' . $file['name'];
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
</pre>
</main>
</body>
</html>
