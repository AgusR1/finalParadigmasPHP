<html>

<body>
	<?php
	session_start();
	if (isset($_SESSION['username']) && isset($_SESSION['pass']) && isset($_COOKIE['Username']))
	{
		require_once 'Persona.php';
		require_once 'Catedra.php';
		if (isset($_POST['materia_catedra']) && isset($_POST['profesor']) && isset($_POST['archivo']) && $_POST['operacion'] == "Añadir Alumnos" && isset($_COOKIE['nivel']) && $_COOKIE['nivel']==0)
		{
			$materia_catedra = $_POST['materia_catedra'];
			$profesor_catedra = $_POST['profesor'];
			$archivo_catedra = $_POST['archivo'];
			$catedra = new catedra($materia_catedra, $archivo_catedra, $profesor_catedra);
			$catedra->recuperarCatedra();
			echo $añadir_alumno = '
			<div style="border-color:#000;border-style: dotted; padding-bottom:10px;">
			<br /><br />
			<a style="margin-left:50%" href="Index.php">Volver</a>
			<h2 align=center>' . $catedra->getMateria() . '</h2>
			<h3 align=center>Nuevo alumno</h3>
			<form align=center method="post" action="addAlumno.php" name="formulario_Alumno">
			Nombre: <input type="text" name="nombre" id="nombre">
			<br /><br />
			Apellido: <input type="text" name="apellido" id="apellido">
			<br /><br />
			Legajo: <input type="text" name="legajo" id="legajo"><br /><br />
			<input type="submit" value="Añadir Alumnos" name="operacion">
			<input hidden readonly value="' . $catedra->getMateria() . '" name="materia_catedra">
			<input hidden readonly value="' . $catedra->getProfesor() . '" name="profesor">
			<input hidden readonly value="' . $catedra->getArchivo() . '" name="archivo">
			</form>
			</div>';
			if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['legajo'])) {
				$nombre = $_POST['nombre'];
				$apellido = $_POST['apellido'];
				$legajo = $_POST['legajo'];
				$error = 0;
				if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['operacion'])) {

					if ($_POST['operacion'] === 'Añadir Alumnos') {

						if (empty($nombre)  || empty($apellido) || empty($legajo)) {
							$error = 1;
						} else {
							$catedra->addAlumno($nombre, $apellido, $legajo, $catedra->getArchivo());
							echo '<h3 align=center>Exito</h3>
							</div>';
						}
					}
				}
			}
		}
		else
		{
			if ($_POST['operacion'] == "Añadir Alumnos")
			{
				echo '<h3 align=center>No tienes autorizacion para esta accion</h3>
				<a style="margin-left:50%" href="Index.php">Volver</a>';
			}
			else
			{
				if ($_POST['operacion'] == "Ver Alumnos") {
					if (isset($_POST['materia_catedra']) && isset($_POST['profesor']) && isset($_POST['archivo'])) {
						if (file_exists($_POST['archivo'])) {
							$materia_catedra = $_POST['materia_catedra'];
							$profesor_catedra = $_POST['profesor'];
							$archivo_catedra = $_POST['archivo'];
							$catedra = new catedra($materia_catedra, $archivo_catedra, $profesor_catedra);
							$catedra->recuperarCatedra();
							echo $tabla_alumnos = '
							<br/>
							<div style="border-color:#000;border-style: dotted; padding-bottom:10px;">
							<h3 align=center>Listado de alumnos catedra: ' . $catedra->getMateria() . '</h3>
							<table align=center border="1" width=56%>
							<tr>
							<th>Nombre</th>
							<th>DNI</th>
							<th>Legajo</th>
							</tr>';
							$archivo = @fopen($archivo_catedra, "r");
							while (($bufer = fgets($archivo, 4096)) !== false) {
								$alumnos = explode(" ", $bufer);
								echo '<form method="post" action="Index.php" name="ver_alumn">';
								echo "<tr>";
								echo '<td><input style="background:#fff; color:#000; border-color:#fff; border-style:none;" readonly value="' . $alumnos["0"] . '" name="materia_catedra"></td>';
								echo '<td><input style="background:#fff; color:#000; border-color:#fff; border-style:none;" readonly value="' . $alumnos["1"] . '" name="profesor"></td>';
								echo '<td><input style="background:#fff; color:#000; border-color:#fff; border-style:none;" readonly value="' . $alumnos["2"] . '" name="archivo"></td>';
								echo "</tr>";
								echo "</form>";
							}
							if (!feof($archivo)) {
								echo "Error: fallo inesperado de fgets()\n";
							}
							fclose($archivo);

							echo $tabla_foot_alumnos = '</table>
					<a style="margin-left:50%" href="Index.php">Volver</a>
					</div>';
						} else {
							echo '<h3 align=center>No hay alumnos inscriptos</h3>
							<a style="margin-left:50%" href="Index.php">Volver</a>';
						}
					}
				}
			}
		}
	}
	else
	{
		header("location:login.php");
	}


	?>
