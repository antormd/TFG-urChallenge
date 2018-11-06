<?php
include_once "../model/BDConnection.php";
class TeamMapper{

    //Comprueba que exista en la BD un equipo con ese nombre.
	public static function exists($name) {
        $db = new BDConnection();
        $sqlexiste = $db->consulta("SELECT * FROM teams WHERE name=\"$name\"");
        $busqueda = mysqli_num_rows($sqlexiste);
        if( $busqueda > 0) {
            return true;
        }
    }

    //Guarda en la BD un equipo nuevo.
    public static function saveTeam($team){  
        $db = new BDConnection();
            
            $insertTeam = "INSERT INTO teams (name,shield,teamType,createBy) VALUES ('";
            $insertTeam = $insertTeam.$team->getName()."','".$team->getShield()."','".$team->getTeamType()."','".$team->getCreateBy()."')";
            $db->consulta($insertTeam) or die('Error al crear el equipo');
            return true;
   
        
        $db->desconectar();
    }

    //Obtiene los equipos creados por un usuario.
    public static function teamsById($userId){
        $db = new BDConnection();
        $result = $db->consulta("SELECT * FROM teams WHERE createBy=\"$userId\"");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return NULL;
        }
    }

    //Obtiene los ids de los equipos creados por un usuario.
    public static function idTeamsById($userId){
        $db = new BDConnection();
        $sqlTeams = $db->consulta("SELECT teamId FROM teams WHERE createBy=\"$userId\"");
        $arrayTeams = array();
        while ($row_teams = mysqli_fetch_assoc($sqlTeams))
            $arrayTeams[] = $row_teams;
        $db->desconectar();
        return $arrayTeams;
    }

    //Obtiene los ids de los equipos creados por un usuario.
    public static function idToursByTeamId($teamId){
        $db = new BDConnection();
        $sqlTours = $db->consulta("SELECT idTour FROM team_tour WHERE idTeam=\"$teamId\"");
        $arrayTours = array();
        while ($row_tours = mysqli_fetch_assoc($sqlTours))
            $arrayTours[] = $row_tours;
        $db->desconectar();
        return $arrayTours;
    }


    //Obtiene los ids de los equipos de un jugador.
    public static function getPlayerTeams($idPlayer){
        $db = new BDConnection();
        $result = $db->consulta("SELECT * FROM player_team  WHERE idPlayer=\"$idPlayer\"");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return NULL;
        }
    }

    //Comprueba que exista un equipo con ese id.
    public static function isValidTeam($teamId) {
        $db = new BDConnection();
        $sqlesvalido = $db->consulta("SELECT * FROM teams WHERE teamId=\"$teamId\"");
        $busqueda = mysqli_num_rows($sqlesvalido);
        if( $busqueda > 0) {
            return true;
        }
    }

    //Obtiene la informacion de un equipo a partir de su id.
    public static function findByIdTeam($teamId){
        $db = new BDConnection();
        $sqlfind = $db->consulta('SELECT * FROM teams WHERE teamId ="'.$teamId.'"');
        if (mysqli_num_rows($sqlfind) > 0) {
            $row = mysqli_fetch_assoc($sqlfind);

            $team= new Team($row['teamId'],$row['name'],$row['shield'],$row['teamType'],$row['createBy']);
            return $team;
        } else {
            return NULL;
        }
    }

    //Comprueba que exista una relacion entre un equipo y un jugador especificos.
    public static function existRel($idTeam,$userId) {
        $db = new BDConnection();
        $sqlexiste = $db->consulta("SELECT * FROM player_team WHERE idTeam=\"$idTeam\" AND idPlayer =\"$userId\"");
        $busqueda = mysqli_num_rows($sqlexiste);
        if( $busqueda > 0) {
            return true;
        }
    }

    //Elimina un torneo de la BD.
    public static function deleteTeam($idTeam){
        $db = new BDConnection();
        $result =  $db->consulta("DELETE FROM teams WHERE teamId=\"$idTeam\"");
        return $result;
    }

    //Elimina la relacion entre un equipo y cualquier jugador.
    public static function deletePlayerTeam($idTeam){
        $db = new BDConnection();
        $result = $db->consulta("DELETE FROM player_team WHERE idTeam=\"$idTeam\"");
        return $result;
    }

    //Elimina la relacion entre un equipo y cualquier torneo.
    public static function deleteTeamTour($idTeam){
        $db = new BDConnection();
        $result = $db->consulta("DELETE FROM team_tour WHERE idTeam=\"$idTeam\"");
        return $result;
    }

    //Obtiene el numero de jugadores de un equipo.
    public static function isTeamValid($idTeam) {
        $db = new BDConnection();
        $result = $db->consulta("SELECT COUNT(idPlayer) FROM player_team WHERE idTeam=\"$idTeam\"");
        return $result;
        }


}