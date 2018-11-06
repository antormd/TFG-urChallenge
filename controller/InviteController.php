<?php
class InviteController{

//Funcion que crea una invitacion para un jugador a un equipo.
public static function invitePlayer() {

	if(!isset($_SESSION)) session_start();	
	$idInviter = $_SESSION['userID'];
	$idInvited = $_POST['idInvited'];
	$idTeam = $_POST['idTeam'];
	$status = 0;
	$dateI = date('Y-m-d H:i:s');

	//Se comprueba si ya se ha realizado una invitacion a ese jugador a ese equipo o si el jugador la ha rechazado.
    if(!(InviteMapper::exists($idTeam,$idInvited))or(InviteMapper::isRefused($idTeam,$idInvited))){

    $invite = new Invite();

    	//En caso negativo se crea la invitacion.
		$invite->setIdInviter($idInviter);
		$invite->setIdInvited($idInvited);
		$invite->setIdTeam($idTeam);
		$invite->setStatus($status);
		$invite->setDateI($dateI);

		$invite->saveInvite($invite);
		header("Location: ../view/gesteam.php?id=$idTeam");


	}else{
		ob_start();
	  	//header("Location: ../view/urteam.php");
		$errors = array();
		$errors["general"] = "ERROR.Ya existe una invitación para este jugador.";
		echo $errors["general"];
	ob_end_flush();
	}

}

//Funcion con la que se obtienen las invitaciones de un jugador especifico.
public static function getInvitesById($userId){
			if(!isset($_SESSION)) session_start();
			$invites = Invite::invitesById($userId);
			return $invites;
}

//Funcion con la que un jugador acepta una invitacion creando una relacion equipo-jugador.
public static function aceptInv(){
	if(!isset($_SESSION)) session_start();	
	$idInvited = $_SESSION['userID'];
	$idTeam = $_POST['idTeam'];

	$player_team = InviteMapper::newPlayerTeam($idTeam,$idInvited);
	//Se borra la invitacion una vez aceptada/rechazada.
	$inviteAcepted = InviteMapper::deleteInvite($idTeam,$idInvited);

	header("Location: ../view/notify.php");
}

//Funcion con la que un jugador rechaza una invitacion a un equipo.
public static function denyInv(){
	if(!isset($_SESSION)) session_start();	
	$idInvited = $_SESSION['userID'];
	$idTeam = $_POST['idTeam'];

	//Se borra la invitacion una vez aceptada/rechazada.
	$inviteRefused = InviteMapper::deleteInvite($idTeam,$idInvited);

	header("Location: ../view/notify.php");

}

		
			}
			

