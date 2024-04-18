<?php
session_start();

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);



$pdo = new PDO("mysql:host=localhost;dbname=diplom","root","root");

$sql = 'SELECT * FROM user WHERE email=:email ';
$stmt = $pdo->prepare($sql);
$stmt->execute(['email'=>$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);



if (password_verify($_POST['password'], $user['password'])) {
    $_SESSION['auth'] = true;
    $_SESSION['admin']= $user['admin'];
    header("Location: /users.php");
}else {
    $_SESSION['message']='Не верный логин или пароль';
    header("Location: /page_login.php");
}

?>