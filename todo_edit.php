<?php

// ***************
// 編集画面
// *****************

include("functions.php");

// id受け取り
$id = $_GET['id'];
//⇒read.phpでa hrefのとこで、?id={$record["id"]}のように
//idを設定している＆
//GETはURLに表示されるので（POSTはURLが隠れる）
//ここでGETするとidを取れる



// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'SELECT * FROM todo_table WHERE id=:id';
$stmt = $pdo->prepare($sql);


// ↓入力画面でユーザーが入力するので、バインド変数使う
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);
// ↑1件取るだけなのでfetch使う
//fetchAll[0]とかでもできる


// echo"<pre>";
// var_dump($result);
// echo"</pre>";
// exit();




?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（編集画面）</title>
</head>

<body>
  <form action="todo_update.php" method="POST">
    <fieldset>
      <legend>DB連携型todoリスト（編集画面）</legend>
      <a href="todo_read.php">一覧画面</a>
      <div>
        todo: <input type="text" name="todo" value="<?= $record['todo'] ?>">
      </div>
      <div>
        deadline: <input type="date" name="deadline" value="<?= $record['deadline'] ?>">
      </div>

      <div>
        <input type="hidden" name="id" value="<?= $record['id'] ?>">
      </div>


      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>