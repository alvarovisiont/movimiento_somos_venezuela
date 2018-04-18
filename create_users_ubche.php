<?

	if(!isset($_SESSION))
	{
		session_start();
	}	

	include_once $_SESSION['base_url'].'/class/system.php';
	$system = new System;


	$system->sql = "SELECT * from centro_votaciones where estado = 17";

	foreach ($system->sql() as $row) 
	{

		//$row->municipio = str_replace(' ', '_', trim($row->municipio));

		$arreglo = [
					'usuario' => $row->ctro_prop,
					'password'=> password_hash('123456789',PASSWORD_DEFAULT),
					'perfil'  => 3,
					'municipio' => $row->municipio,
					'parroquia' => $row->parroquia,
					'activo'  => true,
					'password_activo' => false
				];

		$system->table = "users";
		$system->guardar($arreglo);
	}
	

?>