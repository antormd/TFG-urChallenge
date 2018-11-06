<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $row = TeamController::getTeamsById($userId);

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
    <link href="../css/uteams.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    

  </head>
  <body style="background-color: #e9ebee">

  <div class="topnav" id="myTopnav">
  <a href="captainindex.php" class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;"><img style="width: 75px;height: 60px" src="../images/escudo1.png" "></a>
  <a href='captainindex.php'>Home</a>
  <a id="a1" style="float: right;"  href='logout.php'>Cerrar Sesión</a>
  <a id="a2" style="float: right;" href='urperfil.php'>Perfil</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
  </div>


  <div style="margin-top: 80px" class="row">
  <?php
          if($row!=null){ 
            foreach ($row as $team) {
          ?>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4" id="fila" >
          <tr>            
                           <div style="margin-bottom: 20px;border-width: 2px;" class="row">
                          
                          <div id="imagen" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                            <a href="gesteam.php?id=<?php echo $team['teamId']; ?>">
                            <td><img id="imagen" style="" src="../images/<?php echo $team['shield'] ?>"> </td>
                            </a>
                          </div>
                          
                          <div id="equipo" style="" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                            <td width='10%'><strong>Equipo: </strong><?php echo $team['name'] ?> </td>
                          </div>
                          
                          <?php 
                                if($team['teamType'] == "0"){

                          ?>

                          <div id="deporte" style="" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                            <td width='10%'><strong>Deporte: </strong>Fútbol </td>
                          </div>

                          <?php 
                        }elseif($team['teamType'] == "1"){

                          ?>
                          <div id="deporte" style=""class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                            <td width='10%'><strong>Deporte: </strong>Baloncesto </td>
                          </div>
                        


                          <?php 
                        }
                          ?>
                            </div>

          </tr>

          <br>
          </div>
          <?php
            }
          }
          ?>

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