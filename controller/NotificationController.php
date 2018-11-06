<?php
class NotificationController{

//Funcion que crea una notificacion para un usuario de la web.
public static function createNoti() {

	if(!isset($_SESSION)) session_start();	

	$idTour = $_POST['idTour'];
	$emisor = $_SESSION['userID'];
	$message = $_POST['descripcion'];
	$dateN = date('Y-m-d H:i:s');

	$tour = TourController::getTour($idTour);
	$receptor = $tour -> getCreatedBy();

	echo $receptor;
	echo "<p>";
	echo $emisor;
	echo "<p>";
	echo $idTour;
	echo "<p>";
	echo $message;
	echo "<p>";
	echo $dateN;
	echo "<p>";

    $notificacion = new Notification();

		$notificacion->setEmisor($emisor);
		$notificacion->setReceptor($receptor);
		$notificacion->setMessage($message);
		$notificacion->setDateN($dateN);
		$notificacion->setIdTour($idTour);

		$notificacion->saveNoti($notificacion);
		header("Location: ../view/mygames.php?id=$idTour");
}

//Funcion que obtiene todas las notificaciones para un admin.
public static function getAdminNotis($userId){
			$notis = Notification::getAdminNotis($userId);
			return $notis;
}

//Funcion que obtiene todas las notificaciones de un torneo para un admin.
public static function getTourNotis($idTour){
			$tNotis = Notification::getTourNotis($idTour);
			return $tNotis;
}

//Funcion que obtiene todas las notificaciones de un torneo para un admin.
public static function hasNotis($idUser){
			$hasN = Notification::hasNotis($idUser);
			return $hasN;
}



//Funcion para borrar una notificacion.
public static function deleteNoti(){
	if(!isset($_SESSION)) session_start();
			$idTour = $_POST['idTour'];	
			$idNoti = $_POST['idNoti'];
			Notification::deleteNoti($idNoti);
			header("Location: ../view/tourinfo.php?id=$idTour");
}

}
			

