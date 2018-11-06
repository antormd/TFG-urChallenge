<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $idPlayer=$_GET['id'];
 $row = TeamController::getPlayerTeams($idPlayer);


 if ($_SESSION['userType'] =='2' or $_SESSION['userType'] =='3' or $_SESSION['userType'] =='1'){
?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <script type="text/javascript" src="../js/modernizr.custom.86080.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <title>urChallenge</title>

 
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/scoutplayer.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    

  </head>
  <body style="background-color: #e9ebee">


  <div id="izq">
  <center>

  <div id="escudo">
  <div id="nombret">
          <?php
          $player = TeamController::getPlayer($idPlayer);
          ?>
  <h2 style="text-align: center;color: white;margin-top: 0px"><?php  echo $player->getName(); ?></h2>  
  </div>
  <center>
     <img id="avatar" src="../images/<?php echo $player->getImage(); ?>">
  </center>  
  </div>

  <div id="escudo1">
  <div id="nombret">
  <h2 style="text-align: center;color: white;margin-top: 0px">Información general</h2>  
  </div>
  <center>
    <p style="margin-top: 10px"><b> Nombre </b> : <?php  echo $player->getName(); ?></p>
    <p><b> Email</b> : <?php  echo $player->getEmail(); ?></p>
    <p><b> Equipo más activo:</b> </p>
   <a href="teamresults.php">Ver +</a>
  </center> 
  <center>
    <?php
    if ($_SESSION['userType'] =='2'){
    ?>
    <button  class="btn block info btn-lg" onClick=" window.location.href='captainindex.php'" style="  color: #900;font-weight: bold;">Volver</button>
    <?php
    }else{
    ?>
    <button  class="btn block info btn-lg" onClick=" window.location.href='playerindex.php'" style="  color: #900;font-weight: bold;">Volver</button>
    <?php
    }
    ?>
  </center> 
  </div>
  </center>


  </div>


  <div id="der">
  <center>
  <div id="jugadores">
  <div id="jugt">
  <h2 style="text-align: center;color: white;margin-top: 0px">Equipos</h2>  
  </div>
      <?php
          if($row!=null){ 
          foreach ($row as $teams) {
            ?>
      <?php
          $team = TeamController::getTeam($teams['idTeam']);
          ?>
          <div id="pl">
          <a href="scouteam.php?id=<?php echo $team->getTeamId() ?>">
          <center>
          <img id="avatar1" src="../images/<?php echo $team->getShield(); ?>">
          </center>
          </a>
          <h4 style="text-align: center;margin-bottom: 15px"><?php echo $team->getName(); ?></h4>
          </div>
          <?php
        }}
        
        ?>
  </div>
  </center>
  </div>
  
  </body>
  </html>
    <?php
  }else{
        ob_start(); 
             
              header("Location: ../view/loginredirect.php");
             
          }
          
        ob_end_flush();  

?>