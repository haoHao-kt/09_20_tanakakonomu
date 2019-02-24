<?php

//DB接続用インスタンス生成
function createPDO(){
$dbn = 'mysql:dbname=gs_f02_db20;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = 'root';
    try {
        $pdo = new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        exit('dbError:'.$e->getMessage());
    }
return $pdo;
}


//プルダウンオプションの取得
function getOption($sql,$pdo){
    $stmt = $pdo->prepare($sql);
    $status = $stmt->execute();
    $options='';
    if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
    } else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options .= '<option value="'.$result['id'].'">';
        $options .= $result['name'];
        $options .= '</option>';
        }
    };
    return $options;
};

// SESSIONチェック＆リジェネレイト
function chk_ssid()
{
    // ログイン失敗時の処理（ログイン画面に移動）
    if(!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid']!=session_id()){
        header('Location: login.php');
    }else{
    // ログイン成功時の処理（一覧画面に移動）
        session_regenerate_id(true);
        $_SESSION['chk_ssid'] = session_id();
    }
}

// menuを決める
function menu($kanri_flg)
{
    if($kanri_flg == 0){
        $menu = '<li class="nav-item"><a class="nav-link" href="main.php">トップページ</a></li><li class="nav-item"><a class="nav-link" href="select.php">todo一覧</a></li>';
        $menu .= '<li class="nav-item"><a class="nav-link" href="logout.php">ログアウト</a></li>';
    }else{
        $menu = '<li class="nav-item"><a class="nav-link" href="main.php">トップページ</a></li><li class="nav-item"><a class="nav-link" href="select.php">todo一覧</a></li>';
        $menu .= '<li class="nav-item"><a class="nav-link" href="inputUser.php">ユーザー登録</a></li><li class="nav-item"><a class="nav-link" href="select.php">todo一覧</a></li>';
        $menu .= '<li class="nav-item"><a class="nav-link" href="index.php">ユーザー一覧</a></li><li class="nav-item"><a class="nav-link" href="select.php">todo一覧</a></li>';
        $menu .= '<li class="nav-item"><a class="nav-link" href="logout.php">ログアウト</a></li>';
    }
    return $menu;
}
