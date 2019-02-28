<?php
//include
include('functions.php');

if(
    !isset($_POST['post_comp_id'])
){
    exit('ParamError');
}

//1.  DB接続&送信データの受け取り
$pdo = createPDO();
$comp_id = $_POST['post_comp_id'];

//2. データ登録SQL作成
$sql = 'UPDATE SONG_LIST SET fav_count = fav_count - 1 WHERE composer_id =:comp_id and id = 1';
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':comp_id', $comp_id, PDO::PARAM_STR);
$res = $stmt->execute();

//3. SQL実行時にエラーがある場合
if ($res==false) {
    queryError($stmt);
}


//2. データ登録SQL作成
$sql = 'select * from SONG_LIST where composer_id =:comp_id';
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':comp_id', $comp_id, PDO::PARAM_STR);
$res = $stmt->execute();

//3. SQL実行時にエラーがある場合
if ($res==false) {
    queryError($stmt);
}
//4. 抽出データ数を取得
$val = $stmt->fetch();

echo json_encode($val['fav_count']);
