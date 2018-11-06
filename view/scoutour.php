<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $idTour = $_GET['id'];
 $row = TourController::getTourTeams($idTour);
 $tour = TourController::getTour($idTour);
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
    <link href="../css/scoutour.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    <style>
    table {
        border-spacing: 0;
        width: 50%;
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

    #chartdiv {
      width: 100%;
      height: 270px;
    }           
    </style>

  </head>
  <body style="background-color: #e9ebee">
  
 <div class="topnav" id="myTopnav">
  <a href="captainindex.php" class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;"><img style="width: 75px;height: 60px" src="../images/escudo1.png" "></a>
  <a href='captainindex.php'>Home</a>
  <a id="a1" style="float: right;" href='logout.php'>Cerrar Sesión</a>
  <a id="a2" style="float: right;" href='urperfil.php'>Perfil</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
 </div>

  <?php
      if (!TourController::existMatch($idTour)) {
  ?>


 <div style="margin-top: 80PX">
  <div id="izq">
  <center>
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
  <center>
    <p style="margin-top: 10px"><b> Nombre </b> : <?php  echo $tour->getName(); ?></p>
    <?php 
    $result = TourController::getPlacesLeft($idTour);
    $plazas = $result->fetch_row();
    $creator = UserController::getCreatorName($tour->getCreatedBy()); 
    ?>
    <p><b> Plazas libres</b> : <?php  echo ($tour->getPlaces()) - $plazas[0]; ?></p>
    <p><b> Creado por</b> : <?php  echo $creator->getLogin(); ?></p>
  </center>
  </div>
  </center>
  <center>
  <div id="desc">
  <div id="equip">
  <h2 style="text-align: center;color: white;margin-top: 0px">Descripción</h2>
  </div>
  <pre style="text-align: left;">
      <?php echo $tour->getDescription();?>
  </pre>
  </div>
  </center>
  </div>


   <div id="der">
     <div class="container">
      <img src="../images/inscrib.png"  style="width:100%">
      <input type="hidden" name="idTour" value="<?php echo $idTour?>">
      <button data-toggle="modal" data-target="#miModal" class="btn">Inscríbete</button>
     </div>
     <div class="container" style="margin-top: 40px">
      <img src="../images/detalles.png"  style="width:100%">
      <button data-toggle="modal" data-target="#miModal1" class="btn">Ver detalles</button>
     </div>
   </div>
 </div>

 <?php
  }else{
 ?>

<!-- ############################### SI EL TORNEO YA EMPEZO ############################################### -->

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

  <div style="float: left;width: 40%">
  <div style="height: 360px;margin-top: 50px;border: 1px solid black;margin-left: 80px">
    <a href="allgames.php?id=<?php echo $idTour ?>">
    <div style="height: 40px;background-color: #333333;">
      <h3 style="color: white;padding-top: 5px;margin-top: 0px;text-align: center;">Todos los partidos:</h3>
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

  <div style="width: 100%;height: 250px;margin-top: 50px;border: 1px solid black;margin-left: 50px">
    <div style="height: 40px;background-color: #333333;">
      <h3 style="color: white;padding-top: 5px;margin-top: 0px;text-align: center;">Estadísticas:</h3>
    </div>
    <div style="height: 90px;background-color: #e9ebee;">

      <?php
          $firstplace = 1;
          $idmaxscore = 1;
          $idminscore = 1;


          $maxscore = 0;
          $minscore = 0;
          $maxptos = 0;


          foreach ($row as $teams) { 

          $myteamgames = TourController::getTeamMatchs($teams['idTeam'],$idTour);
          $ptos = 0;
          $scoremin = 0;

          foreach ($myteamgames as $matchs) {
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
              if ($maxptos < $ptos) {
                $maxptos = $ptos;
                $firstplace = $teams['idTeam'];
              }

          }           

          $score = 0;

            foreach ($myteamgames as $games) {
              if ($games['scorelocal']==NULL) {
                $score+=0;
              }else{
                if($games['teamlocal'] == $teams['idTeam']){
                  $score+=$games['scorelocal'];
                }else{
                  $score+=$games['scorevisitor'];
                }
              }
              if ($maxscore < $score) {
                $maxscore = $score;
                $score = 0;
                $idmaxscore = $teams['idTeam'];
              }
            } 



            foreach ($myteamgames as $games) {
              if ($games['scorelocal']==NULL) {
                $scoremin+=0;
              }else{
                if($games['teamlocal'] == $teams['idTeam']){
                  $scoremin+=$games['scorevisitor'];
                }else{
                  $scoremin+=$games['scorelocal'];
                }
              }
              if ($scoremin <= $minscore) {
                $minscore = $scoremin;
                $scoremin = 0;
                $idminscore = $teams['idTeam'];
            }

            } 
          }
        ?>

      <?php 
      $team0 = TeamController::getTeam($firstplace); 
      $team1 = TeamController::getTeam($idmaxscore);
      $team2 = TeamController::getTeam($idminscore);
      ?>
      <div style="width: 33.3%;float: left;">
        <h3 style="text-align: center">Líder</h3>
        <center>
        <img src="../images/<?php echo $team0->getShield(); ?>" style="height: 50px;width: 50px;margin-right: 10px;margin-top:25px">
        </center>
        <h5 style="text-align: center"><?php echo $team0->getName()?></h5>
      </div>
      <div style="width: 33.3%;float: left;">
        <h3 style="text-align: center">Mejor ataque</h3>
        <center>
        <img src="../images/<?php echo $team1->getShield(); ?>" style="height: 50px;width: 50px;margin-right: 10px;margin-top:25px">
        </center>
        <h5 style="text-align: center"><?php echo $team1->getName()?></h5>
      </div>
      <div style="width: 33.3%;float: left;">
        <h3 style="text-align: center">Mejor defensa</h3>
        <center>
        <img src="../images/<?php echo $team2->getShield(); ?>" style="height: 50px;width: 50px;margin-right: 10px;margin-top:25px">
        </center>
        <h5 style="text-align: center"><?php echo $team2->getName()?></h5>
      </div>

    </div>
  </div>


  </div>


 <?php
  }
  ?>

  <div class="modal fade" id="miModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div id="modalclass">
      <div class="modal-body">
        <center>
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
            <div id="equ">
            <a href="scouteam.php?id=<?php echo $team->getTeamId() ?>">
            <center>
            <img id="avatar1" src="../images/<?php echo $team->getShield(); ?>">
            </center>
            </a> 
            <?php
            $var = $team->getName();
            ?>
            <h6 style="text-align: center;margin-bottom: 15px"><?php echo substr($var, 0, 12); ?></h6>
            </div>
            <?php
            }}
            ?>
            </div>
            <div>
            <button id="button1" onClick=" window.location.href='teams.php?id=<?php echo $idTour ?>' " class="btn block info btn-lg">Ver equipos inscritos</button>
            </div>
        </center>
      </div>

  </div>
  </div>
</div>


  <form action="../controller/defaultcontroller.php?controlador=tour&accion=joinTour" method='POST'> 
  <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 style="text-align: center;" class="modal-title" id="myModalLabel">¿Qué equipo deseas inscribir?</h4>
      </div>
      <div class="modal-body">
        <center>
        <div style="margin-bottom: 30px">
        <label style="margin-left:10px"><b>Equipos</b></label>
        <select name="equipos">
        <?php
        $row1 = TeamController::getTeamsById($userId);
          if($row1!=null){ 
            foreach ($row1 as $team) {
          ?>
        ?>
        <option value= "<?php echo $team['teamId']; ?> "><?php echo $team['name']; ?></option>;
        <?php
        }
      }
        ?>
        </select>
        </div>
        </center>
        <input type="hidden" name="idTour" value="<?php echo $idTour?>">
        <input type="hidden" name="idUser" value="<?php echo $userId?>">
        <button class="btn block info btn-lg">Inscribirse</button>
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

</html>
    <?php
  }else{
        ob_start(); 
             
              header("Location: ../view/loginredirect.php");
             
          }
          
        ob_end_flush();  

?>