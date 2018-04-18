<?

	if(!isset($_SESSION))
	{
		session_start();
	}	

	include_once $_SESSION['base_url'].'/class/system.php';
	include_once $_SESSION['base_url'].'/vendor/autoload.php';
	$system = new System;


	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load( './hogares_patria.xlsx' );
	$worksheet = $spreadsheet->getActiveSheet();
	
	$con = 0;
	foreach ($worksheet->toArray() as $row) 
	{
		if($con > 0)
		{
			$nombre = "";
			$apellido = "";

			$arr = explode(' ', $row[2]);

			switch (count($arr)) 
			{
				case 1:
					$nombre = $arr[0];
				break;

				case 2:
					$nombre = $arr[0];
					$apellido = $arr[1];
				break;

				case 3: 
					$nombre = $arr[0];
					$apellido = $arr[1]." ".$arr[2];
				break;

				case 4: 
					$nombre = $arr[0]." ".$arr[1];
					$apellido = $arr[2]." ".$arr[3];
				break;

				case 5:
					$nombre = $arr[0]." ".$arr[1];
					$apellido = $arr[2]." ".$arr[3]." ".$arr[4];
				break; 

				case 6:
					$nombre = $arr[0]." ".$arr[1];
					$apellido = $arr[2]." ".$arr[3]." ".$arr[4]." ".$arr[5];
				break;

				default: 
					$nombre = $arr[0]." ".$arr[1];

					unset($arr[0]);
					unset($arr[1]);
					
					$apellido = implode(' ', $arr);

				break;
			}

			

			$arreglo = [
				'nacionalidad' => $row[0],
				'cedula' => $row[1],
				'nombre' => $nombre,
				'apellido' => $apellido,
				'telefono' => $row[3], 
				'direccion' => $row[4],
				'estado' => $row[5],
				'municipio' => $row[7],
				'parroquia' => $row[9],
				'miembros' => $row[10]
			];

			if($con <= 25000)
			{

				$system->table = "hogares_patria";
			}
			else
			{
				$system->table = "hogares_patria1";	
			}

			$res = $system->guardar($arreglo);
			
			if($res['r'] === true)
			{

				echo $con.'Bien <br/>';
			}
			else
			{
				echo $con.'Mal <br/>';	
			}

		}
		
		$con++;
	}






/*	$arreglo = [
					'usuario' => 'e_sucre',
					'password'=> password_hash('123456789',PASSWORD_DEFAULT),
					'perfil'  => 1,
					'activo'  => true,
					'password_activo' => false
				];

	$system->table = "users";
	$system->guardar($arreglo);

	$system->sql = "SELECT id_municipio, municipio from municipios where id_estado = 17";

	foreach ($system->sql() as $row) 
	{

		$row->municipio = str_replace(' ', '_', trim($row->municipio));

		$arreglo = [
					'usuario' => strtolower('M_'.$row->municipio),
					'password'=> password_hash('123456789',PASSWORD_DEFAULT),
					'perfil'  => 2,
					'municipio' => $row->id_municipio,
					'activo'  => true,
					'password_activo' => false
				];

		$system->table = "users";
		$system->guardar($arreglo);
	}

	$system->sql = "SELECT id_municipio, id_parroquia, parroquia from parroquias where id_estado = 17";

	foreach ($system->sql() as $row) 
	{
		$row->parroquia = str_replace(' ', '_', trim($row->parroquia));

		$arreglo = [
					'usuario' => strtolower('P_'.$row->parroquia),
					'password'=> password_hash('123456789',PASSWORD_DEFAULT),
					'perfil'  => 3,
					'municipio' => $row->id_municipio,
					'parroquia' => $row->id_parroquia,
					'activo'  => true,
					'password_activo' => false
				];

		$system->table = "users";
		$system->guardar($arreglo);
	}*/
	

?>