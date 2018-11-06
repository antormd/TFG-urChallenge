<!--
======================================================================
Modelo de la tabla Matchup
======================================================================
-->

<?php
// file: model/Matchup.php
/**
 * Class Matchup
 * 
 * Representa un partido en la web
 * 
 */
class Matchup {
 
  private $matchupId;
  private $matchtype;
  private $scorelocal;
  private $scorevisitor;
  private $teamvisitor;
  private $teamlocal;
  private $tourId;
  private $matchdate;

  
 
   // El constructor
 
  public function __construct($matchupId=NULL,$matchtype=NULL, $scorelocal=NULL, $scorevisitor=NULL, $teamvisitor=NULL,$teamlocal=NULL,$tourId=NULL,$matchdate=NULL) {
    $this->matchupId = $matchupId;
    $this->matchtype = $matchtype;
    $this->scorelocal = $scorelocal;
    $this->scorevisitor = $scorevisitor; 
    $this->teamvisitor = $teamvisitor; 
	  $this->teamlocal = $teamlocal;    
	  $this->tourId = $tourId;
    $this->matchdate = $matchdate;
  }
  
  // matchupId
  public function getMatchupId() {
    return $this->matchupId;
  }

  // matchtype
  public function getMatchType() {
    return $this->matchtype;
  }
  
  public function setMatchType($matchtype) {
    $this->matchtype = $matchtype;
  }
  
  // scorelocal
  public function getScoreLocal() {
    return $this->scorelocal;
  }  
   
  public function setScoreLocal($scorelocal) {
    $this->scorelocal = $scorelocal;
  }
  
  // scorevisitor
  public function getScoreVisitor() {
    return $this->scorevisitor;
  }
 
  public function setScoreVisitor($scorevisitor) {
    $this->scorevisitor = $scorevisitor;
  }

  // teamvisitor
  public function getTeamVisitor() {
    return $this->teamvisitor;
  }
 
  public function setTeamVisitor($teamvisitor) {
    $this->teamvisitor = $teamvisitor;
  }

  // teamlocal
  public function getTeamLocal() {
    return $this->teamlocal;
  }
  public function setTeamLocal($teamlocal) {
    $this->teamlocal = $teamlocal;
  }

  // tourId
  public function getTourId() {
    return $this->tourId;
  }
 
  public function setTourId($tourId) {
    $this->tourId = $tourId;
  }

  // matchdate
  public function getMatchdate() {
    return $this->matchdate;
  }
 
  public function setMatchdate($matchdate) {
    $this->matchdate = $matchdate;
  }

  //Llama al mapper para guardar partido.
  public static function saveMatchup($matchup){  
    return MatchupMapper::saveMatchup($matchup);
  }
}