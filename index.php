<?php
session_start();
if (!(isset($_SESSION['login'])))
	header('location:./view/login.php');
else
	header('location:./view/login.php');
?>