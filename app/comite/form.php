<?
	if(!isset($_SESSION))
  	{
    	session_start();
  	}
	include_once $_SESSION['base_url'].'partials/header.php';

	$register = null;

	$options_voc = "<option></option>";
	$options_nac = "<option></option>";
	$options_carnet = "";

	if(isset($_GET['modificar']))
	{
		// si existe el where de modificar buscamos el registrp
		$system->table = "voceros_personal";

		$register = $system->find(base64_decode($_GET['modificar']));
		
	}

	// where para el combo de cargo de vocerias
	$where_vocerias = "";
	if(!empty($register))
	{
		$where_vocerias = "WHERE v.id NOT IN (SELECT id_vocerias from voceros_personal where id_padre = $_SESSION[user_id] and id_vocerias <> $register->id_vocerias)";
	}
	else
	{
		$where_vocerias = "WHERE v.id NOT IN (SELECT id_vocerias from voceros_personal where id_padre = $_SESSION[user_id])";
	}



	$system->sql = "SELECT v.id, v.cargos from vocerias as v $where_vocerias";

	foreach ($system->sql() as $row) 
	{
		// llenado del combo de vocerias
		$selected = $register && $register->id_vocerias == $row->id ? 'selected=""' : '';

		$options_voc .= "<option value='{$row->id}' {$selected}>{$row->cargos}</option>";
	
	}

	// where para el combo de parroquias
	
	$nac = ['V','E'];
	foreach ($nac as $row) 
	{
		// llenado del combo de parroquias
		$selected = $register && $register->nacionalidad === $row ? 'selected=""' : '';

		$options_nac .= "<option value='{$row}' {$selected}>{$row}</option>";
	}

	$carnet_patria = [ ['id' => 1, 'carnet' => 'Si'], ['id' => 2, 'carnet' => 'No'] ];

	foreach ($carnet_patria as $row) 
	{
		$selected = "";

		if(!empty($register))
		{
			
			if(!empty($register->serial_carnet) && $row['carnet'] === 'Si')
			{
				$selected = 'selected=""';		
			}
			else if(empty($register->serial_carnet) && $row['carnet'] === 'No')
			{
				$selected = 'selected=""';			
			}
		}

		$options_carnet .= "<option value='".$row["id"]."' {$selected}>".$row["carnet"]."</option>";	
	}
?>
	
	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
				<a href="#" class="fa fa-times"></a>
			</div>
	
			<h2 class="panel-title">Creación de Voceros</h2>
		</header>
		<div class="panel-body">
			<form action="./operaciones.php" class="form-horizontal" id="form_registrar" method="POST">
		
				<input type="hidden" name="id_modificar" value="<?= $register ? $register->id : '' ?>">
				<input type="hidden" name="municipio" value="<?= $_SESSION[municipio] ?>">
				<input type="hidden" name="parroquia" value="<?= $_SESSION[parroquia] ?>">
				<input type="hidden" name="id_padre" value="<?= $_SESSION[user_id] ?>">
				<input type="hidden" id="action" name="action" value="<?= $register ? 'modificar' : 'registrar' ?>">

				<fieldset>
					<div class="form-group">
						<label for="" class="control-label col-md-2 col-sm-2">Nacionalidad</label>
						<div class="col-md-4 col-sm-4">
							<select name="nacionalidad" id="nacionalidad" class="form-control" required="">
								<?= $options_nac ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="control-label col-md-2 col-sm-2">Cédula</label>
						<div class="col-md-4 col-sm-4">
							<input type="number" class="form-control" required="" id="cedula" name="cedula" value="<?= $register ? $register->cedula : '' ?>">
						</div>
						<div class="col-md-4 col-sm-4">
							<button type="button" class="btn btn-primary btn-block" id="btn_search_data">Buscar Datos&nbsp;<i class="fa fa-search"></i></button>
						</div>
					</div>
				</fieldset>
				<br/>
				<fieldset id="fields_ocultos" style="display: <?= $register ? 'block' : 'none' ?>">
					<div class="form-group">
						<label for="" class="control-label col-md-2 col-sm-2">Cargo</label>
						<div class="col-md-4 col-sm-4">
							<select name="id_vocerias" id="id_vocerias" class="form-control" required="">
								<?= $options_voc ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="control-label col-md-2 col-sm-2">Nombre</label>
						<div class="col-md-4 col-sm-4">
							<input type="text" class="form-control" required="" id="nombre" name="nombre" value="<?= $register ? $register->nombre : '' ?>">
						</div>
						<label for="" class="control-label col-md-2 col-sm-2">Apellido</label>
						<div class="col-md-4 col-sm-4">
							<input type="text" class="form-control" required="" id="apellido" name="apellido" value="<?= $register ? $register->apellido : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="control-label col-md-2 col-sm-2">Ciudad</label>
						<div class="col-md-4 col-sm-4">
							<input type="text" class="form-control" required="" id="ciudad" name="ciudad" value="<?= $register ? $register->ciudad : '' ?>">
						</div>
						<label for="" class="control-label col-md-2 col-sm-2">Sector</label>
						<div class="col-md-4 col-sm-4">
							<input type="text" class="form-control" required="" id="sector" name="sector" value="<?= $register ? $register->sector : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="control-label col-md-2 col-sm-2">Fecha Nacimiento</label>
						<div class="col-md-4 col-sm-4">
							<input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required="" class="form-control" value="<?= $register ? $register->fecha_nacimiento : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="control-label col-md-2 col-sm-2">Telefono1</label>
						<div class="col-md-4 col-sm-4">
							<input type="number" class="form-control" name="telefono1" id="telefono1" required="" value="<?= $register ? $register->telefono1 : '' ?>">
						</div>
						<label for="" class="control-label col-md-2 col-sm-2">Telefono2</label>
						<div class="col-md-4 col-sm-4">
							<input type="number" class="form-control" name="telefono2" id="telefono2" value="<?= $register ? $register->telefono2 : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="control-label col-md-2 col-sm-2">Carnet Patria</label>
						<div class="col-md-4 col-sm-4">
							<select id="carnet_patria" name="carnet_patria" class="form-control" required="">
								<option value=""></option>
								<?= $options_carnet ?>
							</select>
						</div>
						<label for="" class="control-label col-md-2 col-sm-2 serial_div">Serial</label>
						<div class="col-md-4 col-sm-4">
							<input type="text" id="serial_carnet" name="serial_carnet" class="form-control serial_div" value="<?= $register ? $register->serial_carnet : '' ?>" disabled="">
						</div>
						
					</div>
					<div class="form-group">
						<div class="col-md-4 col-sm-4 col-sm-offset-3 col-md-offset-3">
							<button type="submit" class="btn btn-danger btn-block">Guardar&nbsp;<i class="fa fa-send"></i></button>
						</div>
						<div class="col-md-4 col-sm-4">
							<a href="./index.php" class="btn btn-info btn-block">Volver&nbsp;<i class="fa fa-reload"></i></a>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</section>
<?
	include_once $_SESSION['base_url'].'partials/footer.php';
?>
<script>
	$('#btn_search_data').click(function(e) {
		let ced = $('#cedula').val(),
			nac = $('#nacionalidad').val()
		
		if(ced === '' || nac === '')
		{
			toastr.warning('Debe Introducir una cédula y escoger una nacionalidad para buscar los datos')
			return false
		}

		$.ajax({
			url: './operaciones.php',
			type: 'GET',
			dataType: 'JSON',
			data: {ced, action: 'search_data', nac},
		})
		.done(function(data) {
			if(data.r)
			{
				toastr.success('Registro encontrado')	

				$('#fields_ocultos').show()

				let row = data.data,
					fecha = row.fecha_nacimiento ? row.fecha_nacimiento : '',
					telefono1 = row.celular1 ? row.celular1 : row.telefono,
					telefono2 = row.celular2 ? row.celular2 : '',
					carnet = row.serial_carnet && row.serial_carnet !== '' ? row.serial_carnet : ''

				$('#nombre').val(row.nombre)
				$('#apellido').val(row.apellido)
				$('#fecha_nacimiento').val(fecha)
				$('#telefono1').val(telefono1),
				$('#telefono2').val(telefono2)

				if(carnet !== '')
				{
					$('#carnet_patria').val(1).prop('selected',true)
					$('#serial_carnet').val(carnet)
					$('#serial_carnet').prop('disabled',false)
				}
				else
				{
					$('#carnet_patria').val('').prop('selected',true)
					$('#serial_carnet').prop('disabled',true)
				}

			}
			else
			{
				if(data.no_existe === undefined)
				{
					$('#fields_ocultos').hide()
					toastr.error('Ya existe un vocero con esta identificación')	
					$('#form_registrar')[0].reset()
					$('#serial_carnet').prop('disabled',true)
				}
				else
				{
					$('#fields_ocultos').show()
					toastr.warning('No se encontraron resultados en su busqueda, por favor rellene campos')
					$('#serial_carnet').prop('disabled',true)
				}		
			}
		})
	});	

	$('#carnet_patria').change(function(e) {
		
		let val = e.target.value

		if(val === '1')
		{
			$('#serial_carnet').prop('disabled',false)
		}
		else
		{
			$('#serial_carnet').prop('disabled',true)
		}
	});

	$('#form_registrar').submit(function(e) {
		e.preventDefault()

		$.ajax({
			url: './operaciones.php',
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize(),
		})
		.done(function(data) {
			if(data.r)
			{
				let action = $('#action').val()

				if(action === "modificar")
				{
					window.location.replace('./index.php')
				}
				else
				{
					$('#form_registrar')[0].reset()
	                $('#fields_ocultos').hide()
	                toastr.success('Vocero agregado con éxito!', 'Éxito!')
				}
	                
			}
			else
			{
                toastr.error('Ha ocurrido un error al ejecutar la operación', 'Error!')
			}
		})
		
	});
</script>
