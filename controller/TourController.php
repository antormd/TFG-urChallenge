<?php
class TourController{

//Funcion para de crear un torneo.
public static function createTour() {
	if(!isset($_SESSION)) session_start();	
	//Recibimos los datos para crear el torneo mediantes un formulario.
	$name = $_POST['name'];
	$type = $_POST['tipe'];
	$places = $_POST['plazas'];
	$players = $_POST['jugadores'];
	$iniT = $_POST['iniT'];
	$endT = $_POST['endT'];
	$created = $_SESSION['userID'];

						//Si no existe un torneo con el mismo nombre al recibido entonces crea uno nuevo y le asigna los valores recibidos.
						if(!TourMapper::exists($name)){
								$tour = new Tour();
								$tour->setName($name);
								$tour->setTourType($type);
								$tour->setPlaces($places);
								$tour->setPlayersNumb($players);
								$tour->setIniT($iniT);
								$tour->setEndT($endT);
								$tour->setCreatedBy($created);
								$tour->saveTour($tour);

								header("Location: ../view/adminindex.php");

							
						}else{
							ob_start();
	  						header("Location: ../view/adminindex.php");
							$errors = array();
							$errors["general"] = "ERROR.El nombre de torneo ya existe.";
							echo $errors["general"];
							ob_end_flush();
						}
					}

//Funcion que obtiene la lista de torneos creados por un usuario del tipo admin.
public static function getToursById($userId){
			if(!isset($_SESSION)) session_start();
			$tours = Tour::toursById($userId);
			return $tours;
}

//Funcion que obtiene la lista de todos los torneos existentes en la BD.
public static function getTours(){
			if(!isset($_SESSION)) session_start();
			$tours = Tour::getTours();
			return $tours;
}

//Funcion que obtiene el numero de equipos inscritos en un torneo dado.
public static function getPlacesLeft($idTour){
			$places = Tour::getPlacesLeft($idTour);
			return $places;
}

//Funcion que obtiene los partidos de un equipo en un torneo.
public static function getTeamMatchs($idTeam,$idTour){
			$ptos = Tour::getTeamMatchs($idTeam,$idTour);
			return $ptos;
}

//Funcion que obtiene todos los partidos de un torneo.
public static function getAllMatchs($idTour){
			$allm = Tour::getAllMatchs($idTour);
			return $allm;
}

//Funcion para que un equipo se inscriba en el torneo.
public static function joinTour(){
	if(!isset($_SESSION)) session_start();	
	$idTeam = $_POST['equipos'];
	$idTour = $_POST ['idTour'];
	$idUser = $_POST ['idUser'];

	//Numero de jugadores del equipo.
	$resultado = Team::IsTeamValid($idTeam);
	$players = $resultado->fetch_row();
	//Numero de jugadores permitidos en el torneo.
	$resultado1 = Tour::getPlayers($idTour);
	$tplayers = $resultado1->fetch_row();
	//Numero de equipos ya inscritos.
	$resultado2 = TourController::getPlacesLeft($idTour);
    $plazasocupadas = $resultado2->fetch_row();
    //Numero de plazas del torneo.
    $tour = TourController::getTour($idTour);
    $plazastotales = $tour->getPlaces();

    //Si ya tiene un equipo inscrito en el torneo no puede inscribir otro
    if (!Tour::alreadyATeam($idTour,$idUser)) {
	//Si el numero de equipos inscritos es menor que el numero de plazas entonces se puede inscribir en el torneo.
		if ($plazasocupadas[0]<$plazastotales) {
	//Si el numero de jugadores del equipo sobrepasa el limite del torneo no puede inscribirse en el.
			if ($players[0]<=$tplayers[0]) {
				$team_tour = TourMapper::newTourTeam($idTeam,$idTour);
				header("Location: ../view/scoutour.php?id=$idTour");
			}else{
				ob_start();
				$errors = array();
				$errors["general"] = "ERROR.El equipo no cumple las normas para inscribirse en el torneo.";
				echo $errors["general"];
				echo "Su equipo tiene $players[0] jugadores y el máximo permitido por el torneo es $tplayers[0]";
				//header("Location: ../view/scoutour.php?id=$idTour");
				ob_end_flush();
			}	
		}else{
			ob_start();
			$errors = array();
			$errors["general"] = "ERROR.Plazas del torneo agotadas";
			echo $errors["general"];
			//header("Location: ../view/scoutour.php?id=$idTour");
			ob_end_flush();

		}
	}else{
		ob_start();
		$errors = array();
		$errors["general"] = "ERROR.Ya tienes un equipo inscrito";
		echo $errors["general"];
		//header("Location: ../view/scoutour.php?id=$idTour");
		ob_end_flush();
	}

}

//Funcion con la que se obtiene una lista con los equipos inscritos en un torneo.
public static function getTourTeams($idTour){
			if(!isset($_SESSION)) session_start();
			$teams = Tour::getTourTeams($idTour);
			return $teams;
	}

//Funcion con la que se obtienen los datos de un torneo especifico.
public static function getTour($idTour){
			$tour = Tour::getDataById($idTour);
			return $tour;
}

//Funcion con la que se obtienen los datos de un equipo especifico en un torneo.
public static function getTourTeamByUser($userId,$idTour){
			$team = Tour::getTourTeamByUser($userId,$idTour);
			return $team;
}

//Funcion con la que se actualiza la descripcion del torneo.
public static function updateDes() {
	if(!isset($_SESSION)) session_start();
		$description = $_POST['descripcion'];
		$idTour = $_POST ['idTour'];
		Tour::updateDes($description,$idTour);

		header("Location: ../view/gestour.php?id=$idTour");
}

//Funcion con la que se actualiza el icono del torneo.
public static function updateIcon(){
		if(!isset($_SESSION)) session_start();

				$idTour= $_POST["idTour"];
		
				$nombre_img = $_FILES['icono']['name'];
				$tipe = $_FILES['icono']['type'];
				$tamano = $_FILES['icono']['size'];

						//Si la imagen utilizada por el usuario cumple alguno de los formatos validos se guarda en la carpeta /images y se actualiza en la BD.
						if($_FILES['icono']['type']=="image/jpeg" || $_FILES['icono']['type']=="image/png" || $_FILES['icono']['type']=="image/jpg"){
							    $ruta = "../images";
								$nombreArchivo = $_FILES['icono']['name'];
								move_uploaded_file($_FILES['icono']['tmp_name'], $ruta."/".$nombreArchivo);
								Tour::updateIcon($idTour,$nombreArchivo);
								header("Location: ../view/gestour.php?id=$idTour");
								}else{
							ob_start();
							header("refresh: 3; url = ../view/urtours.php");
							$errors = array();
							$errors["general"] = "ERROR. Formato de icono no válido.";
							echo $errors["general"];
						  	ob_end_flush();
						}
	
}

//Funcion con la que se pone inicio al torneo y se crean los partidos correspondientes.
public static function iniTour(){
	if(!isset($_SESSION)) session_start();
	$idTour= $_POST["idTour"];

	//Obtenemos los datos del torneo.
	$tour = Tour::getDataById($idTour);

	//Obtenemos el numero de equipos inscritos.
	$result = TourController::getPlacesLeft($idTour);
    $plazas = $result->fetch_row();

    //Obtenemos los ids de los equipos inscritos en el torneo
    $row = Tour::TourTeamsList($idTour);

	//Comprobamos que el numero de equipos sea por lo menos mayor que 1.
	if ($plazas[0]>1) {

	//Comprobamos que el torneo no haya sido iniciado ya.
		if(!MatchupMapper::exists($idTour)){

	//Comprobamos el tipo de torneo.
			if ($tour->getTourType() == "0") {

				//Se crea array con ids de los equipos.
				$arrayids = array();
				foreach ($row as $teams) {
					array_push($arrayids,$teams['idTeam']);
				}

				//Se crea un array con el tamaño calculado con la formula de la combinatoria sin repeticion.
				$pairs = array();
				$aux = array((count($arrayids) * (count($arrayids) - 1)) / 2);
				$pairs[] = $aux;

				//Se inserta en el array creado en cada posicion una pareja de ids de equipos.
				$pos = 0;
 				for ($i = "0"; $i < count($arrayids); $i++) {
					for ($j = $i + 1; $j < count($arrayids); $j++) {
					$pairs[$pos++] = [$arrayids[$i], $arrayids[$j]];
					}
				}
				//Por cada par de ids se crea un partido.
				foreach ($pairs as $matchs) {
					
					//Se mezclan de forma aleatoria los valores de los pares de ids. con la finalidad de tener aleatoriedad a la hora de decidir equipo local.
					shuffle($matchs);

          			//Se crea un partido con los valores correspondientes.
          			$matchup = new Matchup();
					$matchup->setMatchType($tour->getTourType());
					$matchup->setTeamVisitor($matchs[0]);
					$matchup->setTeamLocal($matchs[1]);
					$matchup->setTourId($idTour);
					$matchup->saveMatchup($matchup);
					header("Location: ../view/gestour.php?id=$idTour");
    				}

			}elseif ($tour->getTourType() == "1") {
				//Se crea array con ids de los equipos.
				$arrayids = array();
				foreach ($row as $teams) {
					array_push($arrayids,$teams['idTeam']);
				}

				//Se crea un array con el tamaño calculado con la formula de la combinatoria sin repeticion.
				$pairs = array();
				$aux = array((count($arrayids) * (count($arrayids) - 1)) / 2);
				$pairs[] = $aux;

				//Se inserta en el array creado en cada posicion una pareja de ids de equipos.
				$pos = 0;
 				for ($i = "0"; $i < count($arrayids); $i++) {
					for ($j = $i + 1; $j < count($arrayids); $j++) {
					$pairs[$pos++] = [$arrayids[$i], $arrayids[$j]];
					}
				}
				//Por cada par de ids se crea un partido.
				foreach ($pairs as $matchs) {
					
					//Se crea un partido con los valores correspondientes.
          			$matchup = new Matchup();
					$matchup->setMatchType($tour->getTourType());
					$matchup->setTeamVisitor($matchs[0]);
					$matchup->setTeamLocal($matchs[1]);
					$matchup->setTourId($idTour);
					$matchup->saveMatchup($matchup);

					//Se crea otro partido con los valores correspondientes con orden inverso en los ids para crear la ida y vuelta.
					$matchup = new Matchup();
					$matchup->setMatchType($tour->getTourType());
					$matchup->setTeamVisitor($matchs[1]);
					$matchup->setTeamLocal($matchs[0]);
					$matchup->setTourId($idTour);
					$matchup->saveMatchup($matchup);
					header("Location: ../view/gestour.php?id=$idTour");
    				}

			}elseif ($tour->getTourType() == "2") {

				//Si el numero de equipos no es multiplo de 2 y 4 no se pueden crear emparejamientos equilibrados. Ejemplos validos (dieciseisavos, octavos...)
				if ($plazas[0]%2==0 AND $plazas[0]%4==0) {

					//Se crea array con ids de los equipos.
					$arrayids = array();
					foreach ($row as $teams) {
						array_push($arrayids,$teams['idTeam']);
					}

					//Se mezclan de forma aleatoria los valores de los pares de ids. con la finalidad de crear eliminatorias aleatorias.
					shuffle($arrayids);

					//Se crea un array con el tamaño del numero de equipos entre 2 para crear parejas de equipos.
					$pairs = array();
					$aux = array(count($arrayids) / 2);
					$pairs[] = $aux;

					//Se inserta en el array creado en cada posicion una pareja de ids de equipos.
					$pos = 0;
 					for ($i = "0"; $i < count($arrayids); $i+=2) {
						$pairs[$pos++] = [$arrayids[$i], $arrayids[$i+1]];
					}
					//Por cada par de ids se crea un partido.
					foreach ($pairs as $matchs) {

						//Se crea un partido con los valores correspondientes.
						$matchup = new Matchup();
						$matchup->setMatchType($tour->getTourType());
						$matchup->setTeamVisitor($matchs[0]);
						$matchup->setTeamLocal($matchs[1]);
						$matchup->setTourId($idTour);
						$matchup->saveMatchup($matchup);
						header("Location: ../view/gestour.php?id=$idTour");
						}
							
				}else{
					echo "El numero de equipos para crear este tipo de torneo tiene que ser multiplo de 4";
				}
			}elseif ($tour->getTourType() == "3") {
				//Si el numero de equipos no es multiplo de 2 y 4 no se pueden crear emparejamientos equilibrados. Ejemplos validos (dieciseisavos, octavos...)
				if ($plazas[0]%2==0 AND $plazas[0]%4==0) {

					//Se crea array con ids de los equipos.
					$arrayids = array();
					foreach ($row as $teams) {
						array_push($arrayids,$teams['idTeam']);
					}

					//Se mezclan de forma aleatoria los valores de los pares de ids. con la finalidad de crear eliminatorias aleatorias.
					shuffle($arrayids);

					//Se crea un array con el tamaño del numero de equipos entre 2 para crear parejas de equipos.
					$pairs = array();
					$aux = array(count($arrayids) / 2);
					$pairs[] = $aux;

					//Se inserta en el array creado en cada posicion una pareja de ids de equipos.
					$pos = 0;
 					for ($i = "0"; $i < count($arrayids); $i+=2) {
						$pairs[$pos++] = [$arrayids[$i], $arrayids[$i+1]];
					}
					//Por cada par de ids se crea un partido.
					foreach ($pairs as $matchs) {

						//Se crea un partido con los valores correspondientes.
						$matchup = new Matchup();
						$matchup->setMatchType($tour->getTourType());
						$matchup->setTeamVisitor($matchs[0]);
						$matchup->setTeamLocal($matchs[1]);
						$matchup->setTourId($idTour);
						$matchup->saveMatchup($matchup);

						//Se crea un partido con los valores correspondientes pero con las ids inversas para crear la vuelta.
						$matchup = new Matchup();
						$matchup->setMatchType($tour->getTourType());
						$matchup->setTeamVisitor($matchs[1]);
						$matchup->setTeamLocal($matchs[0]);
						$matchup->setTourId($idTour);
						$matchup->saveMatchup($matchup);
						header("Location: ../view/gestour.php?id=$idTour");
						}
							
				}else{
					echo "El numero de equipos para crear este tipo de torneo tiene que ser multiplo de 4";
				}
			}elseif ($tour->getTourType() == "4") {

				//Se crea array con ids de los equipos.
				$arrayids = array();
				foreach ($row as $teams) {
					array_push($arrayids,$teams['idTeam']);
				}

				//Se mezclan de forma aleatoria los valores de los pares de ids. con la finalidad de crear grupos aleatorios.
				shuffle($arrayids);

				//Si el toneo tiene menos de 8 equipos entonces se crea lo mismo que en unla liga con solo ida.
				if (count($arrayids)<8) {

				//Se crea un array con el tamaño calculado con la formula de la combinatoria sin repeticion.
				$pairs = array();
				$aux = array((count($arrayids) * (count($arrayids) - 1)) / 2);
				$pairs[] = $aux;

				//Se inserta en el array creado en cada posicion una pareja de ids de equipos.
				$pos = 0;
 				for ($i = "0"; $i < count($arrayids); $i++) {
					for ($j = $i + 1; $j < count($arrayids); $j++) {
					$pairs[$pos++] = [$arrayids[$i], $arrayids[$j]];
					}
				}
				//Por cada par de ids se crea un partido.
				foreach ($pairs as $matchs) {
					
					//Se mezclan de forma aleatoria los valores de los pares de ids. con la finalidad de tener aleatoriedad a la hora de decidir equipo local.
					shuffle($matchs);

          			//Se crea un partido con los valores correspondientes.
          			$matchup = new Matchup();
					$matchup->setMatchType($tour->getTourType());
					$matchup->setTeamVisitor($matchs[0]);
					$matchup->setTeamLocal($matchs[1]);
					$matchup->setTourId($idTour);
					$matchup->saveMatchup($matchup);
					header("Location: ../view/gestour.php?id=$idTour");
    				}	
				}else{

					//Numero de grupos.
					$ngroups = $_POST['ngroups'];

					//Si el numero de equipos inscritos es multiplo al numero de grupos que quiere el administrador.
					if (count($arrayids)%$ngroups==0) {

						//Numero de equipos por grupo
						$grpteams = count($arrayids)/$ngroups;

						//Se crea otro array en el que se subdivide el array con ids de los equipos en el numero de grupos.
						$arraygrp = array_chunk($arrayids, $grpteams);
						$grp = 1;

						//Por cada subarray con los ids de equipos.
						foreach ($arraygrp as $arrayg) {
							for ($i=0; $i < count($arrayg); $i++) { 

								//Se crea una instacia de un grupo
								Tour::createGroup($idTour,$arrayg[$i],$grp);
							}

							//Despues de haber creado los grupos se crean tantos arrays como grupos haya con las ids de los equipos de estos grupos.
							$rowTeams = Tour::getGroupTeams($idTour,$grp);
							$rowTeamId = array();
							foreach ($rowTeams as $rTeams) {
								array_push($rowTeamId,$rTeams['idTeam']);
							}

							//Se crea un array con el tamaño calculado con la formula de la combinatoria sin repeticion.
							$pairs = array();
							$aux = array((count($rowTeamId) * (count($rowTeamId) - 1)) / 2);
							$pairs[] = $aux;

							//Se inserta en el array creado en cada posicion una pareja de ids de equipos.
							$pos = 0;
 							for ($i = "0"; $i < count($rowTeamId); $i++) {
								for ($j = $i + 1; $j < count($rowTeamId); $j++) {
									$pairs[$pos++] = [$rowTeamId[$i], $rowTeamId[$j]];
								}
							}
							//Por cada par de ids se crea un partido.
							foreach ($pairs as $matchs) {
					
							//Se mezclan de forma aleatoria los valores de los pares de ids. con la finalidad de tener aleatoriedad a la hora de decidir equipo local.
							shuffle($matchs);

          					//Se crea un partido con los valores correspondientes.
          					$matchup = new Matchup();
							$matchup->setMatchType($tour->getTourType());
							$matchup->setTeamVisitor($matchs[0]);
							$matchup->setTeamLocal($matchs[1]);
							$matchup->setTourId($idTour);
							$matchup->saveMatchup($matchup);
							header("Location: ../view/gestour.php?id=$idTour");
    						}

							$grp+=1;
						}
					}
					else{
						echo "El numero de equipos debe ser multiplo del numero de grupos para crear grupos equilibrados";
					}
				}

			}else{
				echo "No existe este tipo de toneo";
			}
	//Exiten partidos para ese torneo.		
		}else{
			ob_start();
			$errors = array();
			$errors["general"] = "ERROR.Este torneo ya ha iniciado los emparejamientos";
			echo $errors["general"];
			//header("Location: ../view/gestour.php?id=$idTour");
			ob_end_flush();
		}
	//El numero de equipos inscritos es < 2.
	}else{
		ob_start();
		$errors = array();
		$errors["general"] = "ERROR.El numero de equipos inscritos es menor a 2";
		echo $errors["general"];
		//header("Location: ../view/gestour.php?id=$idTour");
		ob_end_flush();
	}

}

//Funcion que comprueba si existe un partido en un torneo.
public static function existMatch($idTour){
	return 	MatchupMapper::exists($idTour);			
}

}
			
