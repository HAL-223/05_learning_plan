<?php

require_once('config.php');
require_once('functions.php');

$errors = array();

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

  // if($title == '') {
  //   $errors['title'] = 'タスク名を入力してください' ;
  // }

  if ($title == $plan['title']) {
    $errors['title'] = 'タスク名が変更されていません';
  }

  if ($due_date == $plan['due_date']) {
    $errors['due_date'] = '日付が変更されていません';
  }
// var_dump($errors);
if (empty($errors)) {
    $sql ="update plans set title = :title,  due_date = :due_date, updated_at = now()  where id = :id";

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":due_date", $due_date);
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
      期限日: <input type="date" name="due_date" value="<?php echo  h($plan['due_date']); ?>">
      <input type="submit" value="編集"><br>
      <span style="color:red;">
      <?php if ($errors) : ?>
        <ul>
          <?php foreach ($errors as $error) : ?>
            <li>
              <?php echo h($error); ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      </span>
    </form>
  </p>
</body>
</html>