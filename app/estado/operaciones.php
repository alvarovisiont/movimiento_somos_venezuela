<?
	if(!isset($_SESSION))
  	{
    	session_start();
  	}

	include_once $_SESSION['base_url'].'/class/system.php';
	$system = new System;


	switch ($_REQUEST['action']) {
		
		case 'change_password_default':
			
			$system->table = "users";
			$arreglo = ['password_activo' => 1, 'password' => password_hash( $_POST['password'], PASSWORD_DEFAULT )];
			$system->where = "id = $_SESSION[user_id]";
			$res = $system->modificar($arreglo);

			if($res['r'] === true)
			{	
				$_SESSION['pass_activo'] = '1';
				
			}

			echo json_encode($res);

		break;
		
		default:
			# code...
			break;
	}

?>