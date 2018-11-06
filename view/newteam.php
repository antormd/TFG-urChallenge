<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];

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
    <link href="../css/newteam.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    

  </head>
  <body>
  <div id="container">
    <form action="../controller/defaultcontroller.php?controlador=team&accion=createTeam" method='POST' enctype="multipart/form-data">
    <div id="formulario">
        <h2 style="text-align: center;">
            Crea tu equipo
        </h2>
        <div>
        <label style="margin-left:10px;margin-top: 20px"><b>Nombre del equipo</b></label>
        <input style="margin-left:40px;"  minlength="4" maxlength="30" placeholder="Introduzca nombre" name="name" required>
        </div>
        <div>
        <label style="margin-left:10px"><b>Tipo de equipo</b></label>
        <select name="type" style="margin-left: 67px">
        <option value="0">Fútbol</option>
        <option value="1">Baloncesto</option>
        <option value="2">Otro</option>
        </select>
        </div>
        <div style="margin-left:10px;">
              <label>Elige escudo: </label>
              <input type="file" required="" name="shield">
        </div>
        <p style="margin-left: 10px;margin-top: 20px;color: blue">
            Si no tienes un escudo puedes crearlo aqui:
        </p>
        <a href="http://www.hoysejuega.com/escudos.php" target="_blank">
            <img src="../images/icon.ico">
        </a>
        <center>
        <div style="margin-bottom: 15px;margin-top: 15px">
        <button type="submit" class="btn block info btn-lg" style="color: #4caf50;font-weight: bold;">Crear</button>
        <button  class="btn block info btn-lg" onClick=" window.location.href='captainindex.php'" style="  color: #900;font-weight: bold;">Volver</button>
        </div>
        </center>
    </div>
    </form>
  </div>    
  </body>
  </html>
    <?php
  }else{
        ob_start(); 
             
              header("Location: ../view/loginredirect.php");
             
          }
          
        ob_end_flush();  

?>