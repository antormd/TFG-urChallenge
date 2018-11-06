<?php
include_once "../model/BDConnection.php";
class InviteMapper{

    //Comprueba en la BD si ya existe una invitacion para ese jugador.
	public static function exists($idTeam,$idInvited) {
        $db = new BDConnection();
        $sqlexiste = $db->consulta("SELECT * FROM invites WHERE (idTeam=\"$idTeam\")AND(idInvited=\"$idInvited\")");
        $busqueda = mysqli_num_rows($sqlexiste);
        if( $busqueda > 0) {
            return true;
        }
    }

    //Comprueba si la invitacion esta rechazada por el jugador.
    public static function isRefused($idTeam,$idInvited) {
        $db = new BDConnection();
        $sqlexiste = $db->consulta("SELECT * FROM invites WHERE (idTeam=\"$idTeam\")AND(status=2)AND(idInvited=\"$idInvited\")");
        $busqueda = mysqli_num_rows($sqlexiste);
        if( $busqueda > 0) {
            return true;
        }
    }

    //Guarda en la BD una invitacion nueva.
    public static function saveInvite($invite){  
        $db = new BDConnection();
            
            $insertInvite = "INSERT INTO invites (idInviter,idInvited,idTeam,status,dateI) VALUES ('";
            $insertInvite = $insertInvite.$invite->getIdInviter()."','".$invite->getIdInvited()."','".$invite->getIdTeam()."','".$invite->getStatus()."','".$invite->getDateI()."')";
            $db->consulta($insertInvite) or die('Error al crear la invitación');
            return true;
   
        
        $db->desconectar();
    }


    //Devuelve true si el jugador tiene invitaciones pendientes.
    public static function hasInv($idInvited) {
        $db = new BDConnection();
        $sqlexiste = $db->consulta("SELECT * FROM invites WHERE idInvited=\"$idInvited\"");
        $busqueda = mysqli_num_rows($sqlexiste);
        if( $busqueda > 0) {
            return true;
        }
    }
	
    //Devuelve las invitaciones de un juagador.
    public static function invitesById($userId){
        $db = new BDConnection();
        $result = $db->consulta("SELECT * FROM invites WHERE idInvited=\"$userId\"");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return NULL;
        }
    }

    //Crea la relacion entre jugador y equipo.
    public static function newPlayerTeam($idTeam,$idInvited){  
        $db = new BDConnection();

          $insertRel = "INSERT INTO player_team (idPlayer, idTeam) VALUES ('";
          $insertRel = $insertRel.$idInvited."','".$idTeam."')";

          $db->consulta($insertRel) or die('Error al crear la relación');
          return true;
   
        
        $db->desconectar();
    }

    //Borra una invitación.
    public static function deleteInvite($idTeam,$idInvited){
        $db = new BDConnection();

            $resultado = $db->consulta("DELETE FROM invites WHERE idInvited=\"$idInvited\" AND idTeam = \"$idTeam\"");
            return $resultado;
    }
}