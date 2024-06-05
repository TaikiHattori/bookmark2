<?php

// ***************
// 編集画面
// *****************

include("work_picture_functions.php");

// id受け取り
$id = $_GET['id'];
//⇒read.phpでa hrefのとこで、?id={$record["id"]}のように
//idを設定している＆
//GETはURLに表示されるので（POSTはURLが隠れる）
//ここでGETするとidを取れる



// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'SELECT * FROM update_delete_table WHERE id=:id';
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




// $output = "";
// foreach ($result as $record) {
//取得した画像バイナリデータをbase64で変換。
$img = "data:image/jpeg;base64," . base64_encode($record["picture"]);
//$img = "data:image/png;base64," . base64_encode($record["picture"]);
//$img = "data:image/jpng;base64," . base64_encode($record["picture"]);
// ↑「data:image/jpng;base64,」は文字列（他の画像形式が入力されたらブラウザ表示できないかも）状態ではある

// var_dump(base64_encode($record["picture"]));
// exit();
//⇒string(253332) "/9j/4AAQSkZJRgABAQEASABIAAD//.............
//⇒JPEG画像のbase64エンコードされたデータの一部である

// ここ！！！！！！！！！！！！！！


// }







?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB連携（編集画面）</title>
</head>

<body>
    <form action="work_picture_update.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>DB連携（編集画面）</legend>
            <a href="work_picture_read.php">一覧画面</a>
            <div>
                title: <input type="text" name="taitoru" value="<?= $record['title'] ?>">
            </div>
            <div>
                picture: <img src="<?= $img ?>" alt="画像">
                編集したい画像を選択:<input type="file" name="gazou">
                <!-- inputのtypeがfileの場合、valueにファイルパス指定できないというルールがある -->

            </div>

            <div>
                <input type="hidden" name="id" value="<?= $record['id'] ?>">
            </div>


            <div>
                <button>編集する</button>
            </div>
        </fieldset>
    </form>

</body>

</html>