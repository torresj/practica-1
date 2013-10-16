<!doctype html>
<html lang="es">
	<head>
	   <meta charset="UTF-8">
	   <title>Generador de Objetivos</title>
	   <link rel = "stylesheet" type = "text/css" href = "CSS/estilo.css" />
	   <meta name="author" content="Jaime Torres Benavente">
	   <meta name="description" content="Prueba">
	</head>
	<body>
		<h1>GENERADOR DE ARCHIVOS DE OBJETIVO</h1>
		<h3>Seleccione los ejercicios realizados</h3>
		<form action="index.php" method="POST">
			<ul>
				<li><h6>TEMA 1</h6></li>
				<li><input type="checkbox" name="ejercicios[]" value="1">Ejercicio 1</li>
				<li><input type="checkbox" name="ejercicios[]" value="2">Ejercicio 2</li>
				<li><input type="checkbox" name="ejercicios[]" value="3">Ejercicio 3</li>
				<li><input type="checkbox" name="ejercicios[]" value="4">Ejercicio 4</li>
				<li><input type="checkbox" name="ejercicios[]" value="5">Ejercicio 5</li>
				<li><input type="checkbox" name="ejercicios[]" value="6">Ejercicio 6</li>
				<li><input type="checkbox" name="ejercicios[]" value="7">Ejercicio 7</li>
				<li><input type="checkbox" name="ejercicios[]" value="8">Ejercicio 8</li>
				<li><input type="checkbox" name="ejercicios[]" value="9">Ejercicio 9</li>
				<li><input type="checkbox" name="ejercicios[]" value="10">Ejercicio 10</li>
				<li><input type="checkbox" name="ejercicios[]" value="11">Ejercicio 11</li>
				<li><input type="checkbox" name="ejercicios[]" value="12">Ejercicio 12</li>
				<li><input type="checkbox" name="ejercicios[]" value="13">Ejercicio 13</li>
				<li><input type="checkbox" name="ejercicios[]" value="14">Ejercicio 14</li>
				<li><input type="checkbox" name="ejercicios[]" value="15">Practica 1</li>
				<li><input type="submit" id="enviar" value="Generar archivo"/></li>
			</ul>
		</form>
		<?php
			$dsn = "mysql:host=127.3.193.130;port:3306;dbname=generadordeobjetivos";
			$usuario= "adminRX1aPbt";
			$clave= "2L5BkMa4NaiS";
			if(isset($_POST['ejercicios']) && !empty($_POST['ejercicios'])){

				//En primer lugar creamos una copia de los objetivos sin marcar
				$objetivos="files/todosObjetivos.md";
				$destino="files/objetivos.md";

				if(!copy($objetivos, $destino)){
  				die("No se ha podido copiar el archivo.");
				}

				//Abrimos el archivo
				$file = fopen($destino,"r+") or exit("No se ha podido abrir el archivo");

				//Abrimos la conexion
				try {
					$conexion = new PDO( $dsn, $usuario, $clave );
					$conexion->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				}catch ( PDOException $e ) { echo "Conexión fallida: " . $e->getMessage();	}

				//Recorremos todos los ejercicios marcados y vamos memoriando los objetivos ya cumplidos
				foreach ($_POST['ejercicios'] as $ejercicio) {
			
					//obtenemos los objetivos que se cumplen consultando la base de datos
					$consultaSQL = 'SELECT * FROM  `generadordeobjetivos`.`ejercicios` WHERE  `ejercicio` ='.$ejercicio;
					
					//ejecutamos la consulta
					try { 
						$resultados=$conexion->query( $consultaSQL ); 
					}catch ( PDOException $e ) { echo "Consulta fallida: " . $e->getMessage(); }
						
						$datos=$resultados->fetchAll();
						//Guardamos el valor de los objetivos
						$x=$datos[0]['objetivo'];
						$x2=$datos[0]['objetivo2'];

						//Establecemos el puntero de lectura/escritura al principio del fichero
						rewind($file);

						$contador=0;
						$fin=false;
						//Buscamos el objetivo1 en el fichero y lo marcamos como cumplido
						while ((false !== ($caracter = fgetc($file))) and false == $fin) {
    					if ($caracter=='[') {
    						$contador+=1;
    						if ($contador==$x) {
    							fwrite($file,'x]');
    							$fin=true;
    						}
    					}
						}

						//Comprobamos si hay otro objetivo que se cumpla con este ejercicio
						if (condition) {
							//Establecemos el puntero de lectura/escritura al principio del fichero
							rewind($file);

							$contador=0;
							$fin=false;
							//Buscamos el objetivo2 en el fichero y lo marcamos como cumplido
							while ((false !== ($caracter = fgetc($file))) and false == $fin) {
	    					if ($caracter=='[') {
	    						$contador+=1;
	    						if ($contador==$x2) {
	    							fwrite($file,'x]');
	    							$fin=true;
	    						}
	    					}
							}
						}
				}

				

				$conexion=NULL;
				fclose($file);

				//enviamos el archivo
				header('Location:files/descargar.php');
			}
		?>
	</body>
</html>
