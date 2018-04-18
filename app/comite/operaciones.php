<?
	if(!isset($_SESSION))
  	{
    	session_start();
  	}

	include_once $_SESSION['base_url'].'/class/system.php';
	$system = new System;

	switch ($_REQUEST['action']) 
	{
		case 'search_data':
			
			$ced = $_GET['ced'];
			$nac = $_GET['nac'];

			$system->table = "voceros_personal";
			$system->where = "nacionalidad = '".$nac."' and cedula = ".$ced;

			$res = $system->find();

			if(!$res)
			{
				$system->table = "adultos_mayores";
				$system->where = "cedula like '".$nac.$ced."'";

				$res = $system->find();

				if(!$res)
				{
					if($ced <= 25000)
					{
						$system->table = "hogares_patria";
					}
					else
					{
						$system->table = "hogares_patria1";	
					}

					$system->where = "cedula = ".$ced." AND nacionalidad = '$nac'";

					$res = $system->find();

					if($res)
					{
						echo json_encode(['r' => true, 'data' => $res]);
					}
					else
					{
						echo json_encode(['r' => false, 'no_existe' => true]);
					}
				}
				else
				{
					echo json_encode(['r' => true, 'data' => $res]);
				}
			}
			else
			{
				echo json_encode(['r' => false]);
			}

				


		break;
		
		case 'registrar':

			unset($_POST['action']);
			unset($_POST['carnet_patria']);
			unset($_POST['id_modificar']);

			$system->table = "voceros_personal";
			echo json_encode($system->guardar($_POST));
		break;

		case 'modificar':
			unset($_POST['action']);
			unset($_POST['carnet_patria']);
			
			$system->table = "voceros_personal";
			$system->where = "id = ".$_POST['id_modificar'];

			unset($_POST['id_modificar']);

			echo json_encode($system->modificar($_POST));
		break;

		case 'remover':
			$system->table = "voceros_personal";
			$system->eliminar(base64_decode($_GET['eliminar']));
			header('location: ./index.php');
		break;
	}

?>