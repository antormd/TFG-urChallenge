<!--
======================================================================
Modelo de la tabla Users
======================================================================
-->

<?php
// file: model/User.php
/**
 * Class User
 * 
 * Representa un usuario en la web
 * 
 */
class User {
 
  private $userId;
  private $login;
  private $password;
  private $email;
  private $name;
  private $userType;
  private $image;
  
 
   // El constructor
 
  public function __construct($userId=NULL,$login=NULL, $password=NULL, $email=NULL, $name=NULL,$userType=NULL,$image=NULL) {
    $this->userId = $userId;
    $this->login = $login;
    $this->password = $password;
    $this->email = $email; 
    $this->name = $name; 
	  $this->userType = $userType;    
	  $this->image = $image;    
  }
  
  // userId
  public function getUserId() {
    return $this->userId;
  }

  // login
  public function getLogin() {
    return $this->login;
  }
  
  public function setLogin($login) {
    $this->login = $login;
  }
  
  // password
  public function getPassword() {
    return $this->password;
  }  
   
  public function setPassword($password) {
    $this->password = $password;
  }
  
  // Email
  public function getEmail() {
    return $this->email;
  }
 
  public function setEmail($email) {
    $this->email = $email;
  }

  // Name
  public function getName() {
    return $this->name;
  }
 
  public function setName($name) {
    $this->name = $name;
  }

  // UserType
  public function getUserType() {
    return $this->userType;
  }
  public function setUserType($userType) {
    $this->userType = $userType;
  }

  // User Image
  public function getImage() {
    return $this->image;
  }
 
  public function setImage($image) {
    $this->image = $image;
  }
  
  //Pide al mapper los datos de un usuario usando su id.
  public static function getDataById($userId) {
    if ($userId) {
      if ($res = UserMapper::isUserValid($userId)) {
        return UserMapper::findUserById($userId);
      }else {
        echo "ERROR: El usuario seleccionado no existe.";
      }
    }else{
      return "ERROR, no existe el usuario seleccionado";
    }
  }

  //Pide al mapper los datos de un usuario usando su login y password.
  public static function getData($login, $password) {
    if ($login && $password) {
      if ($res = UserMapper::UserVerify($login, $password)) {
        return UserMapper::findByUserName($login);
      }else{
        echo "ERROR: Usuario o contrase&ntildea incorrectos.";
      }
    }else{
      return "ERROR, no existe el Ususario";
    }
  }
   
  //Comprueba que el login y password cumplan un formato valido.
  public static function registerValid($username,$password){
    $error = array();
    if (strlen($username) < 4 || strlen($username) > 15) {
	     $error["username"] = "El nombre de usuario debe tener entre 4 y 10 caracteres.";
    }
    if (strlen($password) < 5 || strlen($password) > 50) {
	     $error["password"] = "La contraseña debe tener entre 8 y 15 caracteres.";	
    }
    if (sizeof($error)==0){
        return true;
    }else{
        return true;
    }      
  }

  //Comprueba que los datos de actualizacion de usuario sean validos.
  public static function updateValid($password,$name,$email){
    $error = array();
    if (strlen($password) < 8 || strlen($password) > 20) {
       $error["password"] = "La password debe tener entre 8 y 20 caracteres.";
    }
    if (strlen($name) < 3 || strlen($name) > 40) {
       $error["descripcion"] = "El nombre de usuario debe tener entre 3 y 40 caracteres.";
    }
    if (strlen($email) < 3 || strlen($email) > 40) {
       $error["email"] = "El email del usuario debe estar entre 3 y 40 caracteres.";
    }
    if (sizeof($error)>0){
       echo "Los datos introducidos no son validos: ";
       print_r(array_values($error));
    }
    if (sizeof($error)==0){
       return true;
    }else{
       return true;
    }
  }

  //Pide al mapper actualizar los datos de un usuario.
  public static function update($userId,$name,$email,$password, $imagen){
    UserMapper::update($userId,$name,$email,$password, $imagen);
  }

  //Llama al mapper para guardar usario.
  public static function saveUser($user){  
    return UserMapper::saveUser($user);
  }
  
  //Llama al mapper para guardar el tipo de usuario.
  public static function saveType($user){  
    return UserMapper::saveType($user);
  }

  //Llama al mapper para actualizar el tipo de usuario.
  public static function updateType($userType,$userId){
    UserMapper::updateType($userType,$userId);
  } 

  //Llama al mapper para obtener una lista de jugadores.
  public function playerList(){
    return $players = UserMapper::playerList();
    }

  //Llama al mapper para obtener a los jugadores de un equipo.
  public static function getTeamPlayers($idTeam){
    return $players = UserMapper::getTeamPlayers($idTeam);
  }
  
}