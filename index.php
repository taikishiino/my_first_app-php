<!--登録ユーザーを一覧で並べるトップページ-->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP版SNS</title>
</head>
<body>
	<h1>PHP版SNS</h1>
	<a href="form.php">新規ユーザー登録</a>
<?php
define('DSN', 'mysql:host=127.0.0.1;port=3306;dbname=phplesson_db;charset=utf8;');
define('DB_USER', 'C9_USER');
define('DB_PASSWORD', '');
//try~catch文でエラーを表示する
try {
////データベースへの接続////
$dbh = new PDO(DSN, getenv(DB_USER), DB_PASSWORD); 	//データベースへの接続PDO　new PDO('システム:host=ホスト名;dbname=データベース名;charset=文字コード', ユーザー名, パスワード);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						//PDO実行時のエラーモードを設定
////SQLの操作コード////
$sql = "SELECT * FROM profile";					//SQL文の準備
$stmt = $dbh->query($sql);						//SQL文の実行　$stmt = 'データベースへの接続'->'query(PDOに問い合わせる)'('sql文の内容');
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	//SQL文の結果の取り出し
?>
<table>
	<tr>
		<th class="">名前</th>
		<th class="">性別</th>
		<th class="">年齢</th>
		<th class="">自己紹介</th>
	</tr>


	<?php foreach ($result as $row) {
		echo "<tr>\n";
		echo "<td>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</td>\n";		//悪意のあるコード入力をできなくする関数 htmlspecialchars(変換する変数, ENT_QUOTES(文字に変換), 'UTF-8');
		if($row['gender'] === '1') echo "<td>" . '男' . "</td>\n";
		if($row['gender'] === '2') echo "<td>" . '女' . "</td>\n";
		if($row['gender'] === '3') echo "<td>" . 'その他' . "</td>\n";
		echo "<td>" . $row['age'] . "</td>\n";
		echo "<td>" . htmlspecialchars($row['text'], ENT_QUOTES, 'UTF-8') . "</td>\n";

		echo "<td>\n";
		echo "<a href=edit.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ">変更</a>\n";
		echo "｜<a href=detail.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ">詳細</a>\n";
		echo "｜<a href=delete.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ">削除</a>\n";
		echo "</td>\n";
		echo "</tr>\n";
	}
	?>
</table>
<?php
$dbh = null;									//データベースとの接続終了（省略可能）
} catch (Exception $e) {
	echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";	//エラー発生時のメッセージを取得$e->getMessage()
	die();		//エラー発生したら処理中止die();
}
?>
</body>
</html>
