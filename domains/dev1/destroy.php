<?php
session_start();
 if(empty($_SESSION['auth'])) {
     header("location: /page_login.php ");
 }

$user_id = $_GET['id'];
$auth_id = $_SESSION['user_id'];
$admin = $_SESSION['admin'];


function user_is_owner($id,$auth_id) {
    if($id == $auth_id){
        return true;
    }
    return false;
}

function is_admin($admin){
    if($admin === "admin") {
        return true;
    }
    return false;
}


if ( is_admin($admin) || user_is_owner($user_id,$auth_id)  ) {

    $pdo = new PDO("mysql:host=localhost;dbname=diplom","root","root");
    $sql = 'DELETE FROM user WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id'=>$user_id,
    ]);

    if (user_is_owner($user_id,$auth_id)) {
        unset($_SESSION['auth']);
        unset($_SESSION['admin']);
        unset($_SESSION['user_id']);
        $_SESSION['message']='Вы удалили свой профиль';
        header("Location: /page_login.php");
    }elseif( is_admin($admin)) {
        $_SESSION['message']='Вы удалили профиль другого пользователя';
        header("Location: /users.php");
    }




}else {
    $_SESSION['message']='вы не можете удалить профиль';
}
?>