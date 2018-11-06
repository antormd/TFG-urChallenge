<?php
include_once "../model/BDConnection.php";
class TourMapper{

    //Comprueba si existe un torneo con ese nombre.
	public static function exists($name) {
        $db = new BDConnection();
        $sqlexiste = $db->consulta("SELECT * FROM tours WHERE name=\"$name\"");
        $busqueda = mysqli_num_rows($sqlexiste);
        if( $busqueda > 0) {
            return true;
        }
    }

    //Guarda un torneo nuevo en la BD.
    public static function saveTour($tour){  
        $db = new BDConnection();
        $insertTour = "INSERT INTO tours (name,tourType,places,playersNumb,iniT,endT,createdBy) VALUES ('";
        $insertTour = $insertTour.$tour->getName()."','".$tour->getTourType()."','".$tour->getPlaces()."','".$tour->getPlayersNumb()."','".$tour->getIniT()."','".$tour->getEndT()."','".$tour->getCreatedBy()."')";
        $db->consulta($insertTour) or die('Error al crear el torneo');
        return true;
   
        $db->desconectar();
    }

    //Obtiene los torneos creados por un usario.
    public static function toursById($userId){
        $db = new BDConnection();
        $result = $db->consulta("SELECT * FROM tours WHERE createdBy=\"$userId\"");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return NULL;
        }
    }

    //Obtiene el equipo de un torneo creado por el capitan dado.
    public static function getTourTeamByUser($userId,$idTour){
        $db = new BDConnection();
        $result = $db->consulta("SELECT D.idTeam FROM teams T, team_tour D WHERE T.createBy=\"$userId\" AND D.idTour=\"$idTour\" AND T.teamId = D.idTeam");
            return $result;
    }

    //Obtiene todos los torneos ordenador por nombre.
    public static function getTours(){
        $db = new BDConnection();
        $result = $db->consulta("SELECT * FROM tours ORDER BY name");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return NULL;
        }
    }

    //Obtiene los equipos inscritos en un torneo.
    public static function getTourTeams($idTour){
        $db = new BDConnection();
        $result = $db->consulta("SELECT * FROM team_tour  WHERE idTour=\"$idTour\"");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return NULL;
        }
    }

    //Saca una lista de los equipos de un torneo.
    public static function TourTeamsList($idTour){
        $db = new BDConnection();
        $sqlTeams = $db->consulta("SELECT idTeam FROM team_tour WHERE idTour=\"$idTour\"");
        $arrayTeams = array();
        while ($row_teams = mysqli_fetch_assoc($sqlTeams))
            $arrayTeams[] = $row_teams;
        $db->desconectar();
        return $arrayTeams;
    }

    //Obtiene los datos de un torneo buscado por id.
    public static function findTourById($idTour){
        $db = new BDConnection();
        $sqlfind = $db->consulta('SELECT * FROM tours WHERE tourId ="'.$idTour.'"');
        if (mysqli_num_rows($sqlfind) > 0) {
            $row = mysqli_fetch_assoc($sqlfind);
            
            $tour= new Tour($row['tourId'],$row['name'],$row['tourType'],$row['places'],$row['playersNumb'],$row['iniT'],$row['endT'],$row['createdBy'],$row['description'],$row['icon']);
            return $tour;
        } else {
            return NULL;
        }
    }

    //Actualiza la descripcion de un torneo.
    public function updateDes($description,$idTour){
        $db = new BDConnection();
        $result = "UPDATE tours SET description =\"$description\" WHERE tourId=\"$idTour\"";
        $db->consulta($result) or die('Error al actualizar el torneo');
        $db->desconectar();
        return true;
    }

    //Actualiza el icono de un torneo.
    public function updateIcon($idTour,$icon){
        $db = new BDConnection();
        $result = "UPDATE tours SET icon =\"$icon\" WHERE tourId=\"$idTour\"";
        $db->consulta($result) or die('Error al actualizar el torneo');
        $db->desconectar();
        return true;
    }

    //Obtiene el numero de equipos inscritos en un torneo.
    public function getPlacesLeft($idTour){
        $db = new BDConnection();
        $result = $db->consulta("SELECT COUNT(idTeam) FROM team_tour WHERE idTour=\"$idTour\"");
        return $result;
    }

    //Obtiene la info de los partidos de un equipo en un torneo.
    public static function getTeamMatchs($idTeam,$idTour) {
        $db = new BDConnection();
        $result = $db->consulta("SELECT * FROM matchups WHERE tourId=\"$idTour\" AND (teamvisitor=\"$idTeam\" OR teamlocal=\"$idTeam\") ORDER BY matchdate");
        $arrayMatchs = array();
        while ($row_matchs = mysqli_fetch_assoc($result))
            $arrayMatchs[] = $row_matchs;
        $db->desconectar();
        return $arrayMatchs;
    }

    //Obtiene la info de los partidos de un equipo en un torneo.
    public static function getAllMatchs($idTour) {
        $db = new BDConnection();
        $sqlMatchs = $db->consulta("SELECT * FROM matchups WHERE tourId=\"$idTour\" ORDER BY matchdate");
        $arrayMatchs = array();
        while ($row_matchs = mysqli_fetch_assoc($sqlMatchs))
            $arrayMatchs[] = $row_matchs;
        $db->desconectar();
        return $arrayMatchs;
    }

    //Obtiene el numero maximo de jugadores de un equipo para un torneo.
    public static function getPlayers($idTour) {
        $db = new BDConnection();
        $result = $db->consulta("SELECT playersNumb FROM tours WHERE tourId=\"$idTour\"");
        return $result;
        }

    //Crea la relacion entre un equipo inscrito a un torneo.
    public static function newTourTeam($idTeam,$idTour){  
        $db = new BDConnection();
        $insertRel = "INSERT INTO team_tour (idTeam, idTour) VALUES ('";
        $insertRel = $insertRel.$idTeam."','".$idTour."')";
        $db->consulta($insertRel) or die('Error al crear la relación');
        return true;
    
        $db->desconectar();
    }

    //Crea la relacion entre un equipo inscrito a un torneo.
    public static function createGroup($tourId,$teamId,$groupId){  
        $db = new BDConnection();
        $insertRel = "INSERT INTO tour_group (idTour, idTeam, idGroup) VALUES ('";
        $insertRel = $insertRel.$tourId."','".$teamId."','".$groupId."')";
        $db->consulta($insertRel) or die('El torneo ya se ha iniciado y los grupos ya estan creados');
        return true;
    
        $db->desconectar();
    }

    public static function getGroupTeams($idTour,$grp){  
        $db = new BDConnection();
        $result = $db->consulta("SELECT idTeam FROM tour_group WHERE idTour=\"$idTour\" AND idGroup=\"$grp\"");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }else {
            return NULL;
        }

    }  

    //Comprueba si ya existe un equipo de ese capitan en el torneo.
    public static function alreadyATeam($idTour,$idUser) {
        $db = new BDConnection();
        $sqlexiste = $db->consulta("SELECT * FROM teams T, team_tour D WHERE T.createBy=\"$idUser\" AND D.idTour=\"$idTour\"");
        $busqueda = mysqli_num_rows($sqlexiste);
        if( $busqueda > 0) {
            return true;
        }
    }

}