<html>

<body>
<?php
session_start();
require_once 'Persona.php';
require_once 'Catedra.php';
require_once 'usuario.php';
require_once 'usuarios.php';
if (isset($_SESSION['username']) && isset($_SESSION['pass']) && isset($_COOKIE['Username']))
{
	define('GUARDAR', 'Guardar');
	define('VER_CATS', 'Ver cátedras');
	define('OCULTAR_CATS', 'Ocultar cátedras');
	define("ANADIR", 'Añadir');
	if (isset($_POST['materia']) && $_POST['profesor'] && $_POST['archivo']) {
		//Inicializo las variables que contienen los valores de los inputs a null en caso de que no se haya enviado el formulario aún
		$datos = array();
		$materia = $_POST['materia'];
		$profesor = $_POST['profesor'];
		$archivo = $_POST['archivo'];
		$error = 0;
	}
	//Si el metodo de la solicitud es un post, es decir, si se envio el formulario y la operacion tiene algun valor
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['operacion'])) {
		//Si la operacion es la de guardar:
		if ($_POST['operacion'] === GUARDAR && $_COOKIE['nivel']==0) {
			if (empty($materia) || empty($profesor) || empty($archivo)) {
				$error = 1;
			} else {
				$catedra = new catedra($materia, $profesor, $archivo);
				$catedra->guardarCatedra($materia, $archivo, $profesor);
			}
		}
		else
		{
			if ($_POST['operacion'] === GUARDAR)
			{
				echo '<h3 align=center>No tienes autorizacion para esta accion</h3>
				<a style="margin-left:50%" href="Index.php">Volver</a>';
			}
			else
			{
				//Si la operacion es la de Cargar o ver y el archivo existe
				if (file_exists('Catedras.txt') && $_POST['operacion'] != OCULTAR_CATS) {
					$content = trim(file_get_contents('Catedras.txt'), PHP_EOL);
					$archivosCatedra = explode(PHP_EOL, $content);
					foreach ($archivosCatedra as $archivoCatedra) {
						$catRecovery = new catedra(null, $archivoCatedra, null);
						$catRecovery->recuperarCatedra();
						$datos = ['materia' => $catRecovery->getMateria(), 'profesor' => $catRecovery->getProfesor(), 'archivo' => $catRecovery->getArchivo()];
					}
				}
			}
		}
	}
	echo $body = '
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cátedras</title>
    <style type="text/css">
    </style>
    </head>
		<div style="border-color:#000;border-style: dotted;">
		<h2 align="center">Bienvenido '.$_COOKIE['Username'].'</h2>
    <h3 align="center"> Nueva cátedra </h3>
    <form align="center" method="post" action="Index.php" name="formulario" autocomplete="off">
    Materia: <input type="text" name="materia" id="materia">
	<br /><br />
    Profesor: <input type="text" name="profesor" id="profesor">
	<br /><br />
	Archivo: <input type="text" placeholder="nombre_archivo.txt" name="archivo" id="archivo">

    <br /><br />
    <input type="submit" value="' . GUARDAR . '" name="operacion">
    <input type="submit" value="' . VER_CATS . '" name="operacion">
    <input type="submit" value="' . OCULTAR_CATS . '" name="operacion">

    </form>
		</div>';

	if (isset($error) && $error == 1) {
		echo $valida = '<br />Complete TODOS los campos <br /><br />';
	}

	if (!empty($datos)) {
		$longitud = count($datos);
		echo $tabla_head = '
        <br/>
				<div style="border-color:#000;border-style: dotted; padding-bottom:10px;">
		<h3 align=center>Listado de cátedras </h3>
        <table align=center border="1" width=56%>
            <tr>
                <th>Catedra</th>
                <th>Profesor</th>
				<th>Archivo</th>
				<th><img src="alumno.jpg" height=20px width=20px></th>
            </tr>
    ';
		$archivo = @fopen("Catedras.txt", "r");
		while (($bufer = fgets($archivo, 4096)) !== false) {
			$catedra = explode(" ", $bufer);
			echo '<form method="post" action="addAlumno.php" name="admin_alumnos">';
			echo "<tr>";
			echo '<td><input style="background:#fff; color:#000; border-color:#fff; border-style:none;" readonly value="' . $catedra["0"] . '" name="materia_catedra"></td>';
			echo '<td><input style="background:#fff; color:#000; border-color:#fff; border-style:none;" readonly value="' . $catedra["1"] . '" name="profesor"></td>';
			echo '<td><input style="background:#fff; color:#000; border-color:#fff; border-style:none;" readonly value="' . $catedra["2"] . '" name="archivo"></td>';
			echo '<td><input type="submit" value="Añadir Alumnos" name="operacion"><input type="submit" name="operacion" value="Ver Alumnos"></td>';
			echo "</tr>";
			echo "</form>";
		}
		if (!feof($archivo)) {
			echo "Error: fallo inesperado de fgets()\n";
		}
		fclose($archivo);

		echo $tabla_foot = '</table>
		</div>';
	}
}
else
{
	header("location:login.php");
}
	?>
</body>

</html>
