<?php

// 設定ファイルと関数ファイルを読み込む
require_once('config.php');
require_once('functions.php');

$dbh = connectDb();


// レコードの取得(未完了の場合)
$sql = "select * from plans where status = 'notyet'";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$notyet_plans = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
}

  $errors = [];
if ($title == '') {
    $errors['title'] = 'タスク名を入力してください';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>学習管理アプリ</title>
</head>
<body>
  <h1>学習管理アプリ</h1>

  <h2>未達成</h2>
  <ul>
    <?php foreach ($notyet_plans as $plan) : ?>
    <li>
      <?php echo h($plan['title']); ?>
    </li>
    <?php endforeach; ?>
  </ul>

  <hr>

  <h2>達成済み</h2>


</body>
</html>