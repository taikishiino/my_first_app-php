<!--ユーザー登録するフォーム-->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>プロフィール入力フォーム</title>
</head>
<body>
    <h2>新規登録フォーム</h2>
    <form method="post" action="add.php">
        <!--入力必須にするrequired/-->
        名前:<input type="text" name="name" required/><br>
        性別：<input type="radio" name="gender" value="1" required/>男
        <input type="radio" name="gender" value="2" required/>女
        <input type="radio" name="gender" value="3" required/>その他<br>
        年齢：
        <select name="age" id="ages" required/>
            <option value="">選択してください</option>
            <?php for($i=1; $i<=100; $i++){
                //php内でのhtmlの表示方法\n
                echo "<option value=\"$i\">$i</option>\n";
            }
            ?>
        </select>
        <br>
        自己紹介：
        <br>
        <textarea cols="50" rows="3" maxlength="200" name="text"></textarea>
        <br>
        <input type="submit" value="送信"/>
    </form>

</body>
</html>