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
    <link href="../css/registerp.css" rel="stylesheet">
    <link href="../css/placeholders.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/icon.ico">



  </head>
<body >
    <div id="container">  
    <div id="escudo1" style="">
    <a href="logredirect.php">
        <img id="image" src="../images/escudo.png">
    </a>
    </div>
    <div id="formulario">

    <center>
    <div id="texto1" style="">
    <h1 style="">Completa tus datos</h1>        
    </div>
    </center>

    <center>
    <form action="../controller/defaultcontroller.php?controlador=user&accion=register" method='POST'>
    <div style="width: 100%; margin-top: 60px" class="container">
      <label style="width: 100%" style=""><b>Usuario</b></label>
      <input style="margin-bottom: 10px" type="text" minlength="4" maxlength="15" placeholder="Introduzca usuario" name="username" required>
    </div>

    <div style="width: 100%" class="container">
      <label style="width: 100%"><b>Email</b></label>
      <input style="margin-bottom: 10px" type="email" minlength="6" maxlength="40" placeholder="Introduzca email" name="email" required>
    </div>

    <div style="width: 100%" class="container">
      <label style="width: 100%"><b>Contraseña</b></label>
      <input style="margin-bottom: 10px" type="password" minlength="8" maxlength="40" placeholder="Introduzca contraseña" id="password" name="password" required>
    </div>

    <div style="width: 100%" class="container">
      <label style="width: 100%"><b>Repita la contraseña</b></label>
      <input style="margin-bottom: 10px" type="password" minlength="8" maxlength="40" placeholder="Introduzca contraseña" name="password_confirm" id="password_confirm" oninput="check(this)" required>
    </div>

    
    <div style="">

    
    <input type="submit" value="Completar paso" />

    <button   class="btn block success btn-sm" onClick=" window.location.href='loginredirect.php' ">
    Volver</button>  

    </div>

    </form>
    </center>

    </div>
    
  



</body>
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
