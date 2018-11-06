<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 $userType=$_SESSION['userType'];
 $user = UserController::getUserData($userId);

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
    <link href="../css/urperfil.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    

  </head>
  <body >
  
  <div class="topnav" id="myTopnav">
  <a href="captainindex.php" class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;"><img style="width: 75px;height: 60px" src="../images/escudo1.png" "></a>
  
  <?php 
  if ($userType=="1") {
  ?>
  <a href='adminindex.php'>Home</a>
  <?php
  }elseif ($userType=="2") {
  ?>
  <a href='captainindex.php'>Home</a>
  <?php
  }else{
  ?>
  <a href='playerindex.php'>Home</a>
  <?php
  }
  ?>

  <a id="a1" style="float: right;"  href='logout.php'>Cerrar Sesión</a>
  <a id="a2" style="float: right;" href='urperfil.php'>Perfil</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
  </div>

  <!-- Cuerpo de la vista
  -->
  <div id="container">

  <!-- Muestra informacion del usuario
  -->
  <div id="data">
  
  <div id="dataimage" >
    <img  id="avatar" src="../images/<?php echo $user->getImage(); ?>">
    <h3 id="loginname" style="">@<?php echo $user->getLogin(); ?></h3>
  </div>

  <div id="dataform">
    <div id="userdata">
    <h2 style="color: white;margin-left: 40px;padding-top: 18px;font-family: serif;">Datos del usuario:</h2>
    <h3 style="color: white;margin-left: 40px;font-family: serif;">Nombre: <?php echo $user->getName(); ?></h3>
    <h3 style="color: white;margin-left: 40px;font-family: serif;">Email: <?php echo $user->getEmail(); ?></h3>
    <h3 style="color: white;margin-left: 40px;font-family: serif;">Login: <?php echo $user->getLogin(); ?></h3>
    </div>    
  </div>
  </div>

  <!-- Modificar la informacion del usuario
  -->
  <div id="update">

    <form action="../controller/defaultcontroller.php?controlador=user&accion=updateUser" method='POST' enctype="multipart/form-data">

    <div style="margin-top: 30px" class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-7">
              <label for="descAct">Nuevo nombre de usuario: </label>
              <input type="" minlength="3" class="form-control"  name="name"  maxlength="40" required=""></input>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-7">
              <label for="descAct">Nuevo email: </label>
              <input type="email" minlength="3"  class="form-control"   name="email"  maxlength="40" required=""></input>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-7">
              <label for="descAct">Nueva password: </label>
              <input minlength="8" type="password" class="form-control"  id="password" name="password"  maxlength="20" required=""></input>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-7">
              <label for="descAct">Repita nueva password: </label>
              <input minlength="8" type="password" class="form-control" required=""  name="password_confirm" id="password_confirm" oninput="check(this)" maxlength="20"></input>
    </div>
    <div class="form-group col-xs-7 col-sm-6 col-md-6 col-lg-6" style="margin-top:30px;">
              <label for="imgUser">Remplazar imagen de usuario: </label>
              <input style="width: 80%" type="file"  name="imagen" required="">
    </div>
    <div class="form-group col-xs-5 col-sm-6 col-md-6 col-lg-6" style="margin-top:30px;">
    <input type=image src="../images/update.png" width="100" height="100">
    </div>
    </form>
  
    
  </div>


  
  </div>



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
  <script language='javascript' type='text/javascript'>
    function check(input) {
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('Password Must be Matching.');
        } else {
            // input is valid -- reset the error message
         input.setCustomValidity('');
         //window.location.href='register1.php';

        }
    }
   </script>


</html>
  


