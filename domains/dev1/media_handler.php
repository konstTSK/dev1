<?php
session_start();

$user_id = $_GET['id']; // (string) id
$auth_id = $_SESSION['user_id']; // (string) id
$admin = $_SESSION['admin'];  // (bool) true/false


function user_owner($id,$auth_id){
    if ($id == $auth_id){
        return true;
    }

}


function user_is_not_owner($id,$auth_id) {
    if($id != $auth_id){
        return true;
    }

}

function is_admin($admin){
    if($admin == 1) {
        return true;
    }

}

if ( (!is_admin($admin)) || (user_owner($user_id,$auth_id))) {
    $_SESSION['message']='У вас нет прав редактировать фото';
    header("Location: /users.php");
  exit;
}



if (isset($_FILES)) {
  $type = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
  $avatar = uniqid().'.'.$type;
  $uploadfile =  dirname(__FILE__).'/img/demo/avatars/'.  $avatar;
  move_uploaded_file($_FILES['avatar']['tmp_name'],$uploadfile);



  /*
   * подключаемся к базе и апдейтим поле пользователя
   */

   $pdo = new PDO("mysql:host=localhost;dbname=diplom","root","root");
   $sql = 'UPDATE user SET avatar=:avatar WHERE id = :id';
   $stmt = $pdo->prepare($sql);
   $stmt->execute([
       'id'=>$user_id,
       'avatar'=>$avatar,
   ]);

   $_SESSION['message']='Аватар загружен успешно';
    header("Location: /users.php");
}


?>