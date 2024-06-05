<?php

function connect_to_db()
{

    $dbn = 'mysql:dbname=gs_l10_01;charset=utf8mb4;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';

    try {
        return new PDO($dbn, $user, $pwd);
        // DB接続してる行

    } catch (PDOException $e) {
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }


}
