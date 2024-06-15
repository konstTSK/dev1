<?php
session_start();
$user_id = $_GET['id'];

// тут проверка админ или владелец


$email = $_POST['email'];
$password = $_POST['password'];
$password_confirmation = $_POST['password_confirmation'];

$pdo = new PDO("mysql:host=localhost;dbname=diplom","root","root");
$sql = 'SELECT * FROM user WHERE email=:email';
$stmt = $pdo->prepare($sql);
$stmt->execute(['email'=>$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);




if(empty($user)){

    $sql = 'UPDATE user SET email=:email , password=:password WHERE id=:id';
    $stmt = $pdo->prepare($sql);
   $a=  $stmt->execute([
        'id'=>$user_id,
        'email'=> $email,
        'password'=>$password,
    ]);

    $_SESSION['message']='Данные обновлены';
    header("Location: /users.php");
}else{
    $_SESSION['message']='Логин занят другим пользователем';
    header("Location: /users.php");
}
?>