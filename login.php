<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
<?php
require_once 'Persona.php';
require_once 'usuario.php';
require_once 'usuarios.php';
echo'<div style="border-color:#000;border-style: dotted; padding-bottom:10px;">
<br /><br />
<h2 align=center>Login</h2>
<form align=center method="post" action="login.php" name="formulario_Alumno">
Nombre Usuario: <input type="text" name="nombre_usuario" id="nombre_usuario">
<br /><br />
Contraseña: <input type="password" name="password" id="password">
<br /><br />
<input type="submit" value="Login" name="operacion">
<input type="submit" value="Registro" name="registro">
</form>
</div>';
if (isset($_POST['nombre_usuario']) && isset($_POST['password']) && isset($_POST['operacion']))
{
  session_start();
  $nombre_usuario=$_POST['nombre_usuario'];
  $contraseña=$_POST['password'];
  $user=new usuario();
  $user->setNick($nombre_usuario);
  $user->setPass($contraseña);
  $usuarios=new Usuarios();
  if ($usuarios->autenticar($user))
  {
    $user->guardarCookie();
    $user->guardarSesion();
    header("location:Index.php");
  }
  else
  {
    echo'<script>alert("Los datos son invalidos");</script>';
  }
}
else
{
  if (isset($_POST['registro']))
  {
    setcookie("registro", true);
    header("location:register.php");
  }
}
?>
</body>
</html>
