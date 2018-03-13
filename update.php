<!---編集した内容をデータベースに反映するためのフォルダ-->
<?php
define('DSN', 'mysql:host=127.0.0.1;port=3306;dbname=phplesson_db;charset=utf8;');
define('DB_USER', 'C9_USER');
define('DB_PASSWORD', '');

///受け取った値をすべて変数に格納///
$name = $_POST['name'];
$gender = (int) $_POST['gender'];
$age = (int) $_POST['age'];
$text = $_POST['text'];

try {
if (empty($_POST['id'])) 															//その変数が空かどうか確かめるempty($_GET['id'])
throw  new Exception('ID不正');
$id = (int) $_POST['id'];

////データベースとの接続////
$dbh = new PDO(DSN, getenv(DB_USER), DB_PASSWORD);	//データベースへの接続PDO　new PDO('システム:host=ホスト名;dbname=データベース名;charset=文字コード', ユーザー名, パスワード);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

////SQLの操作コード////
$sql = "UPDATE profile SET name = ?, gender = ?, age = ?, text = ?";										//?のidをもつSQLをアップデートする
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1, $name, PDO::PARAM_STR);											//?に入る値の指定bindValue(何番目の?か？, 当てはめる変数, PDO::PARAM_INT（値の型）)
$stmt->bindValue(2, $gender, PDO::PARAM_INT);
$stmt->bindValue(3, $age, PDO::PARAM_INT);
$stmt->bindValue(4, $text, PDO::PARAM_STR);
$stmt->execute();
$dbh = null;

echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "さんのプロフィールの更新が完了しました。<br>";
echo "<a href='index.php'>トップページへ戻る</a>";

} catch (Exception $e) {
	echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";	//エラー発生時のメッセージを取得$e->getMessage()
	die();		//エラー発生したら処理中止die();
}
?>