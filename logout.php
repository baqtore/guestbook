<?php
require_once 'db.php';
unset($_SESSION['loged_user']);
header('location: /login.php');
?>