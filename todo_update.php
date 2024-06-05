<?php


// var_dump($_POST);
// exit();


include("functions.php");




// 以下、create.phpと似ている
// 入力項目のチェック  入力ちゃんとできてるか
if (
    !isset($_POST['todo']) || $_POST['todo'] === '' ||
    !isset($_POST['deadline']) || $_POST['deadline'] === ''||
    !isset($_POST['id']) || $_POST['id'] === ''

) {
    exit('paramError');
}


//入力ちゃんとできてるなら、POSTで受け取る
$todo = $_POST['todo'];
$deadline = $_POST['deadline'];
$id = $_POST['id'];




// DB接続
$pdo = connect_to_db();

//本来は↓を書くが、↑関数使うことでショートカット
// $dbn = 'mysql:dbname=gs_l10_01;charset=utf8mb4;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';

// try {
//   $pdo = new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//   echo json_encode(["db error" => "{$e->getMessage()}"]);
//   exit();
// }






// SQL実行

// $sql = 'INSERT INTO todo_table(id, todo, deadline, created_at, updated_at) VALUES(NULL, :todo, :deadline, now(), now())';
// ↑ここcreate.phpとは違うので書き換える
$sql = 'UPDATE todo_table SET todo=:todo, deadline=:deadline,  updated_at=now() WHERE id=:id';
// ↑WHEREで条件設定しないと、更新かけた時にカラム内のデータ全てが
//同じ名前に更新されるみたいなことが起きてしまう！！！！！！！！！




$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);



try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:todo_input.php");
// ↑read.phpに飛ばなじゃね？俺入力ミスってる気がする
exit();
