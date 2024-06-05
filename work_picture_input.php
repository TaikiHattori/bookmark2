<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB連携（入力画面）</title>
</head>

<body>
    <form action="work_picture_create.php" method="POST" enctype="multipart/form-data">
        <!-- enctype追加↑ -->

        <fieldset>
            <legend>DB連携（入力画面）</legend>
            <a href="work_picture_read.php">一覧画面</a>
            <div>
                title: <input type="text" name="taitoru">
            </div>
            <div>
                picture: <input type="file" name="gazou" accept="gazou/*">
                <!-- accept追加↑ -->

            </div>
            <div>
                <button>submit</button>
            </div>
            <!-- <a href="work_picture_create.php">create画面</a> -->
            <!-- ↑入れたらダメかも -->

        </fieldset>
    </form>

</body>

</html>