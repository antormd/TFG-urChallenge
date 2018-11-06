<!--
======================================================================
Modelo de la tabla Invites
======================================================================
-->

<?php
// file: model/Invite.php
/**
 * Class Invite
 * 
 * Representa una invitación a un equipo en la web
 * 
 */
class Invite {
 
  private $idInv;
  private $idInviter;
  private $idInvited;
  private $idTeam;
  private $status;
  private $dateI;
  
  
   // El constructor
 
  public function __construct($idInv=NULL,$idInviter=NULL,$idInvited=NULL, $idTeam=NULL,$dateI=NULL) {
    $this->idInv = $idInv;
    $this->idInviter = $idInviter;
    $this->idInvited = $idInvited; 
    $this->idTeam = $idTeam;
    $this->dateI = $dateI;
  }
  
  // idInv
  public function getIdInv() {
    return $this->idInv;
  }

  // idInviter
  public function getIdInviter() {
    return $this->idInviter;
  }
  
  public function setIdInviter($idInviter) {
    $this->idInviter = $idInviter;
  }
  
  // idInvited
  public function getIdInvited() {
    return $this->idInvited;
  }
 
  public function setIdInvited($idInvited) {
    $this->idInvited = $idInvited;
  }

  // idTeam
  public function getIdTeam() {
    return $this->idTeam;
  }  
   
  public function setIdTeam($idTeam) {
    $this->idTeam = $idTeam;
  }

  // status
  public function getStatus() {
    return $this->status;
  }  
   
  public function setStatus($status) {
    $this->status = $status;
  }

  // dateI

  public function getDateI() {
    return $this->dateI;
  }  
   
  public function setDateI($dateI) {
    $this->dateI = $dateI;
  }

  //Llamada al mapper para guardar una invitación.
  public static function saveInvite($invite){  
    return InviteMapper::saveInvite($invite);
  }

  //Llamada al mapper para conseguir las invitaciones de un jugador.
  public static function invitesById($userId){
      return $list = InviteMapper::invitesById($userId);
  }



}