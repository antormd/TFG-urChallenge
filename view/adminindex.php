<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $user = UserController::getUserData($userId);

 if ($_SESSION['userType'] =='1'){
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
    <link href="../css/adminindex.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    

  </head>
  <body style="background-color: #e9ebee">
  
 <div class="topnav" id="myTopnav">
  <a href="adminindex.php" class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;"><img style="width: 75px;height: 60px" src="../images/escudo1.png" "></a>
  <a href='adminindex.php'>Home</a>
  <a href="urtours.php"><img style="width: 30px;height: 30px;margin-right: 8px" id="fut" src="../images/trophy2.png">Mis Torneos</a>
  <?php
    if (NotificationController::hasNotis($userId)) {
  ?>
      <a href="notifies.php"><img style="width: 30px;height: 30px;margin-right: 8px" src="../images/notify.png"><img style="width: 30px;height: 30px;margin-right: 8px" src="../images/new.png">Notificaciones</a>
  <?php
    }else{
  ?>
      <a href="notifies.php"><img style="width: 30px;height: 30px;margin-right: 8px" src="../images/notify.png">Notificaciones</a>
  <?php
}
  ?>
  <a id="a1" style="float: right;"  href='logout.php'>Cerrar Sesión</a>
  <a id="a2" style="float: right;" href="urperfil.php">Perfil</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
 </div>

<!-- Div principal
-->


<div  style="margin-top: 80px;">
  <div id="izq">
    <div id="perfil">
    <img id="avatar" src="../images/<?php echo $user->getImage(); ?>">
    <h4 style="margin-top: 170px;margin-left: 10px"><?php echo $user->getName(); ?></h4>
    <h5 style="margin-top: 10px;margin-left: 10px">@<?php echo $user->getLogin(); ?></h5>
    </div>
 
    <div id="perfil1">
    <h3 style="text-align: center;text-decoration: underline;">
      Mis Torneos
    </h3>

    </div>
  </div>

  <div id="med">
    <div id="main">
    <div style="width: 800px">
    <img  data-toggle="modal" data-target="#miModal" id="torneoindex" src="../images/crearTorneo.png">
    </div>
    </div>
  </div>

  <div id="der" >
   <iframe id="calen"  style="float: right;height: 350px;width: 450px;margin-right: 50px;border: 2px solid #000000;" src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=es.spain%23holiday%40group.v.calendar.google.com&amp;color=%23125A12&amp;ctz=Europe%2FMadrid" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
   </div>

</div>
   <!-- MODAL PARA Tenis
   -->
<form action="../controller/defaultcontroller.php?controlador=tour&accion=createTour" method='POST'> 
  <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 style="text-align: center;" class="modal-title" id="myModalLabel">Crea tu torneo</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="type" value="1">
        <div>
        <label style="margin-left:10px"><b>Nombre del torneo</b></label>
        <input style="margin-left:40px;"  minlength="4" maxlength="20" placeholder="Introduzca nombre" name="name" required>
        </div>
        <div>
        <label style="margin-left:10px"><b>Plazas</b></label>
        <input style="margin-left:121px;"  type="number" placeholder="Introduzca nº de plazas" name="plazas" required>
        </div>
        <div>
        <label style="margin-left:10px"><b>Nº máximo de jugadores</b></label>
        <input style="margin-left:1px;"  type="number" placeholder="Introduzca nº de jugadores" name="jugadores" required>
        </div>
        <div>
        <label style="margin-left:10px"><b>Fecha Inicio</b></label>
        <input style="margin-left:83px;"  type="date" placeholder="Fecha inicio" name="iniT" required>
        </div>
        <div>
        <label style="margin-left:10px"><b>Fecha Fin</b></label>
        <input style="margin-left:99px;"  type="date" placeholder="Fecha fin" name="endT" required>
        </div>
        <div>
        <label style="margin-left:10px"><b>Tipo de torneo</b></label>
        <select name="tipe" style="margin-left: 67px">
        <option value="0">Liga: solo ida</option>
        <option value="1">Liga: ida y vuelta</option>
        <option value="2">Fase final: solo ida</option>
        <option value="3">Fase final: ida y vuelta</option>
        <option value="4">Grupos y Fase final: solo ida</option>
        </select>
        </div>
        <button class="btn block info btn-lg">Crear</button>
        <button name="1" class="btn block info btn-lg" style="  color: #900;font-weight: bold;" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
  </div>
  </form>


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