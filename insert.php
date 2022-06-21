<?php
//入力チェッ, 値が空っぽだったら処理を決めてしまう　なぜか動かない
// if(
//   !isset($_POST["name"])|| $_POST["name"]==""||
//   !isset($_POST["email"])|| $_POST["email"]==""||
//   !isset($_POST["naiyou"])|| $_POST["naiyou"]==""
// ){
// exit('ParamError');
// }


//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ


$book = $_POST['book'];
$url = $_POST['url'];
$comment = $_POST['comment'];

//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=tionbsm_gs_db;charset=utf8;host=mysql57.tionbsm.sakura.ne.jp','tionbsm','********');//xampの設定がrootがユーザー名パスワードなし
} catch (PDOException $e) {
  exit('DBConnection Error:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("insert into gs_bm_table(book, url, comment, datetime ) VALUES (:book, :url, :comment, sysdate())");
$stmt->bindValue(':book', $book, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)　文字の場合はSTR 数字の場合はINT
$stmt->bindValue(':url', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// 上の:と連動している、その後に：の中に変数を入れていく　pdoのprepareという関数の中に入れる

$status = $stmt->execute();
// 最後にexecuteで実行する　$statusに全てが入っている


//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  exit();//ここまででコードの実行はOKです　処理が終わったらheaderのところに飛ばします　index.phpに戻して上げる

}
?>
