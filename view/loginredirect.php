<!DOCTYPE html>
<html lang="en">
  <head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <script type="text/javascript" src="../js/modernizr.custom.86080.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>urChallenge</title>

 
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/logredirect.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">



  </head>
<body >
    <div id="container">  
    <div id="escudo1" style="">
    <a href="loginredirect.php">
        <img id="image" src="../images/escudo.png">
    </a>
    </div>
    <div id="opciones">
    <hr>
    <center>
    <button id = "boton" class="btn block success btn-lg" onclick="document.getElementById('loginbutton').style.display='block'">Iniciar sesión</button>
    </center>

<div id="loginbutton" class="modal">
  <span onclick="document.getElementById('loginbutton').style.display='none'" 
class="close" title="Close Modal">&times;</span>


  <form style="" class="modal-content animate" action="../controller/defaultcontroller.php?controlador=user&accion=login" method='POST'>
    
    <div id="container1">
    <div id="imagen1" style="" class="imgcontainer">
      <img id = "avatar" src="../images/trofeo.png" class="img-responsive" alt="Responsive image">
    </div>

    <div id="user" style="" class="container">
      <label style=""><b>Usuario</b></label>
      <input style="float: right;width: 100%;margin-bottom: 10px" type="text" placeholder="Introduzca usuario" name="login" required>
    </div>

    <div id="pass" style="" class="container">
      <label style=""><b>Contraseña</b></label>
      <input style="float: right;width: 100%" type="password" placeholder="Introduzca contraseña" name="password" required>
  </div>

  <div id="remember" style="" class="container">
      <button class="btn block info btn-md" style="" id = "botonlogin" onclick="cifrar()" type="submit">Entrar</button>
      <input type="checkbox" checked="checked"> Recordarme
    </div>

    <!-- 
    <div style="width: 310px" class="container">
      <span class="psw">Olvidaste <a href='recordarpass.php'>la contraseña?</a></span>
    </div>

    -->
    <div id="volver" style="" class="container">
        <button style="" type="submit" onclick="document.getElementById('loginbutton').style.display='none'" class="btn block info btn-md">Volver</button>
    </div>
    </div>
  </form>
</div>
    <hr>
    <center>
    <button  id="boton1" class="btn block success btn-lg" onClick=" window.location.href='register.php' ">
    Regístrate</button> 
    </center>
    <hr>    
    </div>
    </div>
</body>
  <script>
        function cifrar(){
            var input_cont = document.getElementById("password");
            input_cont.value = hex_md5(input_cont.value);
        }
    </script>
</html>
