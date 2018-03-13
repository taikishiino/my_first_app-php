<?php
define('DSN', 'mysql:host=127.0.0.1;port=3306;dbname=phplesson_db;charset=utf8;');
define('DB_USER', 'C9_USER');
define('DB_PASSWORD', '');

try {
if (empty($_GET['id'])) 															//その変数が空かどうか確かめるempty($_GET['id'])
throw  new Exception('ID不正');
$id = (int) $_GET['id'];        //

////データベースとの接続////
$dbh = new PDO(DSN, getenv(DB_USER), DB_PASSWORD);	//データベースへの接続PDO　new PDO('システム:host=ホスト名;dbname=データベース名;charset=文字コード', ユーザー名, パスワード);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

////SQLの操作コード////
$sql = "SELECT * FROM profile where id = ?";										//?のidをもつSQLを取得する準備
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1, $id, PDO::PARAM_INT);											//?に入る値の指定bindValue(何番目の?か？（idしか扱ってないので１）, 当てはめる変数, PDO::PARAM_INT（値の型）)
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);											//$stmtの結果を配列で保存
$dbh = null;
}catch (Exception $e) {
	echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";	//エラー発生時のメッセージを取得$e->getMessage()
	die();		//エラー発生したら処理中止die();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>プロフィール編集フォーム</title>
</head>
<body>
    <h2>プロフィール編集フォーム</h2>
    <form method="post" action="update.php">
        名前:<input type="text" name="name" value="<?php echo htmlspecialchars( $result['name'], ENT_QUOTES, 'UTF-8') ?>" required/><br>          <!--入力必須にするrequired/-->
        性別：<input type="radio" name="gender" value="1" <?php if($result['gender']===1) echo "checked" ?> required/>男
        <input type="radio" name="gender" value="2" <?php if($result['gender']===2) echo "checked" ?> required/>女
        <input type="radio" name="gender" value="3" <?php if($result['gender']===3) echo "checked" ?> required/>その他<br>
        年齢：
        <select name="age" id="ages"/>
            <option value="<?php echo htmlspecialchars( $result['age'], ENT_QUOTES, 'UTF-8') ?>"><?php echo htmlspecialchars( $result['age'], ENT_QUOTES, 'UTF-8') ?></option>
            <?php for($i=1; $i<=100; $i++){
                //php内でのhtmlの表示方法\n
                echo "<option value=\"$i\">$i</option>\n";
            }
            ?>
        </select>
        <br>
        自己紹介
        <br>
        <textarea cols="50" rows="3" maxlength="200" name="text"><?php echo htmlspecialchars( $result['text'], ENT_QUOTES, 'UTF-8') ?></textarea>
        <br>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'); ?>"/>		<!--見えないフォームでidを受け渡す-->
        <input type="submit" value="送信"/>
    </form>

</body>
</html>