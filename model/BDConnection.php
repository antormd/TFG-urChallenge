<?php

class BDConnection {
    var $conexion;
    
    public function __construct($host="localhost",$user="torneouser",
                                $pass="12345", $db="torneo"){
        $this->conexion = mysqli_connect($host, $user, $pass, $db);
        
     
        if (mysqli_connect_errno()){
          echo "Fallo al conectar con la base de datos: " . mysqli_connect_error();
        }
    }
    
    public function consulta($sentencia){
        return mysqli_query($this->conexion,$sentencia);
    }
    
    public function desconectar(){
        $this->conexion->close();
    }
    
    public function getId(){
        return $this->conexion->insert_id;
    }
}
?>
