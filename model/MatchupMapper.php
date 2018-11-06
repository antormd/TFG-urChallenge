<?php
include_once "../model/BDConnection.php";
class MatchupMapper{
    

//Comprueba si existe un partido en un torneo especifico.
public static function exists($idTour) {
    $db = new BDConnection();
    $sqlexiste = $db->consulta("SELECT * FROM matchups WHERE tourId=\"$idTour\"");
    $busqueda = mysqli_num_rows($sqlexiste);
    if( $busqueda > 0) {
        return true;
    }
}

//Guarda un usuario nuevo en la BD.
public static function saveMatchup($matchup){  
    $db = new BDConnection();
    $insertMatchup = "INSERT INTO matchups (matchtype,teamvisitor,teamlocal,tourId) VALUES ('";
    $insertMatchup = $insertMatchup.$matchup->getMatchType()."','".$matchup->getTeamVisitor()."','".$matchup->getTeamLocal()."','".$matchup->getTourId()."')";
    $db->consulta($insertMatchup) or die('Error al crear el partido');
    return true;
    $db->desconectar();
}

}