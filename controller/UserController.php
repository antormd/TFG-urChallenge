<?php
class UserController{
public static function login() {
		/*Comprobamos si nos pasan un User por metodo POST*/
		if(!isset($_SESSION)) session_start();{
	    if (isset($_POST["login"]) && isset($_POST["password"])){
	    	if($_POST["login"] && $_POST["password"]){
	    		$user = User::getData($_POST["login"], $_POST["password"]);
				//User no existe
				if ($user==NULL) {
					ob_start();
  					//header("refresh: 3; url = ../index.php");
					$errors = array();
					$errors["general"] = "Nombre de Usuario no valido.";
					echo $errors["general"];
					ob_end_flush();
				}else{
					$_SESSION["userID"] = $user->getUserId();
					$_SESSION["userType"] = $user->getUserType();
				// Si login correcto direcionamos a una vista
				if($user->getUserType()==0){
					header("Location:../view/selectrol.php");
				}
				else{
					//Redireccionamos dependiendo del tipo de usuario
					if($user->getUserType()==1){
						header("Location:../view/adminindex.php");

					}else{
						if($user->getUserType()==2){
							header("Location:../view/captainindex.php");
						}else{
							if($user->getUserType()==3){
							header("Location:../view/playerindex.php");
						}else{
							header("Location:../view/lczacascoginredirect.php");
						}
					}
				}
				}
			  }
	      	}else{
	      		$error = array();
				$error= "Nombre de Usuario no valido";
				print_r($error);
	      	}
	    }
	}
	}

//Funcion que registra a un usuario en la BD.
public static function register() {
		if(!isset($_SESSION)) session_start();				
				$username = $_POST['username'];
				$password = $_POST['password'];
				$email = $_POST['email'];

 
						//Se comprueba si el username que quiere ya existe.
						if(!UserMapper::UserExist($username)){
							//Se comprueba si los datos introducidos son validos.
							if(User::registerValid($username,$password)){
								
								//Se crea un usuario nuevo 
								$user = new User();
								$user->setLogin($username);
								$user->setPassword($password);
								$user->setEmail($email);
								print_r($user) ;
	  							$user->saveUser($user);
	  							
								header("Location: ../view/loginredirect.php"); 
								
							}else{
								ob_start(); 
	  							
	  							header("Location: ../view/register.php"); 
								$errors = array();
								$errors["general"] = "ERROR.El formulario no fue bien completado.";
								echo $errors["general"]; 
								ob_end_flush();
							}
						}else{
							ob_start(); 
	  						
	  						header("Location: ../view/register.php"); 
							$errors = array();
							$errors["general"] = "ERROR.El usuario ya existe.";
							echo $errors["general"]; 
							ob_end_flush();
						}
					
}

//Funcion que actualiza los datos del usuario desde el formulario de perfil.
public static function updateUser(){
		if(!isset($_SESSION)) session_start();

				$userId= $_SESSION["userID"];
				$name = $_POST['name'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				
				$nombre_img = $_FILES['imagen']['name'];
				$tipe = $_FILES['imagen']['type'];
				$tamano = $_FILES['imagen']['size'];

						//Si la imagen utilizada por el usuario cumple alguno de los formatos validos se guarda en la carpeta /images y se actualiza en la BD.
						if($_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png" || $_FILES['imagen']['type']=="image/jpg"){
							//Se comprueba si los datos introducidos son validos.
							if(User::updateValid($password,$name,$email)){
							    $ruta = "../images";
								$nombreArchivo = $_FILES['imagen']['name'];
								move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta."/".$nombreArchivo);
								User::update($userId,$name,$email,$password,$nombreArchivo);
								header("Location: ../view/urperfil.php");
								}else{
								ob_start();
								header("refresh: 3; url = ../view/urperfil.php");
								$errors = array();
								$errors["general"] = "ERROR.El formulario no fue bien completado.";
								echo $errors["general"];
								ob_end_flush();
							}
						}else{
							ob_start();
							header("refresh: 3; url = ../view/urperfil.php");
							$errors = array();
							$errors["general"] = "ERROR. Formato de imagen no válido.";
							echo $errors["general"];
						  	ob_end_flush();
						}
	
}

//Funcion que asigna al usuario un tipo.
public static function selectRol() {
	if(!isset($_SESSION)) session_start();
		$userType = $_POST['type'];
		$userId = $_SESSION['userID'];
		User::updateType($userType,$userId);
		$_SESSION["userType"] = $userType;

	if($userType=="1"){
			//Dependiendo del tipo que elija el usuario se redirecciona a una pagina.
			header("Location: ../view/adminindex.php"); 
			}elseif ($userType=="2") {
			header("Location: ../view/captainindex.php"); 
				}elseif ($userType=="3") {
			header("Location: ../view/playerindex.php"); 
					}else{
					echo "Error inesperado";	
					header("Location: ../view/selectrol.php"); 
					}	
}

//Funcion que obtiene los datos de un usuario especifico.
public static function getUserData($userId){
				$user = User::getDataById($userId);
				return $user;
			}

//Funcion que obtiene el nombre de un usuario mediante el id de este.
public static function getCreatorName($userId){
				$user = User::getDataById($userId);
				return $user;
			}

//Funcion que obtiene una lista con todos los jugadores
public static function getAllPLayers(){
			$players = new User();
			return $players->playerList();
	}

}