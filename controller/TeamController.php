<?php
class TeamController{

//Funcion para crear un equipo.
public static function createTeam() {
	if(!isset($_SESSION)) session_start();	
	//Se reciben los datos para crear el equipo de un formulario.
	$name = $_POST['name'];
	$type = $_POST['type'];
	$userId = $_SESSION['userID'];
	$nombre_img = $_FILES['shield']['name'];
	$tipe = $_FILES['shield']['type'];
	$tamano = $_FILES['shield']['size'];

				//Si la imagen utilizada por el usuario cumple alguno de los formatos validos se guarda en la carpeta /images y se actualiza en la BD.
				if($_FILES['shield']['type']=="image/jpeg" || $_FILES['shield']['type']=="image/png" || $_FILES['shield']['type']=="image/jpg"){
						//Si no existe un equipo con el nombre recibido se crea uno con los datos recibidos.
						if(!TeamMapper::exists($name)){
								$ruta = "../images";
								$nombreArchivo = $_FILES['shield']['name'];
								move_uploaded_file($_FILES['shield']['tmp_name'], $ruta."/".$nombreArchivo);
								$team = new Team();
								$team->setName($name);
								$team->setTeamType($type);
								$team->setCreateBy($userId);
								$team->setShield($nombreArchivo);
								$team->saveTeam($team);

								header("Location: ../view/captainindex.php");

							
						}else{
							ob_start();
	  						header("Location: ../view/newteam.php");
							$errors = array();
							$errors["general"] = "ERROR.El nombre de equipo ya existe.";
							echo $errors["general"];
							ob_end_flush();
						}
					}else{
						ob_start();
						header("Location: ../view/newteam.php");
						$errors = array();
						$errors["general"] = "ERROR. Formato de imagen no válido.";
						echo $errors["general"];
						ob_end_flush();
					}}

//Funcion que consigue la lista de equipos creados por un usuario.
public static function getTeamsById($userId){
			if(!isset($_SESSION)) session_start();
			$teams = Team::teamsById($userId);
			return $teams;
}


//Funcion que consigue la lista de ids de los equipos creados por un usuario.
public static function getIdTeamsById($userId){
			if(!isset($_SESSION)) session_start();
			$teams = Team::idTeamsById($userId);
			return $teams;
}

//Funcion que consigue la lista de ids de los torneos disputados por un equipo.
public static function getToursByTeamId($teamId){
			if(!isset($_SESSION)) session_start();
			$tours = Team::idToursByTeamId($teamId);
			return $tours;
}

//Funcion que consigue los datos de un equipo especifico.
public static function getTeam($teamId){
				if(!isset($_SESSION)) session_start();
				$team = NULL;
				$team = Team::getData($teamId);
				if ($team == NULL){
					ob_start();

					header("refresh: 3; url = ../view/urteam.php");

					$errors = array();

					$errors["general"] = "El equipo no existe";
					echo $errors["general"];
					ob_end_flush();
				}else{
					return $team;
				}
	}

//Se crea la relacion entre capitan y su equipo en la que pasa a ser un jugador mas de este.
public static function captainTeam($idTeam){
	if(!isset($_SESSION)) session_start();
	$userId = $_SESSION['userID'];

	if(!(TeamMapper::existRel($idTeam,$userId))){
	$player_team = InviteMapper::newPlayerTeam($idTeam,$userId);
	}
}

//Funcion para borrar un equipo.
public static function deleteTeam(){
	if(!isset($_SESSION)) session_start();
			$idTeam = $_POST['idTeam'];
					//Antes de borrar el equipo borras las relaciones entre jugadores y equipos.		
					TeamMapper::deletePlayerTeam($idTeam);
					//Antes de borrar el equipo borras las relaciones entre el equipo y torneos.
					TeamMapper::deleteTeamTour($idTeam);
					//Entonces se borra el equipo.		
					TeamMapper::deleteTeam($idTeam);
					header("Location: ../view/urteam.php");
		
			}

//Funcion que obtiene la lista de jugadores de un equipo.
public static function getTeamPlayers($idTeam){
			if(!isset($_SESSION)) session_start();
			$players = User::getTeamPlayers($idTeam);
			return $players;
	}

//Funcion que obtiene la lista de equipos de un jugador.
public static function getPlayerTeams($idPlayer){
			if(!isset($_SESSION)) session_start();
			$teams = Team::getPlayerTeams($idPlayer);
			return $teams;
	}


//Funcion que obtiene los datos de un jugador de un equipo.
public static function getPlayer($userId){
			$user = User::getDataById($userId);
			return $user;
}

}
			

