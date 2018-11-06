<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $idTour = $_GET['id'];
 $tour = TourController::getTour($idTour);
 $row1 = NotificationController::getTourNotis($idTour);
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
    <script type="text/javascript" src="jquery-latest.js"></script>
    <script type="text/javascript" src="jquery.tablesorter.js"></script>

    <title>urChallenge</title>

 
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/tourinf.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    <style>
    table {
        border-spacing: 0;
        width: 100%;
        border: 1px solid black;
        float: left;
    }

    th {
        cursor: pointer;
    }

    th, td {
        text-align: left;
        padding: 16px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2
    }
    </style>

  </head>
  <body style="background-color: #e9ebee">
  
 <div class="topnav" id="myTopnav">
  <a href="adminindex.php" class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;"><img style="width: 75px;height: 60px" src="../images/escudo1.png" "></a>
  <a href='adminindex.php'>Home</a>
  <a id="a1" style="float: right;" href='logout.php'>Cerrar Sesión</a>
  <a id="a2" style="float: right;" href='urperfil.php'>Perfil</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
 </div>

<div style="width: 60%;float: left;">
  


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
    //Obtengo los partidos jugador por cada equipo.
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
</div>

<div style="width: 40%;float: left;">
  <h4 style="text-align: center;">Notificaciones</h4>
  <div>
    <center>
    <img  data-toggle="modal" data-target="#miModal" style="cursor: pointer;height: 250px;width: 250px;margin-bottom: 30px" src="../images/persona.png">
    </center>
  </div>
  <h4 style="text-align: center;">Resultados</h4>
  <div>
    <center>
    <img data-toggle="modal" data-target="#miModal1" style="cursor: pointer;height: 250px;width: 250px;margin-bottom: 30px" src="../images/partidos.png">
    </center>
  </div>

</div>


<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 style="text-align: center;" class="modal-title" id="myModalLabel">Tus notificaciones recientes:</h4>
      </div>
      <div class="modal-body">
        <center>
        <label style="margin-left:10px"><b>Torneo: <?php echo $tour->getName() ?></b></label>
        </center>
        <div>
          <?php
          foreach ($row1 as $noti) {
            $user = UserController::getUserData($noti['emisor']);
            ?>
            <form action="../controller/defaultcontroller.php?controlador=notification&accion=deleteNoti" method='POST'> 
            <input type="hidden" name="idTour" value="<?php echo $idTour?>">
            <input type="hidden" name="idNoti" value="<?php echo $noti['idNoti']?>">
            <p style="border-bottom: 1px solid black;margin-bottom: 30px"><?php echo $user->getName() ?> : <?php echo $noti['message']?><button class="w3-button w3-red" style="float: right;">Eliminar</button></p>
            </form>
          <?php
          }
          ?>
        </div>
      </div>
        <center>
        <button name="1" class="btn block info btn-lg" style="  color: #900;font-weight: bold;" data-dismiss="modal">Volver</button>
        </center>
    </div>
  </div>
</div>


<div class="modal fade" id="miModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 style="text-align: center;" class="modal-title" id="myModalLabel">Resultados del torneo:</h4>
      </div>
      <div class="modal-body">
        <center>
        <label style="margin-left:10px"><b>Torneo: <?php echo $tour->getName() ?></b></label>
        </center>
        <div>
        
        </div>
        </div>
        <center>
        <button name="1" class="btn block info btn-lg" style="  color: #900;font-weight: bold;" data-dismiss="modal">Volver</button>
        </center>
      </div>
    </div>
  </div>

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