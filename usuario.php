<?php
require_once 'Persona.php';

class Usuario extends Persona {
	private $_nick;
	private $_pass;
	private $_level;
	public function __construct()
	{
		parent::__construct();
	}
	public function getNick()
	{
		return $this->_nick;
	}
	public function setNick($nick)
	{
		$this->_nick=$nick;
	}
	public function getPass()
	{
		return $this->_pass;
	}
	public function setPass($pass)
	{
		$this->_pass=$pass;
	}
	public function setLevel($nivel)
	{
		$this->_level=$nivel;
	}
	public function guardarSesion()
	{
		$_SESSION["username"]=$this->getNick();
		$_SESSION["pass"]=$this->getPass();
	}
	public function recuperarSesion()
	{
		if (isset($_SESSION['username']) && isset($_SESSION['pass']))
		{
			return true;
		}
	}
	public function guardarCookie()
	{
		setcookie("Username", $this->getNick());
		setcookie("nivel", $this->getNivel());
	}
	public function getNivelNewUser()
	{
		return $this->_level;
	}
	public function getNivel()
	{
			$archivo=fopen('usuarios.txt', "r");
			while (($bufer = fgets($archivo, 4096)) !== false)
			{
				$usuario = explode(" ", $bufer);
				if ($this->getNick()==$usuario["2"] && $this->getPass()==$usuario["3"])
				{
						return $usuario["4"];
				}
			}
	}
}
?>
