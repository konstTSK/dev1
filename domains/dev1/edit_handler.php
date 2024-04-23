<?php
session_start();


$id = $_GET['id'];
if (($_SESSION['admin'] != true) || $_SESSION['user_id'] != $id) {
    $_SESSION['message'] = 'Вы можете редактировать тольк свой профиль';
    header("location: /page_login.php ");
    exit;
}


$name = $_POST['name'];
$work = $_POST['work'];
$phone = $_POST['phone'];
$addres = $_POST['addres'];


$pdo = new PDO("mysql:host=localhost;dbname=diplom","root","root");
$sql = 'UPDATE `user` SET `name`=:name,`work`=:work,`phone`=:phone,`addres`=:addres WHERE `id`=:id';
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'name'=>$name,
    'work'=>$work,
    'phone'=>$phone,
    'addres'=>$addres,
    'id'=>$id,
]);

$_SESSION['message']='Данные обновлены';
header("location: /users.php");

?>