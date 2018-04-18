<?php
	if(!isset($_SESSION))
	{
		session_start();
	}	
		
	include_once $_SESSION['base_url'].'/connection/connection.php';

	Class System extends Conexion
	{
		 private $connPostgre = "";
		 public $campos;
		 public $values; 
		 public $table;
		 public $sql;
		 public $where = null;
		 public function __construct()
		 {
		 		
		 }
// ================== FUNCIONES ESTÁTICAS ============================================================
		 static function validar_logueo()
		 {
		 		if(!isset($_SESSION['user_id']))
		 		{
		 			header("location: $_SESSION[base_url1]");
		 		}
		 }
/*============================================================================================
											FUNCIONES PÚBLICAS POSTGRES
	===========================================================================================*/
		 public function login($user, $pass)
		 {
		 		$this->connPostgre = $this->conectarPostgre();
		 		// Función que se encarga de validar el login
		 		$sql = "SELECT * from users as users where users.usuario = :usuario";
		 		
		 		$res = $this->connPostgre->prepare($sql);
		 		$res->bindParam(':usuario', $user, PDO::PARAM_STR);
		 		$res->execute();
		 			
		 		$total = $res->rowCount();
		 		if($total > 0)
		 		{
		 			$rs = $res->fetchObject(__CLASS__);
		 			if(password_verify($pass, $rs->password))
		 			{
	 					$_SESSION['user_id'] = $rs->id;
			 			$_SESSION['nivel'] = $rs->perfil;
			 			$_SESSION['municipio'] = $rs->municipio;
			 			$_SESSION['parroquia'] = $rs->perfil;
			 			$_SESSION['pass_activo'] = $rs->password_activo;
			 			$_SESSION['user'] = $rs->usuario;
			 			$_SESSION['base_url'] = $_SESSION['base_url'];
			 			$res = null;
			 			$this->connPostgre = null;		
			 			return ['r' => true];
		 			}
		 			else
		 			{
		 				return ['r' => false];
			 		}	
		 		}
		 		else
		 		{
		 			
		 			$res = null;
		 			$this->connPostgre = null;
		 			return ['r' => false];
		 		}
		 			
		 }
		
		 public function sql()
		 {
		 		$this->connPostgre = $this->conectarPostgre();
		 		$res = $this->connPostgre->prepare($this->sql);
		 		$res->execute();
		 		$data = [];
 				while ($rs = $res->fetchObject(__CLASS__))
		 		{
		 			$data[] = $rs;
		 		}
		 		$res = null;
		 		$this->connPostgre = null;
		 		return $data;
		 }
		 public function guardar($arreglo)
		 {
			 	// Función global para realizar un insert
		 		$this->connPostgre = $this->conectarPostgre();	
		 		$keys = "";
		 		$values = '';
		 		foreach ($arreglo as $key => $value) 
		 		{
		 			
		 			if(!empty($value))
		 			{
		 				$value = str_replace("'", '"', $value);
						$keys .= $key.",";
	 					$values .= "'".$value."'".",";		 				
		 			}	
					
		 		}
		 		
		 		$keys = substr($keys, 0,strlen($keys) -1);
		 		$values = substr($values, 0,strlen($values) -1);
			 	$sql = 'INSERT INTO '.$this->table.' ('.$keys.') VALUES ('.$values.')';
			 	$res = $this->connPostgre->prepare($sql);
			 	try
			 	{
			 		$res->execute();
			 		$this->connPostgre = null;
			 		$res = null;
			 		
			 		$this->sql = "SELECT max(id) as id from $this->table";
			 		$id = $this->sql();
			 		$this->table = null;
				 	$data = ['r' => true, 'id' => $id[0]->id];
				 	$_SESSION['flash'] = 1;
			 	}
			 	catch(PDOException $e)
			 	{
					//echo $e->getMessage();
					//echo $sql."<br>";			 		
					//exit();
			 		$this->connPostgre = null;
			 		$res = null;
				 	$this->table = null;
				 	$data = ['r' => false,'sql' => $sql];
				 	$_SESSION['flash'] = 2;
			 	}
			 	return $data;
		 }
		 public function modificar($arreglo)
		 {
		 	
		 	$this->connPostgre = $this->conectarPostgre();	
		 	$campos = " SET ";
		 	foreach ($arreglo as $key => $value) {
		 		if(empty($value))
	 			{
	 				$value = NULL;
	 			}

	 			$value = str_replace("'", '"', $value);
		 		$campos .= $key."="."'".trim($value)."', ";
		 	}
		 	
		 	$campos = substr($campos, 0, strlen($campos)- 2);
		 	$sql = "UPDATE ".$this->table.$campos."WHERE ".$this->where;
		 	
		 	$res = $this->connPostgre->prepare($sql);
			$res->execute();
			$this->connPostgre = null;
			if($res->execute())
			 	{
			 		$this->connPostgre = null;
			 		$res = null;
			 		$this->table = null;
				 	$data = ['r' => true];
				 	$_SESSION['flash'] = 1;
			 	}
			 	else
			 	{
			 		$this->connPostgre = null;
			 		$res = null;
				 	$this->table = null;
				 	$data = ['r' => false,'sql' => $sql];
				 	$_SESSION['flash'] = 0;
			 	}
			 	
			 	return $data;
		 }
		 public function eliminar($id = null)
		 {
		 		$this->connPostgre = $this->conectarPostgre();
		 		$sql = "";
		 		if($id)
		 		{

					$sql = "DELETE from ".$this->table." WHERE id = $id";
		 		}
		 		else
		 		{
		 			$sql = "DELETE from ".$this->table." WHERE ".$this->where;
		 		}

				$res = $this->connPostgre->prepare($sql);
				try
				{
					$res->execute();
					$data = ['r' => true];	
					$_SESSION['flash'] = 1;
				}
				catch(PDOException $e)
				{
					$data = ['r' => false,'sql' => $sql, 'exeption' => $e->getMessage()];	
					$_SESSION['flash'] = 0;
				}
				$this->connPostgre = null;
				return $data;
		 }
		 public function find($id = null)
		 {
		 		$this->connPostgre = $this->conectarPostgre();
		 		if($id)
		 		{
		 			$sql = "SELECT * from ".$this->table." WHERE id = ".$id;
		 		}
		 		else
		 		{
		 			$sql = "SELECT * from ".$this->table." WHERE ".$this->where." LIMIT 1";	
		 		}
		 		
		 		$res = $this->connPostgre->prepare($sql);
		 		$res->execute();
 				$rs = $res->fetchObject(__CLASS__);
		 		
		 		$res = null;
		 		$this->connPostgre = null;
		 		$this->table = null;
		 		return $rs;
		 }
		 public function count()
		 {
		 		$this->connPostgre = $this->conectarPostgre();
		 		if($this->where)
		 		{
		 			$sql = "SELECT count(*) as total from ".$this->table." WHERE ".$this->where;
		 		}
		 		else
		 		{
		 			$sql = "SELECT count(*) as total from ".$this->table;	
		 		}
		 		
		 		$res = $this->connPostgre->prepare($sql);
		 		$res->execute();
		 		$rs = $res->fetchObject(__CLASS__);
		 		$this->table = null;
		 		$this->where = null;
		 		return $rs->total;
		 }
		 public function max($campo)
		 {
		 		$this->connPostgre = $this->conectarPostgre();
		 		if($this->where)
		 		{
		 			$sql = "SELECT max($campo) as $campo from ".$this->table." WHERE ".$this->where;
		 		}
		 		else
		 		{
		 			$sql = "SELECT max($campo) as $campo from ".$this->table;
		 		}
		 		$res = $this->connPostgre->prepare($sql);
		 		$res->execute();
		 		$rs = $res->fetchObject(__CLASS__);
		 		$this->table = null;
		 		$this->where = null;
		 		return $rs->$campo;
		 }
		 public function clean_table()
		 {
		 	
		 	$this->connPostgre = $this->conectarPostgre();
		 	$sql = "TRUNCATE TABLE $this->table";
		 	$res = $this->connPostgre->prepare($sql);
		 	$res->execute();
		 	$this->connPostgre = null;
		 }
		 
		 public function parse_empty($value)
		 {
		 	if($value == trim('0') )
		 	{
		 		return '';
		 	}
		 	else
		 	{
		 		return $value;
		 	}
		 }
	}
?>