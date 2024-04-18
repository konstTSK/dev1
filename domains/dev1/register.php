<?php
session_start();

// получаем данные с регистрационной формы
//

$login =  $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$pdo = new PDO("mysql:host=localhost;dbname=diplom","root","root");
$sql = 'SELECT * FROM user WHERE email =:login';
$stmt = $pdo->prepare($sql);
$stmt->execute(['login'=> $login]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);



if (empty($user)){
    // тут процесс регистрации пользователя в БД
    $sql = 'INSERT INTO user (email, password) VALUE (:email,:password)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email'=>$login,'password'=>$password]);
    // потом нужно перекинуть пользователя на страницу входа
    $_SESSION['message']='Регистрация успешна ! Можете войти!!!';
    header("Location: /page_login.php");
}

if(!empty($user)) {
   $_SESSION['message']='такой пользователь уже есть';

   header("Location: /page_register.php");
}
