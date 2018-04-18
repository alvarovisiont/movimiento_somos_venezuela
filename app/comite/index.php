<?
	if(!isset($_SESSION))
  	{
    	session_start();
  	}

	include_once $_SESSION['base_url'].'partials/header.php';
	
	$system->sql = "SELECT 
					vp.id,
					concat(vp.nombre,' ',vp.apellido) as nombre,
					concat(vp.nacionalidad,'-',vp.cedula)  as cedula,
					vp.telefono1,
					v.cargos as cargo_vocero,
					concat(
						'Municipio: ',
						(SELECT municipio from municipios where id_municipio = vp.municipio and id_estado = 17),
						' Parroquia: ',
						(SELECT parroquia from parroquias where id_municipio = vp.municipio and id_parroquia = vp.parroquia and id_estado = 17),
						'<br/>',
						vp.ciudad,'-',vp.sector

					) as direccion,
					
					CASE serial_carnet WHEN null THEN 'No posee' ELSE serial_carnet END as carnet_patria

					from voceros_personal as vp
					INNER JOIN vocerias as v ON vp.id_vocerias = v.id
					";

	$title = "Voceros Registrados";
	$th = ['nombre','cédula','telefono1','cargo_vocero','dirección','carnet patria'];
	$key_body = ['nombre','cedula','telefono1','cargo_vocero','direccion','carnet_patria'];
	$data = $system->sql();
	echo make_table($title,$th,$key_body,$data);

?>
	
<?
	include_once $_SESSION['base_url'].'partials/footer.php';
	include_once $_SESSION['base_url'].'partials/modal_change_password.php';
?>