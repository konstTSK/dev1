<?php
session_start();

$user_id = $_GET['id']; // (string) id
$auth_id = $_SESSION['user_id']; // (string) id
$admin = $_SESSION['admin'];  // (bool) true/false


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

    if (isset($_FILES)) {
        $type = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $avatar = uniqid() . '.' . $type;
        $uploadfile = dirname(__FILE__) . '/img/demo/avatars/' . $avatar;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile);


        /*
         * подключаемся к базе и апдейтим поле пользователя
         */

        $pdo = new PDO("mysql:host=localhost;dbname=diplom", "root", "root");
        $sql = 'UPDATE user SET avatar=:avatar WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $user_id,
            'avatar' => $avatar,
        ]);

        $_SESSION['message'] = 'Аватар загружен успешно';
        header("Location: /users.php");
    }
}else{
    $_SESSION['message'] = 'у вас нет прав или вы не владелец профиля ';
    header("location: /users.php");
    exit;
}


?>