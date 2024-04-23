<?php
session_start();
$user_email = $_GET['email'];

// тут проверка админ или владелец


$email = $_POST['email'];
$password = $_POST['password'];
$password_confirmation = $_POST['password_confirmation'];

$pdo = new PDO("mysql:host=localhost;dbname=diplom","root","root");
$sql = 'SELECT * FROM user WHERE email=:email';
$stmt = $pdo->prepare($sql);
$stmt->execute(['email'=>$user_email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);




if(empty($user)){

    $sql = 'UPDATE user SET email=:email , password=:password WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id'=>$user['id'],
        'email'=> $email,
        'password'=>$password,
    ]);

    $_SESSION['message']='Данные обновлены';
    header("Location: /users.php");
}else{
    $_SESSION['message']='Данные обновлены';
    header("Location: /users.php");
}
?>