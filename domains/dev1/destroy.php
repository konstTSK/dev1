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

}

function is_admin($admin){
    if($admin === "admin") {
        return true;
    }
    return false;
}


if ( is_admin($admin) || user_is_owner($user_id,$auth_id)  ) {

    echo 1;

}else {
    echo 2;
}
?>