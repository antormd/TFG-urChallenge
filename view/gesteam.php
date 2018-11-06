<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $idTeam = $_GET['id'];
 $team = TeamController::getTeam($idTeam);
 $row = UserController::getAllPlayers();
 //$row1 = TeamController::getTeamPlayers();
 $relation = TeamController::captainTeam($idTeam);
 $row1 = TeamController::getTeamPlayers($idTeam);


 if ($_SESSION['userType'] =='2'){
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
    <link href="../css/gteam.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    

  </head>
  <body style="background-color: #e9ebee">

  <div class="topnav" id="myTopnav">
  <a href="captainindex.php" class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;"><img style="width: 75px;height: 60px" src="../images/escudo1.png" "></a>
  <a href='captainindex.php'>Home</a>
  <a id="a1" style="float: right;"  href='logout.php'>Cerrar Sesión</a>
  <a id="a2" style="float: right;" href='urperfil.php'>Perfil</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
  </div>
  
  <div id="container" style="width: 100%;height: 100%">

    <div id="left">
      <div id="escudo" style="background-image: url(../images/<?php echo $team->getShield()?>);">
      </div>
      <h3 style="text-align: center;"> <?php echo $team->getName()?> </h3>
      <div id="normas">
      <h3 style="text-align: center;color: red">
      Importante:
      </h3>
      <h4 style="margin-left: 10px;margin-right: 10px">
      En esta sección puedes invitar a jugadores a tu equipo. Pero ten en cuenta que cada torneo tiene una serie de normas respecto al nº de jugadores por equipo permitidos. Si quieres consultar estas normas, accede al torneo que estes interesado en participar y lee su descripción.
      </h4>  
      </div>
    </div>

    <?php  

      if ($team->getTeamType()=="0") {
  
 ?>
    <center>
    <div id="right1">
      <h3>Busca a un jugador para invitar</h3>
      <form name="form" action="search.php" method="get">
      <input type="text" name="search" />
      <input type="hidden" name="idTeam" value="<?php echo $idTeam?>">
      <input type="submit" name = 'submit' value="Buscar" title="Buscar" />
      </form>
    </div>
    </center>

    <div id="right">
      <div id="campo" style="position: relative; margin-left: 50px" >
          <?php
          if($row1!=null){ 
            foreach ($row1 as $players) {
          ?>
          <div id="jugs">
          <?php
          $player = TeamController::getPlayer($players['idPlayer']);
          ?>
          <a href="scoutplayer.php?id=<?php echo $players['idPlayer'] ?>">
          <center>
          <img id="avatar" src="../images/<?php echo $player->getImage(); ?>">
          </center>
          </a>
          <h4 style="text-align: center;"><?php echo $player->getName(); ?></h4>
          <h5 style="text-align: center;">@<?php echo $player->getLogin(); ?></h5>
          </div>
          <?php 
          }
          }
          ?>
      </div>
      <button id="buttonel"  class="btn block info btn-lg" data-toggle="modal" data-target="#miModal">Eliminar equipo</button>
    </div>

    <?php  

  }elseif ($team->getTeamType()=="1") {

  
 ?>
    <center>
    <div id="right1">
      <h3>Busca a un jugador para invitar</h3>
      <form name="form" action="search.php" method="get">
      <input type="text" name="search" />
      <input type="hidden" name="idTeam" value="<?php echo $idTeam?>">
      <input type="submit" name = 'submit' value="Buscar" title="Buscar" />
      </form>
    </div>
    </center>

    <div id="right">
      <div id="campo1" style="position: relative; margin-left: 50px" >
          <?php
          if($row1!=null){ 
            foreach ($row1 as $players) {
          ?>
          <div id="jugs">
          <?php
          $player = TeamController::getPlayer($players['idPlayer']);
          ?>
          <a href="scoutplayer.php?id=<?php echo $players['idPlayer'] ?>">
          <center>
          <img id="avatar" src="../images/<?php echo $player->getImage(); ?>">
          </center>
          </a>
          <h4 style="text-align: center;"><?php echo $player->getName(); ?></h4>
          <h5 style="text-align: center;">@<?php echo $player->getLogin(); ?></h5>
          </div>
          <?php 
          }
          }
          ?>
      </div>
      <button id="buttonel"  class="btn block info btn-lg" data-toggle="modal" data-target="#miModal">Eliminar equipo</button>
    </div>

    <?php 
}else{

     ?>

    <center>
    <div id="right1">
      <h3>Busca a un jugador para invitar</h3>
      <form name="form" action="search.php" method="get">
      <input type="text" name="search" />
      <input type="hidden" name="idTeam" value="<?php echo $idTeam?>">
      <input type="submit" name = 'submit' value="Buscar" title="Buscar" />
      </form>
    </div>
    </center>

    <div id="right">
      <div id="campo2" style="position: relative; margin-left: 50px" >
          <?php
          if($row1!=null){ 
            foreach ($row1 as $players) {
          ?>
          <div id="jugs">
          <?php
          $player = TeamController::getPlayer($players['idPlayer']);
          ?>
          <a href="scoutplayer.php?id=<?php echo $players['idPlayer'] ?>">
          <center>
          <img id="avatar" src="../images/<?php echo $player->getImage(); ?>">
          </center>
          </a>
          <h4 style="text-align: center;color: white"><?php echo $player->getName(); ?></h4>
          <h5 style="text-align: center;color: white">@<?php echo $player->getLogin(); ?></h5>
          </div>
          <?php 
          }
          }
          ?>
      </div>
      <button id="buttonel" class="btn block info btn-lg" data-toggle="modal" data-target="#miModal">Eliminar equipo</button>
    </div>
  
    <?php 
}

     ?>


  </div>

   <!-- MODAL PARA ELIMINAR EQUIPO 
   -->
  <form action="../controller/defaultcontroller.php?controlador=team&accion=deleteTeam" method='POST'> 
  <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">¿Seguro que deseas eliminar este equipo?</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idTeam" value="<?php echo $idTeam ?>">
        <button class="btn block info btn-lg">Si</button>
        <button name="1" class="btn block info btn-lg" style="  color: #900;font-weight: bold;" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
  </div>
  </form>




  </body>
  <script>
  function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
  }
  </script>
  </html>
    <?php
  }else{
        ob_start(); 
             
              header("Location: ../view/loginredirect.php");
             
          }
          
        ob_end_flush();  

?>