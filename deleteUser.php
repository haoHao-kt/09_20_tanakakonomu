<?php
//関数ファイルの読み込み
include('functions.php');

//GET
$id   = $_GET['id'];

//ユーザー削除SQL文の実行
$pdo = createPDO();
$sql = 'DELETE FROM user_table WHERE id =:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//ユーザー一覧画面にリダイレクト
if ($status==false) {
    errorMsg($stmt);
} else {
    header('Location: userList.php');
    exit;
}
