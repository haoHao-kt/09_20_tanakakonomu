<?php
// セッションのスタート
session_start();
include('functions.php');
$pdo = createPDO();


//全曲リストの取得
$sql = 'SELECT com.name, song.song_name, song.fav_count 
        FROM M_COMPOSER  AS com 
        INNER JOIN SONG_LIST AS song
        ON com.id = song.composer_id
        ORDER BY song.fav_count DESC';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

$ranking='';
$rank=1;
if ($status==false) {
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
        $ranking .= "<div class=\"card\" style=\"width: 18rem;\">";
        $ranking .= "<div class=\"card-header\">";
        $ranking .= "Ranking";
        $ranking .= "</div>";
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ranking .= "<ul class=\"list-group list-group-flush\">";
        $ranking .= "<li class=\"list-group-item\">";
        $ranking .= "<p>${rank}位</p>";
        $ranking .= "<p>${result["name"]}</p>";
        $ranking .= "<p>${result["song_name"]}</p>";
        $ranking .= "<p>いいね！の数${result["fav_count"]}</p>";
        $ranking .= "</li>";
        $ranking .= "</ul>";

        $rank++;
    }
    $ranking .= "</div>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ranking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
        <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">songs</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="main.php">曲検索</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inputUser.php">ユーザー登録</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="userList.php">ユーザー一覧</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
<body>
<?=$ranking?>    
</body>
</html>