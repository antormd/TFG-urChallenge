<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];

 if ($_SESSION['userType'] =='1' or $_SESSION['userType'] =='2'){
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
    <link href="../css/notifies.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    

  </head>
  <body style="background-color: #e9ebee">

  <div class="topnav" id="myTopnav">
  <a href="adminindex.php" class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;"><img style="width: 75px;height: 60px" src="../images/escudo1.png" "></a>
  <a href='adminindex.php'>Home</a>
  <a href="urtours.php"><img style="width: 30px;height: 30px;margin-right: 8px" id="fut" src="../images/trophy2.png">Mis Torneos</a>
  <a id="a1" style="float: right;"  href='logout.php'>Cerrar Sesión</a>
  <a id="a2" style="float: right;" href='urperfil.php'>Perfil</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
  </div>
  
  <h3 style="text-align: center;margin-bottom: 20px">Los siguientes torneos tienen notificaciones:</h3>

  <?php
  $row = NotificationController::getAdminNotis($userId);
  if ($row!=NULL) {
  foreach ($row as $tournoti) {
    $tour = TourController::getTour($tournoti['idTour']);
  ?>

  <center>
  <a href="tourinfo.php?id=<?php echo $tour->getTourId()?>">
  <div id="noti">
    <div>
      <img style="height: 50px;width: 50px;margin-right: 10px;" src="../images/<?php echo $tour->getIcon(); ?>">
      <b style="color: white">  <?php echo $tour->getName() ?></b>
    </div>
  </div>
  </a>
  </center>

  <?php
  }
  }else{
  ?>
  <h4 style="text-align: center;margin-bottom: 20px">No tiene notificaciones.</h4>
  <?php
  }
  ?>
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