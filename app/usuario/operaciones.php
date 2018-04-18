<?
	if(!isset($_SESSION))
  	{
    	session_start();
  	}

	include_once $_SESSION['base_url'].'/class/system.php';
	$system = new System;

	switch ($_REQUEST['action']) 
	{
		case 'municipio':
			
			$system->sql = "SELECT id_parroquia, parroquia from parroquias where id_estado = 17 and id_municipio = $_GET[mun]";

			echo json_encode($system->sql());
		break;
		
		case 'registrar':
			
			unset($_POST['action']);
			unset($_POST['id_modificar']);
			
			$_POST['usuario'] = strtolower($_POST['usuario']);

			$_POST['usuario'] = str_replace(' ', '_', trim($_POST['usuario']));

			$system->table = "users";
			$system->where = "usuario LIKE '$_POST[usuario]'";
			$repetido = $system->find();
			
			if(!empty($repetido))
			{

				echo json_encode(['r' => false]);
			}
			else
			{

				$_POST['password'] = password_hash('123456789',PASSWORD_DEFAULT);
				$system->table = "users";
				echo json_encode($system->guardar($_POST));
			}
			

		break;

		case 'modificar':

			$system->table = "users";
			$system->where = "id = $_POST[id_modificar]";

			unset($_POST['action']);
			unset($_POST['id_modificar']);

			$_POST['usuario'] = strtolower($_POST['usuario']);

			$_POST['usuario'] = str_replace(' ', '_', trim($_POST['usuario']));

			echo json_encode($system->modificar($_POST));

		break;

		case 'remover':

			$id = base64_decode($_REQUEST['eliminar']);

			$system->table = "users";
			$system->eliminar($id);

			header('location: ./index.php');

		break;
	}
?>