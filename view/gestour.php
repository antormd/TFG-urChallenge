<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $idTour = $_GET['id'];
 $row = TourController::getTourTeams($idTour);


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
    <link href="../css/gestours.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    

  </head>
  <body style="background-color: #e9ebee">
  
 <div class="topnav" id="myTopnav">
  <a href="adminindex.php" class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;"><img style="width: 75px;height: 60px" src="../images/escudo1.png" "></a>
  <a href='adminindex.php'>Home</a>
  <a id="a1" style="float: right;" href='logout.php'>Cerrar Sesión</a>
  <a id="a2" style="float: right;" href='urperfil.php'>Perfil</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
 </div>

  <div id="izq">
  <div id="escudo">
  <div id="nombret">
          <?php
          $tour = TourController::getTour($idTour);
          ?>
  <h2 style="text-align: center;color: white;margin-top: 0px"><?php  echo $tour->getName(); ?></h2>  
  </div>
  <center>
      <img id="avatar" src="../images/<?php echo $tour->getIcon(); ?>">
  </center>  
  </div>
  <div id="escudo1">
  <div id="nombret">
  <h2 style="text-align: center;color: white;margin-top: 0px">Información general</h2>  
  </div>
  <center>
    <p style="margin-top: 10px"><b> Nombre </b> : <?php  echo $tour->getName(); ?></p>
    <?php 
    $result = TourController::getPlacesLeft($idTour);
    $plazas = $result->fetch_row();
    ?>
    <p><b> Plazas libres</b> : <?php  echo ($tour->getPlaces()) - $plazas[0]; ?></p>
    <p><b> Tipo de torneo </b> : <?php
      if ($tour->getTourType() == "0") {
        echo "Liga: solo ida";
      }elseif ($tour->getTourType() == "1") {
        echo "Liga: ida y vuelta";
      }elseif ($tour->getTourType() == "2") {
        echo "Fase final: solo ida";
      }elseif ($tour->getTourType() == "3") {
        echo "Fase final: ida y vuelta";
      }elseif ($tour->getTourType() == "4") {
        echo "Grupos y Fase final: solo ida";
      }
      else
        echo "Grupos y Fase final: ida y vuelta"; ?></p>
    <p ><b> Crear descripción: <button style="color: black" data-toggle="modal" data-target="#miModal">+</button> </b> </p>
  </center>
  <form action="../controller/defaultcontroller.php?controlador=tour&accion=updateIcon" method='POST' enctype="multipart/form-data"> 
  <div style="margin-left:15px;">
              <input type="hidden" name="idTour" value="<?php echo $idTour ?>">
              <label for="imgTour">Remplazar icono del torneo: </label>
              <input type="file"  name="icono" required="">
              <button class="btn block info btn-sg">Listo</button>
  </div>
  </form>
  <div style="margin-left: 15px;margin-top: 15px ">
        <p><b>Importante:</b> </p>
          <p style="color: red">
          Crea una descripción para tu torneo. En ella debes especificar todos los datos imprescindibles para los equipos que quieran inscribirse en tu torneo: ya sea lugar de disputa, premios, número máximo de jugadores por equipo...(esto último es imprescindible ya que si un equipo sobrepasa el límite de jugadores no podrá inscribirse en la web).
          </p>
  </div> 
  </div>


  </div>
 <?php
  if (!TourController::existMatch($idTour)) {
  ?>
  <?php
  if ($tour->getTourType() == "4") {
  ?>
  <center>
  <button style="margin-top: 20px" data-toggle="modal" data-target="#miModal1">Iniciar Emparejamientos</button>
  </center>
  <?php
  }else{
  ?>
  <center>
  <div>
    <form action="../controller/defaultcontroller.php?controlador=tour&accion=iniTour" method='POST'> 
    <input type="hidden" name="idTour" value="<?php echo $idTour ?>">
    <button style="margin-top: 20px">Iniciar Emparejamientos</button>
    </form>
  </div>
  </center>
  </div>
  <?php
  }
  }else{
  ?>
  <center>
  <button onClick=" window.location.href='tourinfo.php?id=<?php echo $idTour ?>'" style="margin-top: 20px" class="w3-button w3-teal">Resultados torneo</button>
  </center>
  <?php
  }
  ?>


  <div id="der">
  <div id="lequipos">
  <div id="equip">
  <h2 style="text-align: center;color: white;margin-top: 0px">Equipos participantes</h2>
  </div>
      <?php
          if($row!=null){ 
          foreach ($row as $teams) {
            ?>
          <?php
          $team = TeamController::getTeam($teams['idTeam']);
          ?>
          <div style="width: 25%;float: left;">
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
 
  <div id="lequipos">
  <div id="equip">
  <h2 style="text-align: center;color: white;margin-top: 0px">Descripción</h2>
  </div>
  <pre>
      <?php echo $tour->getDescription();?>
  </pre>
  </div>
  

  <form action="../controller/defaultcontroller.php?controlador=tour&accion=updateDes" method='POST'> 
  <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 style="text-align: center;" class="modal-title" id="myModalLabel">Crea la descripción de tu torneo</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idTour" value="<?php echo $idTour ?>">
        <label style="margin-left:10px"><b>Descripción del torneo:</b></label>
        <div>
        <textarea style="margin-left: 10px" name="descripcion" rows="10" cols="60"></textarea>
        </div>
        </div>
        <center>
        <button class="btn block info btn-lg">Crear</button>
        <button name="1" class="btn block info btn-lg" style="  color: #900;font-weight: bold;" data-dismiss="modal">Cancelar</button>
        </center>
      </div>
    </div>
  </div>
  </div>
  </form>

  <form action="../controller/defaultcontroller.php?controlador=tour&accion=iniTour" method='POST'> 
  <div class="modal fade" id="miModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 style="text-align: center;" class="modal-title" id="myModalLabel">¿Cuantos grupos quieres en tu torneo?</h4>
      </div>
      <div class="modal-body">
        <div>
        <label style="margin-left:10px"><b>Numero de grupos</b></label>
        <input style="margin-left:121px;"  type="number" placeholder="Introduzca nº grupos" name="ngroups" required>
        </div>
        <center>
        <input type="hidden" name="idTour" value="<?php echo $idTour ?>">
        <button class="btn block info btn-lg">Iniciar</button>
        <button name="1" class="btn block info btn-lg" style="  color: #900;font-weight: bold;" data-dismiss="modal">Cancelar</button>
        </center>
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