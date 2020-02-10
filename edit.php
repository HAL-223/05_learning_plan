<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDb();

$sql = "select * from plans where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$plan = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] ==='POST') {
  $title = $_POST['title'];
  $due_date = $_POST['due_date'];

  $errors = [];

  if($title == '') {
    $errors['title'] = 'タスク名を入力してください' ;
  }

  if ($title == $plan['title']) {
    $errors['title'] = 'タスク名が変更されていません';
  }

  if ($title == $plan['due_date']) {
    $errors['due_date'] = '日付が変更されていません';
  }

if (empty($errors)) {
    $sql ="update plans set title = :title, " . "updated_at = now() " . "where id = :id";

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header('Location: index.php');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>編集画面</title>
</head>
<body>
  <h2>タスクの編集</h2>
  <p>
    <form action="" method="post">
      学習内容:<input type="text" name="title" value="<?php echo h($plan['title']); ?>">
      期限日: <input type="date" name="due_date">
      <input type="submit" value="編集"><br>
      <span style="color:red;"><?php echo h($errors['title']); ?></span>
    </form>
  </p>
</body>
</html>