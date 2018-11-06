<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $idTour = $_GET['id'];
 $row = TeamController::getTeamsById($userId);
 $teamId = TourController::getTourTeamByUser($userId,$idTour);
 $allmatchs = TourController::getAllMatchs($idTour);

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
    <link href="../css/mygames.css" rel="stylesheet">
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

  <center>
  <div style="width: 100%;height: 100%">
    <div>
     <h3> Todos los partidos </h3> 
    </div>
  </center>
      <center>
      <div id="contenedor">
      <?php
              for ($i=0; $i < count($allmatchs); $i++) {
              $teamlocal = TeamController::getTeam($allmatchs[$i]['teamlocal']);
              $teamvisitor = TeamController::getTeam($allmatchs[$i]['teamvisitor']);
      ?>

        <div style="width: 30%;float: left;clear: left;">
        <img style="height: 40px;width: 50px;margin-top:25px" src="../images/<?php echo $teamlocal->getShield(); ?>">
        </div>
        <div style="width: 35%;float: left;margin-top: 35px">
        <?php 
        echo $teamlocal->getName();
        echo " ";

        if ($allmatchs[$i]['scorelocal']==NULL) {
          echo "/";
          echo " - ";
          echo "/";
        }else{
          echo $allmatchs[$i]['scorelocal'];
          echo " - ";
          echo $allmatchs[$i]['scorevisitor'];
        }

        echo " ";
        echo $teamvisitor->getName(); 
        ?>
        </div>
        <div style="width: 30%;float: left;">
         <img style="height: 50px;width: 50px;margin-top:25px" src="../images/<?php echo $teamvisitor->getShield(); ?>">
        </div>
      <?php
          }
      ?>
    </div>
    </center>





  <form action="../controller/defaultcontroller.php?controlador=notification&accion=createNoti" method='POST'> 
  <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 style="text-align: center;" class="modal-title" id="myModalLabel">Envía de forma clara el resultado del partido al administador del torneo</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idTour" value="<?php echo $idTour ?>">
        <input type="hidden" name="userId" value="<?php echo $userId ?>">
        <label style="margin-left:10px"><b>Resultado:</b></label>
        <div>
        <textarea style="margin-left: 10px" name="descripcion" rows="2" cols="60" required></textarea>
        </div>
        </div>
        <center>
        <button class="btn block info btn-lg">Enviar</button>
        <button name="1" class="btn block info btn-lg" style="  color: #900;font-weight: bold;" data-dismiss="modal">Cancelar</button>
        </center>
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