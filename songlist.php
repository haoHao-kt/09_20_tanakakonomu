<?php

include('functions.php');
$comp_id = $_GET['comp_id'];
$pdo = createPDO();


//曲のリスト取得
$sql = 'select * from SONG_LIST where composer_id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $comp_id, PDO::PARAM_INT);
$status = $stmt->execute();

$view='';
if ($status==false) {
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<li class="list-group-item">';
        $view .= '<p>'.$result['song_name'].'</p>';
        $view .= '<div class="none_fav">いいね！'.$result['fav_count'].'</div>';
        $view .= '</li>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>songlist</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
<body>
        <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">songs</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href=""></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div>
        <?=$view?>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- <script src="main.js"></script> -->
<script>
//fav機能(INCREMENT)
$(".none_fav").on('click', function () {
    console.log("aaaaaa");
    let setID= 2010;
    const data = {
        "post_comp_id":setID
    };
    $.ajax({
            url:'incFav.php',
            type:'post',
            data: data,
            dataType: 'json'
        })
        // Ajaxリクエストが成功した時発動
        .done( (data) => {
            // console.log(data);
            // if(data.length==0){
            //     console.log("no data");
            //     $('.card-body').empty();
            //     $('.card-body').html("no data");
            // }
            // showCard(data);

            console.log("SUCCESS");
            console.log(data);
        })
        // Ajaxリクエストが失敗した時発動
        .fail( (XMLHttpRequest, textStatus, errorThrown) => {
            // $('.result').html(data);
            console.log(XMLHttpRequest + textStatus + errorThrown);
        })
        // Ajaxリクエストが成功・失敗どちらでも発動
        .always( (data) => {
            console.log('done');
        });
});






</script>


</body>
</html>