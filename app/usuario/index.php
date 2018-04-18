<?
	if(!isset($_SESSION))
  	{
    	session_start();
  	}

	include_once $_SESSION['base_url'].'partials/header.php';

	$system->sql = "SELECT u.id,u.usuario, m.municipio,p.parroquia,u.activo, u.password_activo
					from users as u
					INNER JOIN municipios as m ON u.municipio = m.id_municipio and m.id_estado = 17
					INNER JOIN parroquias as p ON p.id_parroquia = u.parroquia and u.municipio = p.id_municipio and p.id_estado = 17
					WHERE u.perfil = 4";

	$title = "Usuarios Parroquias";
	$th = ['usuario','municipio','parroquia','activo','password activo'];
	$key_body = ['usuario','municipio','parroquia','activo','password_activo'];
	$data = $system->sql();

	echo make_table($title,$th,$key_body,$data,true,true,true);
?>
<?
	include_once $_SESSION['base_url'].'partials/footer.php';
?>