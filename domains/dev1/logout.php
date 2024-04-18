<?php
session_start();
unset($_SESSION['auth']);

header("Location: /page_login.php");
