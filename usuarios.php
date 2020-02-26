<?php
class Usuarios{
	static protected $_pathName;
	private $_registrados=array();
	public function addRegistrado(Usuario $nuevo)
	{
		$this->_registrados=array("nombre"=>$nuevo->getNombre(), "dni"=>$nuevo->getDni(), "nombre_usuario"=>$nuevo->getNick(), "nivel"=>$nuevo->getNivelNewUser(), "contraseña"=>$nuevo->getPass());
		$file = @fopen("usuarios.txt", "a");
		$info = $this->_registrados['nombre'].' '.$this->_registrados['dni'].' '.$this->_registrados['nombre_usuario'].' '. $this->_registrados['contraseña'].' '. $this->_registrados['nivel'].' ';
		fwrite($file, $info.PHP_EOL);
		fclose($file);
	}
	public function recuperarArchivo()
	{
		$manejador=fopen("usuarios.txt","r");
		$usuarios=fgets($manejador);
		return $usuarios;
		fclose($manejador);
	}
	public function autenticar(usuario $login)
	{
		$archivo=fopen('usuarios.txt', "r");
		while (($bufer = fgets($archivo, 4096)) !== false)
		{
			$usuario = explode(" ", $bufer);
			if ($login->getNick()==$usuario["2"] && $login->getPass()==$usuario["3"] )
			{
				return true;
			}
			else
			{
				if (($bufer = fgets($archivo, 4096)) !== false)
				{
					$usuario = explode(" ", $bufer);
					if ($login->getNick()==$usuario["2"] && $login->getPass()==$usuario["3"] )
					{
						return true;
					}
				}
				else
				{
					return false;
				}
			}
		}
	}
}
?>
