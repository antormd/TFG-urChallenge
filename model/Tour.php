<!--
======================================================================
Modelo de la tabla Tour
======================================================================
-->

<?php
// file: model/Tour.php
/**
 * Class Tour
 * 
 * Representa un torneo en la web
 * 
 */
class Tour {
 
  private $tourId;
  private $name;
  private $tourType;
  private $places;
  private $playersNumb;
  private $iniT;
  private $endT;
  private $createdBy;
  private $description;
  private $icon;
  
 
   // El constructor
 
  public function __construct($tourId=NULL,$name=NULL, $tourType=NULL, $places=NULL, $playersNumb=NULL,$iniT=NULL,$endT=NULL,$createdBy=NULL,$description=NULL,$icon=NULL) {
    $this->tourId = $tourId;
    $this->name = $name;
    $this->tourType = $tourType;
    $this->places = $places; 
    $this->playersNumb = $playersNumb; 
	  $this->iniT = $iniT;    
	  $this->endT = $endT;
    $this->createdBy = $createdBy;
    $this->description = $description;
    $this->icon = $icon;      
  }
  
  // tourId
  public function getTourId() {
    return $this->tourId;
  }

  // name
  public function getName() {
    return $this->name;
  }
  
  public function setName($name) {
    $this->name = $name;
  }
  
  // tourType
  public function getTourType() {
    return $this->tourType;
  }  
   
  public function setTourType($tourType) {
    $this->tourType = $tourType;
  }
  
  // places
  public function getPlaces() {
    return $this->places;
  }
 
  public function setPlaces($places) {
    $this->places = $places;
  }

  // playersNumb
  public function getPlayersNumb() {
    return $this->playersNumb;
  }
 
  public function setPlayersNumb($playersNumb) {
    $this->playersNumb = $playersNumb;
  }

  // iniT
  public function getIniT() {
    return $this->iniT;
  }
  public function setIniT($iniT) {
    $this->iniT = $iniT;
  }

  // endT
  public function getEndT() {
    return $this->endT;
  }
 
  public function setEndT($endT) {
    $this->endT = $endT;
  }

  // createdBy
  public function getCreatedBy() {
    return $this->createdBy;
  }
 
  public function setCreatedBy($createdBy) {
    $this->createdBy = $createdBy;
  }

  // description
  public function getDescription() {
    return $this->description;
  }
 
  public function serDescription($description) {
    $this->description = $description;
  }
   
  // icon
  public function getIcon() {
    return $this->icon;
  }
 
  public function setIcon($icon) {
    $this->icon = $icon;
  }
  
  //Llama al mapper para guardar un torneo. 
  public static function saveTour($tour){  
    return TourMapper::saveTour($tour);
  }

  //Llama al mapper para obtener los torneos creados por un usuario.
  public static function toursById($userId){
    return $list = TourMapper::toursById($userId);
  }

  //Llama al mapper para obtener una lista de todos los torneos.
  public static function getTours(){
    return $list = TourMapper::getTours();
  }

  //Llama al mapper para obtener un lista de todos los equipos de un torneo.
  public static function getTourTeams($idTour){
    return $teams = TourMapper::getTourTeams($idTour);
  }

  //Llama al mapper para obtener los datos de un torneo especifico.
  public static function getDataById($idTour) {
    return TourMapper::findTourById($idTour);   
  }

  //Llama al mapper para obtener los datos de un equipo de un capitan en un torneo.
  public static function getTourTeamByUser($userId,$idTour) {
    return TourMapper::getTourTeamByUser($userId,$idTour);   
  }

  //Llama al mapper para actualizar la descripcion de un torneo.
  public static function updateDes($description,$idTour) {
    return TourMapper::updateDes($description,$idTour);
  }

  //Llama al mapper para actualizar el icono de un torneo.
  public static function updateIcon($idTour,$icon) {
    return TourMapper::updateIcon($idTour,$icon);
  }

  //Llama al mapper para obtener el numero de plazas ocupadas en un torneo.
  public static function getPlacesLeft($idTour) {
    return TourMapper::getPlacesLeft($idTour);  
  }

  //Llama al mapper para obtener el numero de jugadores maximo para un torneo especifico.
  public static function getPlayers($idTour) {
    return  TourMapper::getPlayers($idTour);
  }

  //Llama al mapper para obtener la info de los partidos de un equipo en un torneo.
  public static function getTeamMatchs($idTeam,$idTour) {
    return  TourMapper::getTeamMatchs($idTeam,$idTour);
  }

  //Llama al mapper para obtener la info de los partidos de un torneo.
  public static function getAllMatchs($idTour) {
    return  TourMapper::getAllMatchs($idTour);
  }

  //Llama al mapper para obtener una lista de jugadores.
  public function TourTeamsList($idTour){
    return $teams = TourMapper::TourTeamsList($idTour);
  }

  //Llama al mapper para crear un grupo. 
  public static function createGroup($tourId,$teamId,$groupId){  
    return TourMapper::createGroup($tourId,$teamId,$groupId);
  }

  //Llama al mapper para obtener un lista de todos los equipos de un grupo de un torneo dado.
  public static function getGroupTeams($idTour,$grp){
    return $teams = TourMapper::getGroupTeams($idTour,$grp);
  }

  //Llama al mapper para comprobar si existe ya existe un equipo de ese capitan.
  public static function alreadyATeam($idTour,$idUser){  
    return TourMapper::alreadyATeam($idTour,$idUser);
  }
  
}