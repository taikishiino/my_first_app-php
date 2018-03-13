<!--登録ユーザーを表示する-->

<?php
header('Content-Type: text/html; charset=UTF-8');	//文字化けを回避（文字コードを指定するheader関数）

define('DSN', 'mysql:host=127.0.0.1;port=3306;dbname=phplesson_db;charset=utf8;');
define('DB_USER', 'C9_USER');
define('DB_PASSWORD', '');

try {
if (empty($_GET['id'])) 															//その変数が空かどうか確かめるempty($_GET['id'])
throw  new Exception('ID不正');
$id = (int) $_GET['id'];															//idを数値型に変換して$idに格納
////データベースとの接続////
$dbh = new PDO(DSN, getenv(DB_USER), DB_PASSWORD);	//データベースへの接続PDO　new PDO('システム:host=ホスト名;dbname=データベース名;charset=文字コード', ユーザー名, パスワード);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
////SQLの操作コード////
$sql = "SELECT * FROM profile where id = ?";										//?の値によりとるデータが変わる
$stmt = $dbh->prepare($sql);															//SQL文の実行　$stmt = 'データベースへの接続'->'prepare(PDOで問い合わせの準備する)'('sql文の内容');
$stmt->bindValue(1, $id, PDO::PARAM_INT);											//?に入る値の指定bindValue(何番目の?か？（idしか扱ってないので１）, 当てはめる変数, PDO::PARAM_INT（値の型）)
$stmt->execute();																	//セットしたSQLを実行
$result = $stmt->fetch(PDO::FETCH_ASSOC);											//$stmtの結果を配列で保存
echo "名前：" . htmlspecialchars($result['name'], ENT_QUOTES, 'UTF-8') . "<br>\n";
if($result['gender'] === 1){
	echo "性別：男<br>\n";
}elseif($result['gender'] === 2) {
	echo "性別：女<br>\n";
}else {
	echo "性別：その他<br>\n";
}
echo "年齢：" . $result['age'] . "<br>\n";
echo "自己紹介：<br>" . nl2br(htmlspecialchars($result['text'], ENT_QUOTES, 'UTF-8')) . "<br>\n";						//nl2br()で改行を反映
$dbh = null;																		//データベースとの接続終了（省略可能）
}catch (Exception $e) {
	echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";	//エラー発生時のメッセージを取得$e->getMessage()
	die();		//エラー発生したら処理中止die();
}
?>