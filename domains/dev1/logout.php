<?php
session_start();

unset($_SESSION['auth']);
unset($_SESSION['admin']);

header("Location: /page_login.php");
