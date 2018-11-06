<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');
include_once "../model/BDConnection.php";

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $row = TourController::getTours();
 $num_total_torneos= mysqli_num_rows($row);
 $url = "http://localhost/urChallenge/view/whattour.php";


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
    <link href="../css/wtour.css" rel="stylesheet">
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

  <center>
  <div id="" style="margin-top: 70px;margin-left: 30px;margin-bottom: 20px">
      <h4>Busca un torneo para inscribir a tu equipo</h4>
      <form name="form" action="searchtour.php" method="get">
      <input type="text" name="search" />
      <input type="submit" name = 'submit' value="Buscar" title="Buscar" />
      </form>
  </div>
  </center>

  <center>
    <h3>Todos los torneos por orden alfabético</h3>
    
    <?php
    if ($num_total_torneos > 0) {


    $TAMANO_PAGINA = 9;
    $pagina = false;

    //examino la pagina a mostrar y el inicio del registro a mostrar
    if (isset($_GET["pagina"]))
        $pagina = $_GET["pagina"];
        
    if (!$pagina) {
        $inicio = 0;
        $pagina = 1;
        }
    else {
    $inicio = ($pagina - 1) * $TAMANO_PAGINA;
    }

    $total_paginas = ceil($num_total_torneos / $TAMANO_PAGINA);

    $db = new BDConnection();
    $result = $db->consulta("SELECT name,createdBy,icon,places,tourId FROM tours ORDER BY name ASC LIMIT ".$inicio."," . $TAMANO_PAGINA);
    while ($row1 = mysqli_fetch_array($result)) {
        ?>
        <div id="main">
          <center>
            <?php 
            $resultado = TourController::getPlacesLeft($row1['tourId']);
            $plazas = $resultado->fetch_row();
            if ($row1['icon']==NULL) {
            ?>
            <a href="scoutour.php?id=<?php echo $row1['tourId']; ?>"><img style="width: 200px;height: 200px;margin-top: 15px" src="../images/torneito.png"></a>
            <?php
            }else{
            ?>
            <a href="scoutour.php?id=<?php echo $row1['tourId']; ?>"><img style="width: 200px;height: 200px;margin-top: 15px" src="../images/<?php echo $row1['icon']?>"></a>
            <?php
            }
            ?>
            <h4>
            Torneo:  <?php  echo $row1['name']; ?>
            </br>
            <?php  $creator = UserController::getCreatorName($row1['createdBy']); ?>
            Creado por: <?php  echo $creator->getLogin(); ?>
            </br>
            Plazas disponibles <?php  echo ($row1['places']-$plazas[0])?>
            </h4>
          </center>
        </div>
        <?php
    }

    echo '<p>';
    ?>
  </center>
  

  <!-- Paginacion
  -->
  <center>
  <div class="pagination" style="width: 100%">
  <?php
    if ($total_paginas > 1) {
    if ($pagina > 1){
    ?>  
      <a href="<?php echo ''.$url.'?pagina='.($pagina-1).''?>">&laquo;</a>
    <?php
    }else{
    ?>  
      <a href="<?php echo ''.$url.'?pagina='.($pagina).''?>">&laquo;</a>
    <?php
    }
    for ($i=1;$i<=$total_paginas;$i++) {
      if ($pagina == $i){
        //si muestro el �ndice de la p�gina actual, no coloco enlace
        ?>
        <a href="#" class="active"><?php echo $pagina; ?></a>
        <?php
        
      }elseif ($pagina != $i) {
        //si el �ndice no corresponde con la p�gina mostrada actualmente,
        //coloco el enlace para ir a esa p�gina
        ?>
        <a href="<?php echo ''.$url.'?pagina='.$i.''?>" ><?php echo ''.$i.'';?></a>
        <?php
    }
  }
    if ($pagina != $total_paginas){
      ?>
      <a href="<?php echo ''.$url.'?pagina='.($pagina+1).''?>">&raquo;</a>
      <?php
  }else{
      ?>
      <a href="<?php echo ''.$url.'?pagina='.($pagina).''?>">&raquo;</a>
      <?php
    }
  }
  echo '</p>';
  }
  ?>
  </div>
  </center>
 
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