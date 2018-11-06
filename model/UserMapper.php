<?php
include_once "../model/BDConnection.php";
class UserMapper{

	//Buscamos usuario por su nombre de ususario.
    public static function findByUserName($login)
    {
        $db = new BDConnection();
        $consultaUsuario = "SELECT * FROM users WHERE login=\"$login\"";
        $resultado = $db->consulta($consultaUsuario) or die('Error al ejecutar la consulta de usuario');
        $busqueda = mysqli_num_rows($resultado);
        if ($busqueda > 0) {
            $row = mysqli_fetch_assoc($resultado);
            $usuario= new User($row['userId'],$row['login'],$row['password'],$row['email'],$row['name'],$row['userType'],$row['image']);
            return $usuario;
        }else{
            return NULL;
        }
    }
  
   
    //Mira si el Usuario es valido y devuelve true.
    public static function UserVerify($login, $password) {
         $db = new BDConnection();
        
        //Comprueba si ya existe ese usuario.
        $consultaUsuario = "SELECT * FROM users WHERE login=\"$login\" AND password=\"$password\"";
        $resultado = $db->consulta($consultaUsuario) or die('Error al ejecutar la consulta de usuario');   
        $busqueda = mysqli_num_rows($resultado);
        if( $busqueda > 0) {
            return true;
        }
	}

    //Mira si el nombre de usuario existe.
    public static function UserExist($username) {
        $db = new BDConnection();
        
        //Comprueba si ya existe ese usuario.
        $consultaUsuario = "SELECT * FROM users WHERE login=\"$username\"";
        $resultado = $db->consulta($consultaUsuario) or die('Error al ejecutar la consulta de usuarioooooooo');
        $busqueda = mysqli_num_rows($resultado);
        if( $busqueda > 0) {
            return false;
        }
    }

    //Actualiza el tipo de usuario.
    public function updateType($userType,$userId){
        $db = new BDConnection();
        $result = "UPDATE users SET userType =\"$userType\" WHERE userId=\"$userId\"";
        $db->consulta($result) or die('Error al actualizar el tipo de usuario');
        $db->desconectar();
        return true;
    }

    //Obtiene los datos de un usuario por su id.
    public static function findUserById($userId){
        $db = new BDConnection();
        $sqlfind = $db->consulta('SELECT * FROM users WHERE userId ="'.$userId.'"');
        if (mysqli_num_rows($sqlfind) > 0) {
            $row = mysqli_fetch_assoc($sqlfind); 
            $user= new User($row['userId'],$row['login'],$row['password'],$row['email'],$row['name'],$row['userType'],$row['image']);
            return $user;
        }else{
            return NULL;
        }
    }
    
    //Devuelve si existe un usuario con esa id.
    public static function isUserValid($userId) {
        $db = new BDConnection();
        $sqlesvalido = $db->consulta("SELECT * FROM users WHERE userId=\"$userId\"");
        $busqueda = mysqli_num_rows($sqlesvalido);
        if( $busqueda > 0) {
            return true;
        }
    }
    
    //Guarda un usuario nuevo en la BD.
    public static function saveUser($user){  
        $db = new BDConnection();
        $insertUser = "INSERT INTO users (login,password,email) VALUES ('";
        $insertUser = $insertUser.$user->getLogin()."','".$user->getPassword()."','".$user->getEmail()."')";
        $db->consulta($insertUser) or die('Error al crear el usuario');
        return true;
        $db->desconectar();
    }

    //Actualiza los datos de un usuario.
    public static function update($userId,$name,$email,$password,$imagen){
        $db = new BDConnection();
        $result = "UPDATE users SET name=\"$name\", email =\"$email\", password =\"$password\",image=\"$imagen\"  WHERE userId=\"$userId\"";
        $db->consulta($result) or die('Error al actualizar el usuario');
        $db->desconectar();
        return true;
    }

    //Saca una lista de los usuarios que sean capitan/jugador.
    public static function playerList(){
        $db = new BDConnection();
        $sqlPlayers = $db->consulta("SELECT * FROM users WHERE userType=2 or userType=3 ");
        $arrayPlayers = array();
        while ($row_players = mysqli_fetch_assoc($sqlPlayers))
            $arrayPlayers[] = $row_players;
        $db->desconectar();
        return $arrayPlayers;
    }

    //Obtiene una lista de los jugadores de un equipo.
    public static function getTeamPlayers($idTeam){
        $db = new BDConnection();
        $result = $db->consulta("SELECT * FROM player_team  WHERE idTeam=\"$idTeam\"");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return NULL;
        }
    }


}