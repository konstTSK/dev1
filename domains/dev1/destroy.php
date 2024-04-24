<?php
session_start();

function user_is_owner($id) {
    if ($id == $_SESSION['user_id'] ) {
        return true;
    }
    return false;
}

$user_id = $_GET['id'];
$current_user_id = $_SESSION['user_id'];
$owner = user_is_owner($user_id);


if ( $_SESSION['admin'] !== false && $owner !== false ) {
    $_SESSION['message']='У вас нет прав удалить учетную запись';
    header("Location: /users.php");
    exit;
}

if($owner == true) {
  echo 'вы удаляее другого';

}else {
    echo 'вы удаляее себя';
}


?>