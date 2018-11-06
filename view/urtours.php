<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $row = TourController::getToursById($userId);

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
    <link href="../css/urtours.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    

  </head>
  <body style="background-color: #e9ebee">

  <div class="topnav" id="myTopnav">
  <a href="adminindex.php" class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;"><img style="width: 75px;height: 60px" src="../images/escudo1.png" "></a>
  <a href='adminindex.php'>Home</a>
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
  <a id="a2" style="float: right;" href='urperfil.php'>Perfil</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
  </div>
  

  <div id="main">
  <div id="going">
  <h3 style="text-align: center;">
  Torneos en progreso  
  </h3>

  <?php
  /*Si la fecha de inicio del torneo es "menor" que la fecha actual el torneo ha comenzado*/
  if($row!=null){ 
            foreach ($row as $tour) {
    $currentDateTime = date('Y-m-d H:i:s');     
    if (($tour['iniT'] < $currentDateTime) AND ($tour['endT'] > $currentDateTime)) {
    ?>
    <center>
    <div style="width: 100%;margin-bottom: 20px">
    <?php 
    if ($tour['icon']==NULL) {
      ?>
    <a href="gestour.php?id=<?php echo $tour['tourId']; ?>"><img style="width: 200px;height: 200px" src="../images/torneito.png"></a>
    <?php
    }else{
    ?>
    <a href="gestour.php?id=<?php echo $tour['tourId']; ?>"><img id="image" src="../images/<?php echo $tour['icon']; ?>"></a>
    <?php 
    }
    ?>
    <br/>
    <strong>Competición: <?php echo $tour['name'];?></strong>
    <br/>
    <?php if ($tour['tourType'] == "0") {
      echo "Tipo de competición: Liga: solo ida";
    }elseif ($tour['tourType'] == "1") {
      echo "Tipo de competición: Liga: ida y vuelta";
    }elseif ($tour['tourType'] == "2") {
      echo "Tipo de competición: Fase final: solo ida";
    }elseif ($tour['tourType'] == "3") {
      echo "Tipo de competición: Fase final: ida y vuelta";
    }elseif ($tour['tourType'] == "4") {
      echo "Tipo de competición: Grupos y Fase final: solo ida";
    }else
    echo "Tipo de competición: Grupos y Fase final: ida y vuelta"; ?>
    </div>
    </center>          
    <?php
               }           
  }
  }
  ?>
  </div>  
  <div id="wait">
  <h3 style="text-align: center;">
  Torneos sin iniciar  
  </h3> 
  <?php
  /*Si la fecha de inicio del torneo es "mayor" que la fecha actual el torneo no ha comenzado*/
  if($row!=null){ 
            foreach ($row as $tour) {
    $currentDateTime = date('Y-m-d H:i:s');     
    if ($tour['iniT'] > $currentDateTime) {
    ?>
    <center>
    <div style="width: 100%;margin-bottom: 20px">
    <?php 
    if ($tour['icon']==NULL) {
      ?>
    <a href="gestour.php?id=<?php echo $tour['tourId']; ?>"><img style="width: 200px;height: 200px" src="../images/torneito.png"></a>
    <?php
    }else{
    ?>
    <a href="gestour.php?id=<?php echo $tour['tourId']; ?>"><img id="image" src="../images/<?php echo $tour['icon']; ?>"></a>
    <?php 
    }
    ?>
    <br/>
    <strong>Competición: <?php echo $tour['name'];?></strong> 
    <br/>
    <?php if ($tour['tourType'] == "0") {
      echo "Tipo de competición: Liga: solo ida";
    }elseif ($tour['tourType'] == "1") {
      echo "Tipo de competición: Liga: ida y vuelta";
    }elseif ($tour['tourType'] == "2") {
      echo "Tipo de competición: Fase final: solo ida";
    }elseif ($tour['tourType'] == "3") {
      echo "Tipo de competición: Fase final: ida y vuelta";
    }elseif ($tour['tourType'] == "4") {
      echo "Tipo de competición: Grupos y Fase final: solo ida";
    }else
    echo "Tipo de competición: Grupos y Fase final: ida y vuelta"; ?>
    </div>   
    </center>        
    <?php
               }           
  }
  }
  ?>
  </div>  
  <div id="end">
  <h3 style="text-align: center;">
  Torneos finalizados 
  </h3>   
  <?php
  /*Si la fecha de fin del torneo es "menor" que la fecha actual el torneo ha finalizado*/
  if($row!=null){ 
            foreach ($row as $tour) {
    $currentDateTime = date('Y-m-d H:i:s');     
    if ($tour['endT'] < $currentDateTime) {
                 ?>
    <center>
    <div style="width: 100%;margin-bottom: 20px">
    <?php 
    if ($tour['icon']==NULL) {
      ?>
    <a href="gestour.php?id=<?php echo $tour['tourId']; ?>"><img style="width: 200px;height: 200px" src="../images/torneito.png"></a>
    <?php
    }else{
    ?>
    <a href="gestour.php?id=<?php echo $tour['tourId']; ?>"><img id="image" src="../images/<?php echo $tour['icon']; ?>"></a>
    <?php 
    }
    ?>
    <br/>
    <strong>Competición: <?php echo $tour['name'];?></strong> 
    <br/>
    <?php if ($tour['tourType'] == "0") {
      echo "Tipo de competición: Liga: solo ida";
    }elseif ($tour['tourType'] == "1") {
      echo "Tipo de competición: Liga: ida y vuelta";
    }elseif ($tour['tourType'] == "2") {
      echo "Tipo de competición: Fase final: solo ida";
    }elseif ($tour['tourType'] == "3") {
      echo "Tipo de competición: Fase final: ida y vuelta";
    }elseif ($tour['tourType'] == "4") {
      echo "Tipo de competición: Grupos y Fase final: solo ida";
    }else
    echo "Tipo de competición: Grupos y Fase final: ida y vuelta"; ?>
    </div>
    </center>            
    <?php
               }           
  }
  }
  ?>
  </div>  


  </div>
 


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