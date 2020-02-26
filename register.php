<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <?php
  if ($_COOKIE['registro']==true)
  {
    require_once 'Persona.php';
    require_once 'usuario.php';
    require_once 'usuarios.php';
    echo'<div style="border-color:#000;border-style: dotted; padding-bottom:10px;">
    <br /><br />
    <h2 align=center>Registro</h2>
    <form align=center method="post" action="register.php" name="formulario_Alumno">
    Nombre: <input type="text" name="nombre" id="nombre">
    <br /><br />
    Dni: <input type="text" name="dni" id="dni">
    <br /><br />
    Nombre de usuario: <input type="text" name="username" id="username">
    <br /><br />
    Nivel: <select name="nivel">
    <option value="NULL"  selected>Selecciona nivel</option>
      <option value="0">Admin</option>
      <option value="1">Usuario</option>
    </select>
    <br /><br />
    Contraseña: <input type="password" name="contraseña" id="contraseña">
    <br /><br />
    Confirma contraseña: <input type="password" name="confirma_contraseña" id="confirma_contraseña">
    <br /><br />
    <input type="submit" value="Aceptar" name="operacion">
    <input type="submit" value="Volver" name="salir">
    </form>
    </div>';
    if (isset($_POST['nombre']) && isset($_POST['dni']) && isset($_POST['username']) && isset($_POST['nivel']) && $_POST['nivel']!==NULL && isset($_POST['contraseña']) && isset($_POST['confirma_contraseña']))
    {
      $nombre=$_POST['nombre'];
      $dni=$_POST['dni'];
      $username=$_POST['username'];
      $nivel=$_POST['nivel'];
      $contraseña=$_POST['contraseña'];
      $confirma_contraseña=$_POST['confirma_contraseña'];
      if ($contraseña==$confirma_contraseña)
      {
        $usuario=new usuario();
        $usuario->setNombre($nombre);
        $usuario->setDni($dni);
        $usuario->setNick($username);
        $usuario->setPass($contraseña);
        $usuario->setLevel($nivel);
        $registro=new usuarios();
        $registro->addRegistrado($usuario);
        echo'<script>alert("Registro exitoso");</script>';
        setcookie("registro", false);
        header("location:login.php");
      }
      else
      {
        echo'<script>alert("las contraseñas no coinciden");</script>';
      }
    }
    if (isset($_POST['Volver']))
    {
      header("location:login.php");
    }
  }
  ?>
</body>
</html>
