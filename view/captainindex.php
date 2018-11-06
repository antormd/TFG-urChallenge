<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $user = UserController::getUserData($userId);

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
    <link href="../css/captaind.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    

  </head>
  <body style="background-color: #e9ebee">
  
 <div class="topnav" id="myTopnav">
  <a href="captainindex.php" class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;"><img style="width: 75px;height: 60px" src="../images/escudo1.png" "></a>
  <a href='captainindex.php'>Home</a>
  <!--<a href="notifies.php"><img style="width: 30px;height: 30px;margin-right: 8px" src="../images/notify.png">Notificaciones</a>-->
  <a id="a1" style="float: right;" href='logout.php'>Cerrar Sesión</a>
  <a id="a2" style="float: right;" href='urperfil.php'>Perfil</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
 </div>

<!-- Div principal
-->

<div id="center">
    <!-- Div Crear Equipo -->
    <a href='newteam.php'>
    <div id="ai">
    </div>
    </a>
    <!-- Div Gestionar Equipo -->
    <a href='urteam.php'>
    <div id="ad">
    </div>
    </a>
    <!-- Div Buscar Torneo -->
    <a href='whattour.php'>
    <div id="bi">
    </div>
    </a>
    <!-- Div Mis Torneos -->
    <a href='mytours.php'>
    <div id="bd">
    </div>
    </a>
  
</div>




<div  style="margin-top: 80px;">

<div id="right" style="">
    <a href='urperfil.php'>
    <img style="margin-left: 50px" id="avatar1" src="../images/<?php echo $user->getImage(); ?>">
    </a>
    <div id="perfil">
    <h4 style="margin-top: 160px;"><?php echo $user->getName(); ?></h4>
    <h5 style="margin-top: 5px;">@<?php echo $user->getLogin(); ?></h5>
    </div>
 
    <div id="perfil1" style="margin-bottom: 30px">
    <h3 style="text-align: center;text-decoration: underline;">
      Resultados
    </h3>

    </div>
</div>





</div>
 
  </body>
  <!-- Script para desplegar Nav
  -->
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