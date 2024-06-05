<?php


// var_dump($_POST);
// exit();
//⇒array(2) { ["taitoru"]=> string(3) "え" ["id"]=> string(1) "4" }


//var_dump($_FILES);
//exit();
//⇒array(0) { }
//⇒ダメだ

//⇒<input type="file" name="gazou">を入力
// var_dump($_FILES);
// exit();
//⇒array(1) { ["gazou"]=> array(6) { ["name"]=> string(7) "月.jpg" ["full_path"]=> string(7) "月.jpg" ["type"]=> string(10) "image/jpeg" ["tmp_name"]=> string(52) "C:\Users\Taiki Hattori\Desktop\xampp\tmp\php4142.tmp" ["error"]=> int(0) ["size"]=> int(268429) } }


include("work_picture_functions.php");




// 以下、create.phpと似ている
// 入力項目のチェック  入力ちゃんとできてるか
if (
    !isset($_POST['taitoru']) || $_POST['taitoru'] === '' ||

    !isset($_FILES['gazou']) || $_FILES['gazou'] === '' ||
    //$_FILES['gazou']['error'] !== UPLOAD_ERR_OK || // ファイルが正しくアップロードされているかを確認

    !isset($_POST['id']) || $_POST['id'] === ''

) {
    exit('paramError');
}
// echo"編集項目チェックOK";
//⇒ここまでOK


//入力ちゃんとできてるなら、POSTで受け取る
$taitoru = $_POST['taitoru'];
$gazou = $_FILES['gazou'];
$id = $_POST['id'];




// DB接続  関数使って
$pdo = connect_to_db();




// SQL実行

$sql = 'UPDATE update_delete_table SET title=:title, picture=:picture,  updated_at=now() WHERE id=:id';
// ↑WHEREで条件設定しないと、更新かけた時にカラム内のデータ全てが
//同じ名前に更新されるみたいなことが起きてしまう！！！！！！！！！




$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $taitoru, PDO::PARAM_STR);
// 画像データをバイナリ形式でデータベースに挿入
$stmt->bindValue(':picture', file_get_contents($_FILES['gazou']['tmp_name']), PDO::PARAM_LOB);

$stmt->bindValue(':id', $id, PDO::PARAM_STR);



try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:work_picture_read.php");
exit();
// ⇒ここまでOK