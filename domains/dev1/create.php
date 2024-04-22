<?php
session_start();

$name = $_POST['name'];
$work = $_POST['work'];
$phone = $_POST['phone'];
$addres = $_POST['addres'];

$email = $_POST['email'];
$password = $_POST['password']; // нужно захешировать в идеале

//


$status = $_POST['status'];
switch ($status) {
    case 'Онлайн':
        $status ='success';
        break;
    case 'Отошел':
        $status ='warning';
        break;
    case 'Не беспокоить':
        $status ='danger';
        break;
}

if (isset($_FILES)) {
   // var_dump($_FILES);
    // сохранит ькартинку !
    //  1. получаем расширенее файла
    $type = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    // 2. задаем имя и расширение файла
    $avatar = uniqid().'.'.$type;
    // 3. полная директория с менем файла и расширением где будет лежать файл
    $uploadfile =  dirname(__FILE__).'/img/demo/avatars/'.  $avatar;

    // 4. вызываем функцию сохранения файла
    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile);

}

$pdo = new PDO("mysql:host=localhost;dbname=diplom","root","root");
$sql = 'SELECT * FROM user WHERE email = :email';
$stmt = $pdo->prepare($sql);
$stmt->execute(['email'=>$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!empty($user)) {

    echo 'пользователь существует';
    exit;
}

if (empty($user)) {
    $sql = 'INSERT INTO user (email, password, name, work, phone, addres, status, avatar) VALUE (:email, :password, :name, :work, :phone, :addres, :status, :avatar)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'email' => $email,
        'password' => $password,
        'name' => $name,
        'work' => $work,
        'phone' => $phone,
        'addres' => $addres,
        'status' => $status,
        'avatar' => $avatar,
    ]);


    $_SESSION['message'] = 'Пользователь создан';
    header("Location: /users.php");
}
?>