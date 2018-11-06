<!--
======================================================================
Modelo de la tabla Notification
======================================================================
-->

<?php
// file: model/Notification.php
/**
 * Class Notification
 * 
 * Representa una una notificación enviada por un usuario a otro en la web
 * 
 */
class Notification {
 
  private $idNoti;
  private $emisor;
  private $receptor;
  private $message;
  private $dateN;
  private $idTour;
  
  
   // El constructor
 
  public function __construct($idNoti=NULL,$emisor=NULL,$receptor=NULL, $message=NULL,$dateI=NULL,$idTour=NULL) {
    $this->idNoti = $idNoti;
    $this->emisor = $emisor;
    $this->receptor = $receptor; 
    $this->message = $message;
    $this->dateI = $dateI;
    $this->idTour = $idTour;
  }
  
  // idNoti
  public function getIdNoti() {
    return $this->idNoti;
  }

  // emisor
  public function getEmisor() {
    return $this->emisor;
  }
  
  public function setEmisor($emisor) {
    $this->emisor = $emisor;
  }
  
  // receptor
  public function getReceptor() {
    return $this->receptor;
  }
 
  public function setReceptor($receptor) {
    $this->receptor = $receptor;
  }

  // message
  public function getMessage() {
    return $this->message;
  }  
   
  public function setMessage($message) {
    $this->message = $message;
  }

  // dateN

  public function getDateN() {
    return $this->dateN;
  }  
   
  public function setDateN($dateN) {
    $this->dateN = $dateN;
  }

  // idTour

  public function getIdTour() {
    return $this->idTour;
  }  
   
  public function setIdTour($idTour) {
    $this->idTour = $idTour;
  }


  //Llamada al mapper para guardar una notificación.
  public static function saveNoti($notification){  
    return NotificationMapper::saveNoti($notification);
  }

  //Llamada al mapper para conseguir las notificaciones de un admin.
  public static function getAdminNotis($userId){
      return $notis = NotificationMapper::getAdminNotis($userId);
  }

  //Llamada al mapper para conseguir las notificaciones de un admin para cada torneo.
  public static function getTourNotis($idTour){
      return $notis = NotificationMapper::getTourNotis($idTour);
  }

  //Llamada al mapper para saber si existen notificaciones para ese usuario.
  public static function hasNotis($idUser){
      return $notis = NotificationMapper::hasNotis($idUser);
  }

  //Llama al mapper para eliminar una notificacion de la BD.
  public static function deleteNoti($idNoti){  
    return NotificationMapper::deleteNoti($idNoti);
  }






}