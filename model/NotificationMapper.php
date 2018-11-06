<?php
include_once "../model/BDConnection.php";
class NotificationMapper{

    //Guarda en la BD una invitacion notificación.
    public static function saveNoti($notification){  
        $db = new BDConnection();
            
            $insertNoti = "INSERT INTO notifications (emisor,receptor,message,dateN,idTour) VALUES ('";
            $insertNoti = $insertNoti.$notification->getEmisor()."','".$notification->getReceptor()."','".$notification->getMessage()."','".$notification->getDateN()."','".$notification->getIdTour()."')";
            $db->consulta($insertNoti) or die('Error al crear la notificación');
            return true;
   
        
        $db->desconectar();
    }

	
    //Devuelve los ids de los torneos que tienen alguna notificacion pendiente.
    public static function getAdminNotis($userId){
        $db = new BDConnection();
        $result = $db->consulta("SELECT DISTINCT idTour FROM notifications WHERE receptor=\"$userId\"");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return NULL;
        }
    }

    //Devuelve los datos de las notificaciones de un torneo especifico.
    public static function getTourNotis($idTour){
        $db = new BDConnection();
        $result = $db->consulta("SELECT * FROM notifications WHERE idTour=\"$idTour\" ORDER BY dateN DESC");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return NULL;
        }
    }

    //Devuelve true si el admin tiene notificaciones pendientes.
    public static function hasNotis($idUser) {
        $db = new BDConnection();
        $sqlexiste = $db->consulta("SELECT * FROM notifications WHERE receptor=\"$idUser\"");
        $busqueda = mysqli_num_rows($sqlexiste);
        if( $busqueda > 0) {
            return true;
        }
    }


    //Borra una notificacion.
    public static function deleteNoti($idNoti){
        $db = new BDConnection();

            $resultado = $db->consulta("DELETE FROM notifications WHERE idNoti=\"$idNoti\"");
            return $resultado;
    }
}