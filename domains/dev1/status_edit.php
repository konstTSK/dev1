<?php
session_start();

$user_id = $_SESSION['user_id'];
$status = $_POST['status'];


$pdo = new PDO ("mysql:host=localhost;dbname=diplom","root","root");
$sql = 'UPDATE user SET status=:status WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->execute([
        'status'=>$status,
        'id'=>$user_id,
]);

$_SESSION['message']='СТАТУС обновлен';
header("Location: /users.php");
?>