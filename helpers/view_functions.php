<?
	
	function make_table_editable($title,$th,$key_body,$data)
	{
		// title = Título de la caja
		// th = array de los th de la tabla
		// key_body = aray de los campos a imprimir
		// data = arreglo q viene de la bd o manual con los datos

		$html = '
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
					<a href="#" class="fa fa-times"></a>
				</div>
		
			<h2 class="panel-title">'.$title.'</h2>
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<div class="mb-md pull-right">
							<button id="addToTable" class="btn btn-success">Agregar <i class="fa fa-plus"></i></button>
						</div>
					</div>
				</div>
		<div class="clearfix"></div>
		<table class="table table-bordered table-striped mb-none table-condensed"
			id="datatable-editable"
		>';

		$th_html = "<thead><tr>";

		foreach ($th as $row) 
		{
			$th_html.= '<th class="text-primary text-center">'.ucwords($row).'</th>';
		}


		$th_html.='
					</tr>
				</thead>';
		
		$body_html ='<tbody class="text-center">';

		$con = 0;

		foreach ($data as $row) {
			
			$clase = '';
			switch ($con) {
				case 0:
					$clase = 'gradeX';
				break;
				
				case 1:
					$clase = 'gradeC';
				break;

				default:
					$clase = 'gradeA';
				break;
			}

			$body_html.='<tr class="'.$clase.'">';

			foreach ($key_body as $row1) 
			{
				$body_html.= '<td>'.$row->{$row1}.'</td>';
			}

			$body_html.= '<td class="actions">
							<a href="#" class="hidden on-editing save-row" data-tool="tooltip" title="Guardar">
								<img src="'.$_SESSION['base_url1'].'assets/images/icons/save.jpg'.'" width="20px"/>
							</a>
							<a href="#" class="hidden on-editing cancel-row" data-tool="tooltip" title="Cancelar">
								<img src="'.$_SESSION['base_url1'].'assets/images/icons/cancel.jpg'.'" width="20px"/>
							</a>
							<a href="#" class="on-default edit-row" data-tool="tooltip" title="Modificar">
								<img src="'.$_SESSION['base_url1'].'assets/images/icons/edit.jpg'.'" width="20px"/>
							</a>
							<a href="#" class="on-default remove-row" data-tool="tooltip" title="Eliminar">
								<img src="'.$_SESSION['base_url1'].'assets/images/icons/remove.jpg'.'" width="20px"/>
							</a>
						</td>';

			$body_html.= '</tr>';

			$con++;
		}

		$body_html.= '</tbody>';

		$html.= $th_html.$body_html."</table></div></section>";

		$html.= '<div id="dialog" class="modal-block mfp-hide">
					<section class="panel">
						<header class="panel-heading">
							<h2 class="panel-title">Are you sure?</h2>
						</header>
						<div class="panel-body">
							<div class="modal-wrapper">
								<div class="modal-text">
									<p>Esta seguro de querer eliminar este Registro?</p>
								</div>
							</div>
						</div>
						<footer class="panel-footer">
							<div class="row">
								<div class="col-md-12 text-right">
									<button id="dialogConfirm" class="btn btn-primary">Confirmar</button>
									<button id="dialogCancel" class="btn btn-default">Cancelar</button>
								</div>
							</div>
						</footer>
					</section>
				</div>';

		return $html;
	}

	function make_table($title,$th,$key_body,$data,$crear = true,$editar = true,$eliminar = true)
	{

		// title = Título de la caja
		// th = array de los th de la tabla
		// key_body = aray de los campos a imprimir
		// data = arreglo q viene de la bd o manual con los datos
		// crear = si es true aparece el botón de guardar
		// modificar = si es true aparece el botón de modificar
		// eliminar = si es true aparece el botón de eliminar
		

		$agg = $crear ? '<a href="./form.php" class="btn btn-success">Agregar <i class="fa fa-plus"></i></a>' : '';

		$fila_th = '';

		if($editar === true || $eliminar === true)
		{
			$fila_th = '<th class="text-center text-primary">Acciones</th>';
		}

		$html = '
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
					<a href="#" class="fa fa-times"></a>
				</div>
				<h2 class="panel-title">'.$title.'</h2>
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<div class="mb-md pull-right">
							'.$agg.'
						</div>
					</div>
				</div>
			</header>
		<div class="clearfix"></div>
			<div class="panel-body">
		<table class="table table-bordered table-striped table-condensed table-responsive"
			id="datatable-default"
		>';

		$th_html = "<thead><tr>";

		foreach ($th as $row) 
		{
			$th_html.= '<th class="text-primary text-center">'.ucwords($row).'</th>';
		}

		$th_html.= $fila_th;
		
		$th_html.='
					</tr>
				</thead>';
		
		$body_html ='<tbody class="text-center">';

		$con = 0;

		foreach ($data as $row) {
			
			$clase = '';
			switch ($con) {
				case 0:
					$clase = 'gradeX';
				break;
				
				case 1:
					$clase = 'gradeC';
				break;

				default:
					$clase = 'gradeA';
				break;
			}

			$body_html.='<tr class="'.$clase.'">';

			foreach ($key_body as $row1) 
			{
				$image = '';

				if($row->{$row1} === '0')
				{
					$image= '<img src="'.$_SESSION['base_url1'].'assets/images/icons/desactivado.jpg'.'" width="20px" data-tool="tooltip" title="desactivado"/>';
				}

				if($row->{$row1} === '1')
				{
					$image= '<img src="'.$_SESSION['base_url1'].'assets/images/icons/true.png'.'" width="20px" data-tool="tooltip" title="Activado"/>';	
				}

				if(empty($image))
				{

					$body_html.= '<td>'.$row->{$row1}.'</td>';
				}
				else
				{
					$body_html.= '<td>'.$image.'</td>';	
				}

			}

			$modificar = $editar ? '<a href="./form.php?modificar='.base64_encode($row->id).'" data-tool="tooltip" title="Modificar"><img src="'.$_SESSION['base_url1'].'assets/images/icons/edit.jpg'.'" width="20px"/></a>' : '';
			
			$remover   = $eliminar ? '<a href="./operaciones.php?eliminar='.base64_encode($row->id).'&action=remover" class="remover_helper" data-tool="tooltip" title="Eliminar"><img src="'.$_SESSION['base_url1'].'assets/images/icons/remove.jpg'.'"width="20px"/></a>' : '';

			if(!empty($modificar) || !empty($remover))
			{

				$body_html.= '<td class="">
								'.$modificar.'
								'.$remover.'
							</td>';
			}


			$body_html.= '</tr>';

			$con++;
		}

		$body_html.= '</tbody>';

		$html.= $th_html.$body_html."</table></div></section>";

		return $html;
	}


?>