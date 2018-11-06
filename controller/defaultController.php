<?php

	include_once('UserController.php');
	include_once('TeamController.php');
	include_once('InviteController.php');
	include_once('TourController.php');
	include_once('NotificationController.php');
	include_once('../model/GeneralModel.php');

	if(isset($_GET["controlador"]) && isset($_GET["accion"])){
		$targetController = ucfirst($_GET["controlador"])."Controller";
		$action = $_GET["accion"];
		$targetController::$action();
	}
	?>