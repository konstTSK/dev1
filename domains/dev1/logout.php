<?php
session_start();

unset($_SESSION['auth']);
unset($_SESSION['admin']);
unset($_SESSION['user_id']);

header("Location: /page_login.php");
