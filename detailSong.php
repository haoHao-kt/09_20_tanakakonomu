<?php
// セッションのスタート
session_start();
include('functions.php');
$pdo = createPDO();

// $comp_id = $_GET['comp_id'];
// $song_id = $_GET['song_id'];

$comp_id = '1000';
$song_id = '10';

//作曲者情報の再取得
$sql = 'select * from M_COMPOSER where id = :comp_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':comp_id', $comp_id, PDO::PARAM_INT);
$status = $stmt->execute();

$comp_info='';
if ($status==false) {
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $comp_info .= '<div class="card" style="width: 18rem;">';
        $comp_info .= '<img src="'.$result['img_url'].'" class="card-img-top" alt="image">';
        $comp_info .= '<div class="card-body">';
        $comp_info .= '<h5 class="card-title">'.$result['name'].'</h5>';
        $comp_info .= '<input id="compid" type ="hidden" value="'.$result['id'].'"></div>';
        $comp_info .= '</div>';
        $comp_info .= '</div>';
    }
}

//曲の詳細情報を取得する
$sql = 'SELECT * FROM SONG_DETAIL AS DETAIL
        INNER JOIN SONG_LIST AS LIST 
        ON DETAIL.song_id = LIST.id AND
        DETAIL.comp_id = LIST.composer_id
        WHERE 
        DETAIL.comp_id = :comp_id AND 
        DETAIL.song_id = :song_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':comp_id', $comp_id, PDO::PARAM_INT);
$stmt->bindValue(':song_id', $song_id, PDO::PARAM_INT);
$status = $stmt->execute();

$song_info='';
if ($status==false) {
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    // while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // }
$rs = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($rs);

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>曲詳細</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
<style>
.card{
margin : 0 auto;
}
</style>

<body>
<?=$comp_info?>
<div class="container">
        <div class="form-group">
            <label for="songname">曲名</label>
            <input type="text" class="form-control" id="songname" name="songname" disabled="readonly" value="<?=$rs['song_name']?>">
        </div>
        <div class="form-group">
            <label for="deadline">いいね！</label>
            <input type="text" class="form-control" id="fav" name="fav" disabled="readonly" value="<?=$rs['fav_count']?>">
        </div>
        <div class="form-group">
            <label for="comment">コメント</label>
            <textarea class="form-control" id="comment" name="comment" rows="3" disabled="readonly"><?=$rs['comment']?></textarea>
        </div>
</div>
<script>


</script>    
</body>
</html>