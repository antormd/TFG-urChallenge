<!--
======================================================================
Modelo de la tabla Team
======================================================================
-->

<?php
// file: model/Team.php
/**
 * Class Team
 * 
 * Representa un equipo en la web
 * 
 */
class Team {
 
  private $teamId;
  private $name;
  private $shield;
  private $teamType;
  private $createBy;
  
  
   // El constructor
 
  public function __construct($teamId=NULL,$name=NULL,$shield=NULL, $teamType=NULL,$createBy=NULL) {
    $this->teamId = $teamId;
    $this->name = $name;
    $this->shield = $shield; 
    $this->teamType = $teamType;
    $this->createBy = $createBy;
  }
  
  // teamId
  public function getTeamId() {
    return $this->teamId;
  }

  // name
  public function getName() {
    return $this->name;
  }
  
  public function setName($name) {
    $this->name = $name;
  }
  
  // shield
  public function getShield() {
    return $this->shield;
  }
 
  public function setShield($shield) {
    $this->shield = $shield;
  }

  // teamType
  public function getTeamType() {
    return $this->teamType;
  }  
   
  public function setTeamType($teamType) {
    $this->teamType = $teamType;
  }

  // createBy
  public function getCreateBy() {
    return $this->createBy;
  }  
   
  public function setCreateBy($createBy) {
    $this->createBy = $createBy;
  }

  //Llama al mapper para guardar un equipo nuevo en la BD.
  public static function saveTeam($team){  
    return TeamMapper::saveTeam($team);
  }

  //Llama al mapper para obtener los equipos de un usuario.
  public static function teamsById($userId){
      return $list = TeamMapper::teamsById($userId);
  }

  //Llama al mapper para obtener los ids de los equipos de un usuario.
  public static function idTeamsById($userId){
      return $list = TeamMapper::idTeamsById($userId);
  }

  //Llama al mapper para obtener los ids de los torneos disputados de un equipo.
  public static function idToursByTeamId($teamId){
      return $list = TeamMapper::idToursByTeamId($teamId);
  }

  //Llama al mapper para obtener los datos de un equipo.
  public static function getData($teamId) {
    if ($teamId) {
        //Comprueba que exista el equipo.
        if ($res = TeamMapper::isValidTeam($teamId)) {
                return TeamMapper::findByIdTeam($teamId);
        } else {
                echo "ERROR: El equipo seleccionado no existe.";
            }
        } else {
            return "ERROR, no existe el equipo seleccionado";
        }
  }

  //Llama al mapper para  obtener los equipos a los que pertenece un jugador.
  public static function getPlayerTeams($idPlayer){
      return $teams = TeamMapper::getPlayerTeams($idPlayer);
  }

  //Llama al mapper para comprobar el numero de jugadores que tiene un equipo y saber si puede acceder a un torneo.
  public static function isTeamValid($idTeam) {
      return  TeamMapper::isTeamValid($idTeam);
        }

}