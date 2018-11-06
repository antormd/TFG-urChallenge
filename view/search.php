<?php
include_once "../model/BDConnection.php";
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');


if(!isset($_SESSION)) session_start();
$userId=$_SESSION['userID'];
$userType=$_SESSION['userType'];

$idTeam = $_GET ['idTeam'];
$button = $_GET [ 'submit' ]; 
$search = $_GET [ 'search' ]; 

if( !$search ) 
	echo "No ha escrito nada"; 
else {

	if( strlen( $search ) < 1 ) 
		echo "Término demasiado corto"; 
			else { 
?>
      <h2 style="text-align: center;">
<?php  
				echo "Resultados para la búsqueda  <b> $search </b> <hr size='1' > </ br > "; 
        ?>
        </h3>
        <?php  
       			$db = new BDConnection();
				$search_exploded = explode ( " ", $search );
				$x = 0; 
     			foreach( $search_exploded as $search_each ) { 
     				$x++; 
     				$construct = ""; 
     				if( $x == 1 )
     					$construct .="login LIKE '$search_each%'";
     				else 
     					$construct .="AND login LIKE '$search_each%'"; }
}
				$construct = ("SELECT * FROM users WHERE $construct AND (userType=2 or userType=3)"); 
				$run = $db->consulta($construct);

				$foundnum = mysqli_num_rows($run);

				if ($foundnum == 0) 
				
					echo "Perdone, no hay coincidencias para la búsqueda <b> $search </b>. </br> </br>"; 
				else { 

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
    <link href="../css/inviteplay.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">


  </head>
  <body style="background-color: #e9ebee">
      <?php 
      ?>
      <h3 style="text-align: center;">
      <?php 
echo "$foundnum resultados encontrados !<p>";

?>
      </h3>
          <div id="jugador">
            <center>
<?php

				while( $runrows = mysqli_fetch_assoc( $run ) ) {

        $playerArray[] = array( 
        'id' => $runrows['userId']
        );

					$image = $runrows ['image']; 
					$login = $runrows ['login']; 
					$name = $runrows ['name'];
          $id = $runrows ['userId'];


?>
<?php
if ($image!=NULL) {
  ?>
        <img id="avatar" src="../images/<?php echo $image ?>">
        <?php
      }else{
?>
        <img id="avatar" src="../images/avatarvacio.png">
        <?php
      }
?>

<?php
					echo "Login: $login | Name: $name";
          if (TeamMapper::existRel($idTeam,$id)) {
          ?> 
          <div>
          <img style="height: 50px;width: 50px;margin-left: 15px;margin-right: 15px" src="../images/hired.png">Este jugador ya forma parte de tu equipo.
          </div>
          <?php  
           }elseif(InviteMapper::exists($idTeam,$id)){
          ?>
          <div>
          <img style="height: 50px;width: 50px;margin-left: 15px" src="../images/tick.png">Ya has invitado a este jugador.
          </div>
          <?php
          }else{
          ?>
          <form action="../controller/defaultcontroller.php?controlador=invite&accion=invitePlayer" method='POST' enctype="multipart/form-data">
          <input type="hidden" name="idTeam" value="<?php echo $idTeam?>">

          <button id="botonsearch" class="btn block info btn-lg" <img src="../images/invitelogo.png"> Mandar invitación</button>
          <input type="hidden" name="idInvited" value="<?php echo $id?>">
          </form>

          <?php
        }
          echo "<p>";
				} ?>
      </center>
</div>
<?php
			} 
		} 
    ?>

   


<div style="margin-top: 50px;">
  <h4 style="text-align: center;">Vuelve a buscar</h4>
  <form style="text-align: center;" name="form" action="search.php" method="get">
  <input type="text" name="search" />
  <input type="hidden" name="idTeam" value="<?php echo $idTeam ?>">
  <input type="submit" name = 'submit' value="Buscar" title="Buscar" />
  </form>
  <div style="margin-left: auto;margin-right: auto;">
  <center>
  <button class="btn block info btn-lg" style="  color: red;font-weight: bold;" onClick=" window.location.href='captainindex.php' ">Volver</button>
  </center>
  </div>
</div>




  </body>
  </html>
					



