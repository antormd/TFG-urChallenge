<?php
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');

if(!isset($_SESSION)) session_start();
 $userId=$_SESSION['userID'];
 if ($_SESSION['userType'] =='0'){
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
    <link href="../css/selectrol.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $("#content div").hover(
            function(){
                $("#content").css({"opacity":"1.0"});
            },
            function(){
                $("#content").css({"opacity":"0.5"});
            }
        );
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        $("#content1 div").hover(
            function(){
                $("#content1").css({"opacity":"1.0"});
            },
            function(){
                $("#content1").css({"opacity":"0.5"});
            }
        );
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        $("#content2 div").hover(
            function(){
                $("#content2").css({"opacity":"1.0"});
            },
            function(){
                $("#content2").css({"opacity":"0.5"});
            }
        );
    });
    </script>


  </head>
  <body style="background-color: #e9ebee">

  <h1 style="text-align: center;margin-bottom: 40px">¿Qué rol decides tener?</h1>
    
  <div class="w3-row w3-border">

  <div style="cursor: pointer;" id="content" class="w3-third w3-container" data-toggle="modal" data-target="#miModal">
  <h2 style="text-align: center;margin-bottom: 20px">Administrador</h2>
  <div style="text-align: center;">
  <img id="image" style="width: 33%;margin-bottom: 15px" src="../images/admin.png">
  </div>
  <div style="text-align: center;">
  <p>Crea y dirige tu torneo/competición</p>
  <p>Actualiza resultados y tablas</p>
  <p>Gestiona facilmente un torneo</p>
  </div>
  </div>

  <div style="cursor: pointer;" id="content1" class="w3-third w3-container" data-toggle="modal" data-target="#miModal1">
  <h2 style="text-align: center;margin-bottom: 20px">Capitán</h2>
  <div style="text-align: center;">
  <img id="image" style="width: 33%;margin-bottom: 15px" src="../images/capitan.png">
  </div>
  <div style="text-align: center;">
  <p>Crea y dirige a tu equipo</p>
  <p>Envía invitaciones a los jugadores que pertenezcan a tu equipo</p>
  <p>Interactua con otros capitanes</p>
  </div>
  </div>

  <div style="cursor: pointer;" id="content2" class="w3-third w3-container" data-toggle="modal" data-target="#miModal2">
  <h2 style="text-align: center;margin-bottom: 20px">Jugador</h2>
  <div style="text-align: center;">
  <img id="image" style="width: 33%;margin-bottom: 15px" src="../images/jugador.png">
  </div>
  <div style="text-align: center;">
  <p>Únete a tu equipo</p>
  <p>Comprueba clasificaciones y estadísticas</p>
  <p>Observa resultados y calendario</p>
  </div>
  </div>
  </div>

   <!-- MODAL PARA ADMIN 
   -->
  <form action="../controller/defaultcontroller.php?controlador=user&accion=selectRol" method='POST'> 
  <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">¿Seguro que deseas elegir el rol de administrador?</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="type" value="1">
        <button class="btn block info btn-lg">Si</button>
        <button name="1" class="btn block info btn-lg" style="  color: #900;font-weight: bold;" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
  </div>
  </form>

   <!-- MODAL PARA CAPITAN
   -->
  <form action="../controller/defaultcontroller.php?controlador=user&accion=selectRol" method='POST'> 
  <div class="modal fade" id="miModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">¿Seguro que deseas elegir el rol de capitán?</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="type" value="2">
        <button class="btn block info btn-lg">Si</button>
        <button class="btn block info btn-lg" style="  color: #900;font-weight: bold;" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
  </div>
  </form>

  <!-- MODAL PARA JUGADOR 
   -->
<form action="../controller/defaultcontroller.php?controlador=user&accion=selectRol" method='POST'> 
 <div class="modal fade" id="miModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">¿Seguro que deseas elegir el rol de jugador?</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="type" value="3">
        <button class="btn block info btn-lg">Si</button>
        <button class="btn block info btn-lg" style="  color: #900;font-weight: bold;" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
  </div>
  </form>

  </body>
  </html>
  <?php
  }else{
        ob_start(); 
             
              header("Location: ../view/loginredirect.php");
             
          }
          
        ob_end_flush();  

?>