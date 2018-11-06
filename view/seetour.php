<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $idTour = $_GET['id'];
 $row = TourController::getTourTeams($idTour);
 $tour = TourController::getTour($idTour);
 $teamId = TourController::getTourTeamByUser($userId,$idTour);
 $allmatchs = TourController::getAllMatchs($idTour);

  foreach ($teamId as $t) {
      $team = TeamController::getTeam($t['idTeam']);
      $row1 = TourController::getTeamMatchs($t['idTeam'],$idTour);
  }

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
    <script type="text/javascript" src="jquery-latest.js"></script>
    <script type="text/javascript" src="jquery.tablesorter.js"></script>
    <!-- Resources -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/pie.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <title>urChallenge</title>

 
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/tourinf.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">


  </head>
  <body style="background-color: #e9ebee">
  
 <div class="topnav" id="myTopnav">
  <a href="captainindex.php" class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;"><img style="width: 75px;height: 60px" src="../images/escudo1.png" "></a>
  <a href='captainindex.php'>Home</a>
  <a id="a1" style="float: right;" href='logout.php'>Cerrar Sesión</a>
  <a id="a2" style="float: right;" href='urperfil.php'>Perfil</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
 </div>

<div id="contenedorizq">
  <center>
  <div id="torneo">
    <h3 style="color: white;padding-top: 10px"><img style="height: 50px;width: 50px;margin-right: 10px" src="../images/<?php echo $tour->getIcon(); ?>"><?php echo $tour->getName(); ?></h3>
  </div>

  <div id="tuspartidos">
    <a href="mygames.php?id=<?php echo $idTour ?>">
    <div style="height: 40px;background-color: #333333;">
      <h3 style="color: white;padding-top: 5px;margin-top: 0px">Tus partidos: <img style="height: 30px;width: 30px;margin-right: 10px" src="../images/<?php echo $team->getSHield(); ?>"><?php echo $team->getName(); ?></h3>
    </div>
    </a>
    <div style="height: 90px;background-color: #e9ebee;">
      
      <?php
          $myteamgames = TourController::getTeamMatchs($team->getTeamId(),$idTour);

          for ($i=0; $i < 1; $i++) {
              $teamlocal = TeamController::getTeam($myteamgames[$i]['teamlocal']);
              $teamvisitor = TeamController::getTeam($myteamgames[$i]['teamvisitor']);
      ?>
      <center>
      <div>
        <div style="width: 30%;float: left;">
        <img style="height: 50px;width: 50px;margin-right: 10px;margin-top:25px" src="../images/<?php echo $teamlocal->getShield(); ?>">
        </div>
        <div style="width:40%;float: left;margin-top: 35px">
        <?php 
        echo $teamlocal->getName();
        echo " ";

        if ($myteamgames[$i]['scorelocal']==NULL) {
          echo "/";
          echo " - ";
          echo "/";
        }else{
          echo $myteamgames[$i]['scorelocal'];
          echo " - ";
          echo $myteamgames[$i]['scorevisitor'];
        }

        echo " ";
        echo $teamvisitor->getName(); 
        ?>
        </div>
        <div style="width: 30%;float: left;">
         <img style="height: 50px;width: 50px;margin-right: 10px;margin-top:25px" src="../images/<?php echo $teamvisitor->getShield(); ?>">
         </div>
      </div>
      </center>

      <?php
          }
      ?>
    </div>
  </div>

  <div id="partidos">
    <a href="allgames.php?id=<?php echo $idTour ?>">
    <div style="height: 40px;background-color: #333333;">
      <h3 style="color: white;padding-top: 5px;margin-top: 0px">Todos los partidos:</h3>
    </div>
    </a>
    <div style="height: 90px;background-color: #e9ebee;">
      <?php
          for ($i=0; $i < 4; $i++) {
              $teamlocal = TeamController::getTeam($allmatchs[$i]['teamlocal']);
              $teamvisitor = TeamController::getTeam($allmatchs[$i]['teamvisitor']);
          
      ?>
      <center>
      <div>
        <div style="width: 30%;float: left;">
        <img style="height: 50px;width: 50px;margin-right: 10px;margin-top:25px" src="../images/<?php echo $teamlocal->getShield(); ?>">
        </div>
        <div style="width: 40%;float: left;margin-top: 35px">
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
         <img style="height: 50px;width: 50px;margin-right: 10px;margin-top:25px" src="../images/<?php echo $teamvisitor->getShield(); ?>">
        </div>
      </div>
      </center>

      <?php
          }
      ?>
    </div>
  </div>
  </center>
</div>

<table id="myTable">
  <tr>
    <th onclick="sortTable(0)">Equipos</th>
    <th onclick="sortTable(1)">Ptos</th>
    <th onclick="sortTable(2)">PJ</th>
    <th onclick="sortTable(3)">PG</th>
    <th onclick="sortTable(4)">PE</th>
    <th onclick="sortTable(5)">PP</th>
    <th onclick="sortTable(6)">F</th>
    <th onclick="sortTable(7)">C</th>
    <th onclick="sortTable(8)">+/-</th>
  </tr>
  <?php

  if($row!=null){
    //Para cada equipo creo una fila con sus datos. 
    foreach ($row as $teams) { 
    $team = TeamController::getTeam($teams['idTeam']);
    //Obtengo los partidos jugados por cada equipo.
    $teammatchs = TourController::getTeamMatchs($teams['idTeam'],$idTour);
  ?>
  <tr>
    <!-- Nombre del equipo -->
    <td><img style="height: 50px;width: 50px;margin-right: 10px" src="../images/<?php echo $team->getShield(); ?>"><?php echo $team->getName(); ?></td>
    <!-- Puntos del equipo -->
    <td>
    <?php 
    $ptos = 0;
    foreach ($teammatchs as $matchs) {
      if($matchs['teamlocal'] == $teams['idTeam']){
        if ($matchs['scorelocal'] > $matchs['scorevisitor']) {
          $ptos += 3;
        }elseif ($matchs['scorelocal'] < $matchs['scorevisitor']) {
          $ptos += 0;
        }elseif($matchs['scorelocal'] = $matchs['scorevisitor']){
          $ptos += 1;
        }
      }else{
        if ($matchs['scorevisitor'] > $matchs['scorelocal']) {
          $ptos += 3;
        }elseif ($matchs['scorevisitor'] < $matchs['scorelocal']) {
          $ptos += 0;
        }elseif ($matchs['scorelocal'] = $matchs['scorevisitor']){
          $ptos += 1;
        }
      }
    } 
        echo $ptos;
    ?>
    </td>
    <!-- Partidos jugados del equipo -->
    <td>
    <?php 
    $pj = 0;
    foreach ($teammatchs as $matchs) {
      if($matchs['teamlocal'] == $teams['idTeam']){
        if ($matchs['scorelocal'] != NULL) {
          $pj++;
        }
      }else{
        if ($matchs['scorevisitor'] != NULL) {
          $pj++;
        }
      }
    } 
        echo $pj;
    ?>
    </td>
    <!-- Patidos ganados del equipo -->
    <td>
    <?php 
    $pg = 0;
    foreach ($teammatchs as $matchs) {
      if($matchs['teamlocal'] == $teams['idTeam']){
        if ($matchs['scorelocal'] > $matchs['scorevisitor']) {
          $pg++;
        }
      }else{
        if ($matchs['scorevisitor'] > $matchs['scorelocal']) {
          $pg++;
        }
      }
    } 
        echo $pg;
    ?>  
    </td>
    <!-- Patidos empatados del equipo -->    
    <td>
    <?php 
    $pe = 0;
    foreach ($teammatchs as $matchs) {
      if($matchs['teamlocal'] == $teams['idTeam']){
        if ($matchs['scorelocal'] != NULL) {
          if ($matchs['scorelocal'] == $matchs['scorevisitor']) {
            $pe++;
          }
        }
      }else{
        if ($matchs['scorelocal'] != NULL) {
          if ($matchs['scorevisitor'] == $matchs['scorelocal']) {
            $pe++;
          }
        }
    }
    } 
        echo $pe;
    ?>       
    </td>
    <!-- Partidos perdidos del equipo -->    
    <td>
    <?php 
    $pp = 0;
    foreach ($teammatchs as $matchs) {
      if($matchs['teamlocal'] == $teams['idTeam']){
        if ($matchs['scorelocal'] < $matchs['scorevisitor']) {
          $pp++;
        }
      }else{
        if ($matchs['scorevisitor'] < $matchs['scorelocal']) {
          $pp++;
        }
      }
    } 
        echo $pp;
    ?>        
    </td>
    <!-- Goles a favor del equipo -->    
    <td>
    <?php 
    $gf = 0;
    foreach ($teammatchs as $matchs) {
      if ($matchs['scorelocal'] != NULL) {
        if($matchs['teamlocal'] == $teams['idTeam']){
          $gf+=$matchs['scorelocal'];
        }else{
         $gf+=$matchs['scorevisitor'];
        }
            }
    } 
        echo $gf;
    ?>        
    </td>
    <!-- Goles en contra del equipo -->    
    <td>
    <?php 
    $gc = 0;
    foreach ($teammatchs as $matchs) {
      if ($matchs['scorelocal'] != NULL) {
        if($matchs['teamlocal'] == $teams['idTeam']){
          $gc+=$matchs['scorevisitor'];
        }else{
         $gc+=$matchs['scorelocal'];
        }
            }
    } 
        echo $gc;
    ?>           
    </td>
    <!-- Goles totales del equipo -->    
    <td>
    <?php
    echo $gf-$gc;
    ?>
    </td>
  </tr>

  <?php
  }}
  ?>

</table>


 </body>

  <!-- Script para ordenar la tabla por columnas
  -->
  <script>
  function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++; 
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
  }
  </script>







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