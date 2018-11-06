<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $row = InviteController::getInvitesById($userId);

 if ($_SESSION['userType'] =='3'){
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
    <link href="../css/notify.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    

  </head>
  <body style="background-color: #e9ebee">

  <h2 style="margin-left: 10px">Invitaciones recibidas</h2>

  <div style="width: 100%;height: 100%;margin-top:50px;margin-left: 30px">
    
    <?php
        if($row!=null){ 
            foreach ($row as $invite) {

      ?>
        <form id="form1" action="../controller/defaultcontroller.php?controlador=invite&accion=aceptInv" method='POST' enctype="multipart/form-data">
        <div style="margin-bottom: 20px">
          <?php
          $team=TeamMapper::findByIdTeam($invite['idTeam']);
          $idTeam=$invite['idTeam'];
          ?>
        Te ha invitado el equipo:  <img style="height: 80px;width: 80px;margin-right: 10px" src="../images/<?php echo $team->getShield(); ?>"> <a href="scouteam.php?id=<?php echo $team->getTeamId() ?>"><?php echo $team->getName(); ?></a>
        <button  style="margin-left: 10px" type="submit" class="btn btn-success">Aceptar</button>
        <input type="hidden" name="idTeam" value="<?php echo $idTeam?>">
        </form>
        <form id="form2" action="../controller/defaultcontroller.php?controlador=invite&accion=denyInv" method='POST' enctype="multipart/form-data">
        <button   type="submit" class="btn btn-danger"><input type="hidden" name="status" value="2">Rechazar</button>
        <input type="hidden" name="idTeam" value="<?php echo $idTeam?>">
        </form>
        </div>

    <?php
    }
    }else{
    ?>
        <h2>No tienes invitaciones pendientes</h2>
    <?php
    }
    ?>
  <button  class="btn block info btn-lg" onClick=" window.location.href='playerindex.php'" style="  color: #900;font-weight: bold;">Volver</button>

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