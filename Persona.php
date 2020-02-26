<?php
abstract class Persona{
	protected $nombre;
	protected $dni;
	public function __construct(){
		$this->nombre;
		$this->dni;
	}
	public function setNombre($nombre)
	{
		$this->nombre=$nombre;
	}
	public function setDni($dni)
	{
		$this->dni=$dni;
	}
	public function getNombre()
	{
		return $this->nombre;
	}
	public function getDni()
	{
		return $this->dni;
	}
}
?>
