 <?php
//sessionを開始する
session_start();

//関数ファイルの読み込み
include('functions.php');

//sessionIDのチェック&再生成
chk_ssid();

//session変数の読み込み
$sessonId = $_SESSION['chk_ssid'];
$kanriFlg = $_SESSION['kanri_flg'];
$userName = $_SESSION['name'];

//プルダウンリストの読み込み
$pdo = createPDO();
//時代
$sql_1 = "select name ,id from CODE_TABLE where code_name = 'age'";
$age_options=getOption($sql_1,$pdo);
//国名
$sql_2 = "select name ,id from CODE_TABLE where code_name = 'country'";
$country_options=getOption($sql_2,$pdo);

?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>songs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        /* div{
            padding: 10px;
            font-size:16px;
            } */

        #echo {
            height: 100px;
        }
    </style>
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
                        <a class="nav-link" href="ranking.php">いいね！ランキング</a>
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
    <form id="form">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="selectAge">Options</label>
            </div>
            <select class="custom-select" name="selectAge">
                <option>Choose...</option>
                <?=$age_options?>            
            </select>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="selectCountry">Options</label>
            </div>
            <select class="custom-select" name="selectCountry">
                <option>Choose...</option>
                <?=$country_options?>            
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" id="search" type="button">Search</button>
        </div>
    </form>
    <h5>composer list</h5>
    <div class="card">
        <div class="card-body">
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- <script src="main.js"></script> -->
<script>

//作曲者カードHTMLの生成
function showCard(data){
    $('.card-body').empty();
    let card_str = '';
    card_str += '<div class="card" style="width: 18rem;">'
    for (let i = 0; i < data.length; i++) {
        card_str +=`
            <img src="${data[i].img_url}" class="card-img-top" alt="image">
            <div class="card-body">
            <h5 class="card-title">${data[i].name}</h5>
            <a href="./songlist.php?comp_id=${data[i].id}"target="_blank" class="btn btn-primary">song list</a>
            </div>`;
    }
    card_str += '</div>'
    $('.card-body').html(card_str);
};

//ajax送信
$("#search").on('click', function () {
    let setAge = $('[name="selectAge"] option:selected').val();
    let setCountry = $('[name="selectCountry"] option:selected').val();
    console.log(setAge, setCountry);
    const data = {
        "post_age":setAge,
        "post_country":setCountry
    };
    console.log(data);
    $.ajax({
            url:'getComposer.php',
            type:'post',
            data: data,
            dataType: 'json'
        })
        // Ajaxリクエストが成功した時発動
        .done( (data) => {
            console.log(data);
            if(data.length==0){
                console.log("no data");
                $('.card-body').empty();
                $('.card-body').html("no data");
            }
            showCard(data);
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


</html>