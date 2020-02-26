<?php
require_once 'Persona.php';
Class Catedra
{
	private $materia;
	static protected $_archivo='Catedras.txt';
	private $profesor;
	private $alumnos=array();
	public function __construct($materia,$archivo,$profesor)
	{
		$this->materia=$materia;
		$this->archivo=$archivo;
		$this->profesor=$profesor;
	}

	public function addAlumno($nombre, $apellido, $legajo, $archivo_alumnos)
	{
		$this->alumnos=array("nombre"=>$nombre, "apellido"=>$apellido, "legajo"=>$legajo,);
		$file = @fopen($archivo_alumnos, "a");
		$info = $this->alumnos['nombre'].' '.$this->alumnos['apellido'].' '.$this->alumnos['legajo'];
		fwrite($file, $info . PHP_EOL);
		fclose($file);
	}

	public function guardarCatedra($materia,$archivo,$profesor)
	{
		$file = @fopen("Catedras.txt", "a");
		$info = $materia . " " . $profesor . " " . $archivo;
		fwrite($file, $info . PHP_EOL);
		fclose($file);
	}

	public function recuperarCatedra()
	{
		$manejador=fopen(self::$_archivo,"r");
		$catedra=fgets($manejador);
		return $catedra;
		fclose($manejador);
	}

	public function getArchivo(){
			return $this->archivo;
		}

		public function getProfesor(){
			return $this->profesor;
		}

		public function getMateria(){
			return $this->materia;
		}

		public function getAlumnos($archivo){
			$manejador=fopen($archivo,"r");
			$alumnos=fgets($manejador);
			return $alumnos;
			fclose($manejador);
		}

}
?>
