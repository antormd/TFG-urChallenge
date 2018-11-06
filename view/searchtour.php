<?php
include_once "../model/BDConnection.php";
include_once('../controller/defaultController.php');
include_once('../model/GeneralModel.php');


if(!isset($_SESSION)) session_start();
$userId=$_SESSION['userID'];
$userType=$_SESSION['userType'];

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
     					$construct .="name LIKE '$search_each%'";
     				else 
     					$construct .="AND name LIKE '$search_each%'"; }
}
				$construct = ("SELECT * FROM tours WHERE $construct"); 
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
    <link href="../css/searchtour.css" rel="stylesheet">
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
<?php

				while( $runrows = mysqli_fetch_assoc( $run ) ) {

        $playerArray[] = array( 
        'id' => $runrows['tourId']
        );

					$image = $runrows ['icon']; 
					$places = $runrows ['places']; 
					$name = $runrows ['name'];
          $createdBy = $runrows ['createdBy'];
          $tourId = $runrows ['tourId'];



?>
          <center>
            <div id="main">
            <?php 
            $resultado = TourController::getPlacesLeft($tourId);
            $plazas = $resultado->fetch_row();
            if ($image==NULL) {
            ?>
            <a href="scoutour.php?id=<?php echo $tourId; ?>"><img style="width: 200px;height: 200px;margin-top: 15px" src="../images/torneito.png"></a>
            <?php
            }else{
            ?>
            <a href="scoutour.php?id=<?php echo $tourId; ?>"><img style="width: 200px;height: 200px;margin-top: 15px" src="../images/<?php echo $image?>"></a>
            <?php
            }
            ?>
            <h4>
            Torneo:  <?php  echo $name; ?>
            </br>
            <?php  $creator = UserController::getCreatorName($createdBy); ?>
            Creado por: <?php  echo $creator->getLogin(); ?>
            </br>
            Plazas disponibles <?php  echo ($places-$plazas[0])?>
            </h4>
            </div>
          </center>
  </div>

<?php
   }
 }
}
        ?>
      
</div>


<div style="margin-top: 80px;clear: left;">
  <h4 style="text-align: center;">Vuelve a buscar</h4>
  <form style="text-align: center;" name="form" action="searchtour.php" method="get">
  <input type="text" name="search" />
  <input type="submit" name = 'submit' value="Buscar" title="Buscar" />
  </form>
  <div style="margin-left: auto;margin-right: auto;">
  <center>
  <button class="btn block info btn-lg" style="  color: red;font-weight: bold;" onClick=" window.location.href='whattour.php' ">Volver</button>
  </center>
  </div>
</div>




  </body>
  </html>
					



