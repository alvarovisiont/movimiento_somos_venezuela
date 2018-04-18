<?
	Class Conexion
	{	
		/*public function conectarPostgre()
		{
			try{
				$conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
                'localhost', 
                5432, 
                'hospital_cumana', 
                'postgres', 
                'admin123');
				$conn = new PDO($conStr);
				if($conn)
				{
					 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					return $conn;
				}
			}
			catch(PDOException $e)
			{
				$e->getMessage();
			}
		}*/

		public function conectarPostgre()
		{
			// conexión a mysql pero la nombro así para no modificar la libreria

			try
			{
				$dsn = 'mysql:host=localhost;dbname=movimiento_somos_venezuela';
				$nombre_usuario = 'root';
				$contraseña = '';
				$opciones = array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
				); 

				$gbd = new PDO($dsn, $nombre_usuario, $contraseña, $opciones);

				return $gbd;
			}
			catch(PDOException $e)
			{
				echo 'No se ha podido establecer la conexión, '.$e->message();
			}
		}
	}
?>