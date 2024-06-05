<?php


include("work_picture_functions.php");


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





$sql = 'SELECT * FROM update_delete_table ORDER BY created_at ASC';

$stmt = $pdo->prepare($sql);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {
    $output .= "
    <tr>
      <td>{$record["title"]}</td>
      <td>{$record["picture_type"]}</td>


      <td><img src='data:image/jpeg;base64," . base64_encode($record["picture"]) . "' alt='画像'></td>
      
      <td>
        <a href='work_picture_edit.php?id={$record["id"]}'>edit</a>
      </td>
      <td>
        <a href='work_picture_delete.php?id={$record["id"]}'>delete</a>
      </td>


    </tr>
  ";

    //$img = "data:image/jpeg;base64," . base64_encode($record["picture"]);

    // var_dump(base64_encode($record["picture"]));
    // exit();
    //⇒string(4) "MQ=="

    // var_dump($img);
    // exit();
    //⇒「string(27) "data:image/jpeg;base64,MQ=="」


}

// ↑a hrefで編集リンクを作る。書いてるファイルにid送りましょうという意味を書いてる





?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB連携（一覧画面）</title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.css">

    <style>
        img {
            width: 400px;
            height: 260px;
        }


        body {
            font-family: Arial, sans-serif;
        }

        .slider-container {
            width: 80%;
            margin: 50px auto;
            position: relative;
        }

        .rangeslider {
            background: none;
        }

        .rangeslider__fill {
            background: linear-gradient(to right, red, yellow, green);
            width: 100% !important;
        }

        .rangeslider__handle {
            background-color: #000;
            border-radius: 50%;
            position: relative;
        }

        .slider-value {
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            background-color: black;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            white-space: nowrap;
        }
    </style>


</head>

<body>
    <fieldset>
        <legend>DB連携（一覧画面）</legend>
        <a href="work_picture_input.php">入力画面</a>


        <!-- <img src=?= $img ?> class="topimage" alt="top" /> -->


        <table>
            <thead>
                <tr>
                    <th>title</th>
                    <th>picture_type</th>

                    <th></th>
                    <th>スライダー</th>

                    <th></th>
                    <th></th>
                </tr>
            </thead>


            <tbody>
                <?= $output ?>



                <!-- 画像とスライダーをループ内に追加 -->
                <?php foreach ($result as $record) : ?>
                    <tr>
                        <td><?= $record["title"] ?></td>
                        <td><?= $record["picture_type"] ?></td>
                        <td><img src="data:image/jpeg;base64,<?= base64_encode($record["picture"]) ?>" alt="画像"></td>
                        <td>
                            <input type="range" min="0" max="100" value="0" class="slider"><!-- 初期値を0に設定 -->
                            <div class="slider-value">0%</div>
                        </td>
                        <td>
                            <a href="work_picture_edit.php?id=<?= $record["id"] ?>">edit</a>
                        </td>
                        <td>
                            <a href="work_picture_delete.php?id=<?= $record["id"] ?>">delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>






            </tbody>
        </table>
    </fieldset>


    <!-- <div class="slider-container">
        <input type="range" min="0" max="100" value="0" id="slider"> 初期値を0に設定
        <div class="slider-value" id="slider-value">0%</div>
    </div> -->



    <!-- jQueryのインクルード -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.js"></script>



    <script>
        const pictures = <?= json_encode($result) ?>;
        console.log(pictures);




        $(document).ready(function() {

            $('.slider').each(function() {
                const $slider = $('#slider');
                const $sliderValue = $('#slider-value');
                // rangeslider.jsの初期化
                $slider.rangeslider({
                    polyfill: false,
                    onInit: function() {
                        updateSliderValue(this.value, $sliderValue);
                    },
                    onSlide: function(position, value) {
                        updateSliderValue(value, $sliderValue);
                    }
                });
            });

            function updateSliderValue(value, $sliderValue) {
                $sliderValue.text(value + '%');
                const handle = $sliderValue.parent().find('.rangeslider__handle')[0];
                const handleRect = handle.getBoundingClientRect();
                const sliderRect = $sliderValue.parent().find('.slider')[0].getBoundingClientRect();
                const handleLeft = handleRect.left - sliderRect.left + (handleRect.width / 2) - ($sliderValue.outerWidth() / 2);
                $sliderValue.css('left', handleLeft + 'px');
            }
        });
    </script>


</body>

</html>