<!--登録ユーザーを削除する-->

<?php
header('Content-Type: text/html; charset=UTF-8');	//文字化けを回避（文字コードを指定するheader関数）

define('DSN', 'mysql:host=127.0.0.1;port=3306;dbname=phplesson_db;charset=utf8;');
define('DB_USER', 'C9_USER');
define('DB_PASSWORD', '');

try {
if (empty($_GET['id'])) 															//その変数が空かどうか確かめるempty($_GET['id'])
throw  new Exception('ID不正');
$id = (int) $_GET['id'];

////データベースとの接続////
$dbh = new PDO(DSN, getenv(DB_USER), DB_PASSWORD);	//データベースへの接続PDO　new PDO('システム:host=ホスト名;dbname=データベース名;charset=文字コード', ユーザー名, パスワード);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

////SQLの操作コード////
$sql = "DELETE FROM profile where id = ?";										//?のidをもつSQLを削除する
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1, $id, PDO::PARAM_INT);											//?に入る値の指定bindValue(何番目の?か？（idしか扱ってないので１）, 当てはめる変数, PDO::PARAM_INT（値の型）)
$stmt->execute();
$dbh = null;

echo "ユーザーコード：" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . "のプロフィールの削除が完了しました。<br>";
echo "<a href='index.php'>トップページへ戻る</a>";

} catch (Exception $e) {
	echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";	//エラー発生時のメッセージを取得$e->getMessage()
	die();		//エラー発生したら処理中止die();
}
?>
