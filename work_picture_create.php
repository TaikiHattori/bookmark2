<?php

include("work_picture_functions.php");




if (
    !isset($_POST['taitoru']) || $_POST['taitoru'] === '' ||
    !isset($_FILES['gazou']) || $_FILES['gazou'] === ''
) {
    exit('入力されていません');
}

$taitoru = $_POST['taitoru'];
$gazou = $_FILES['gazou'];



// DB接続
$pdo = connect_to_db();
// $dbn = 'mysql:dbname=gs_l10_01;charset=utf8mb4;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';

// try {
//   $pdo = new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//   echo json_encode(["db error" => "{$e->getMessage()}"]);
//   exit();
// }








// ---------------------
// 画像保存
// ----------------


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
} else {
    // 画像を保存
    if (!empty($_FILES['gazou']['name'])) {

        $name = $_FILES['gazou']['name'];
        $type = $_FILES['gazou']['type'];

        // 1文丸々or拡張子のみDBに入れるかは好み
        //カラム追加
        // ⇒そうしないとバイナリ形式だと拡張子が何なのかわからない
        // read.phpファイルで$img = "data:image/jpeg;base64," . base64_encode($record["picture"]);に関わる話

        // var_dump($type);
        // exit();

        $content = file_get_contents($_FILES['gazou']['tmp_name']);
        $size = $_FILES['gazou']['size'];

        $sql = 'INSERT INTO update_delete_table(id, title, picture,picture_type, created_at, updated_at,deleted_at) VALUES(NULL, :title, :picture,:picture_type, now(), now(),now())';

        $stmt = $pdo->prepare($sql);

        //テキスト
        $stmt->bindValue(':title', $taitoru, PDO::PARAM_STR);
        // 画像データをバイナリ形式でデータベースに挿入
        $stmt->bindValue(':picture', file_get_contents($_FILES['gazou']['tmp_name']), PDO::PARAM_LOB);
        $stmt->bindValue(':picture_type', $type, PDO::PARAM_STR);


        try {
            $status = $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(["sql error" => "{$e->getMessage()}"]);
            exit();
        }
    }
}



header("Location:work_picture_input.php");
exit();
