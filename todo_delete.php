<?php

include("functions.php");

// データ受け取り  includeよりこっちを先にためす
// var_dump($_GET);
// exit();


// id受け取り
$id = $_GET['id'];
//⇒read.phpでa hrefのとこで、?id={$record["id"]}のように
//idを設定している＆
//GETはURLに表示されるので（POSTはURLが隠れる）
//ここでGETするとidを取れる



// DB接続
$pdo = connect_to_db();

// SQL実行// SQL実行  edit.phpと似ている
$sql = 'DELETE  FROM todo_table WHERE id=:id';
// DELETEとFROMの間に*を入れてはダメ



$stmt = $pdo->prepare($sql);
// ↓入力画面でユーザーが入力するので、バインド変数使う
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}


header("Location:todo_read.php");
exit();
