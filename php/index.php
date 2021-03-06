<!--
  Esta archivo pertenece a la aplicación "generador de objetivos" bajo licencia GPLv2.
  Copyright (C) 2013 Jaime Torres Benavente.

  Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos 
  de la Licencia Pública General de GNU según es publicada por la Free Software Foundation, 
  bien de la versión 2 de dicha Licencia o bien (según su elección) de cualquier versión 
  posterior.

  Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, 
  incluso sin la garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN 
  PROPÓSITO PARTICULAR. Véase la Licencia Pública General de GNU para más detalles.

  Debería haber recibido una copia de la Licencia Pública General junto con este programa. 
  Si no ha sido así, escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, 
  MA 02139, EEUU.
-->

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
		<h1>GENERADOR DE ARCHIVO DE OBJETIVOS</h1>
		<h2>Aplicación para ayudar a los alumnos de la asignatura de Infraestructura Virtual a generar sus ficheros de objetivos</h2>
		<section id="marco">
		<h3>Seleccione los ejercicios realizados</h3>
		<form action="index.php" method="POST">
			<ul>
				<section id="tema1">
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
				</section>
				<section id="tema2">
				<li><h6>TEMA 2</h6></li>
				<li><input type="checkbox" name="ejercicios[]" value="16">Ejercicio 1</li>
				<li><input type="checkbox" name="ejercicios[]" value="17">Ejercicio 2</li>
				<li><input type="checkbox" name="ejercicios[]" value="18">Ejercicio 3</li>
				<li><input type="checkbox" name="ejercicios[]" value="19">Ejercicio 4</li>
				<li><input type="checkbox" name="ejercicios[]" value="20">Ejercicio 5</li>
				<li><input type="checkbox" name="ejercicios[]" value="21">Ejercicio 6</li>
				</section>
				<li><input type="submit" id="enviar" value="Generar archivo"/></li>
			</ul>
		</form>
		</section>
		<p>Imagen obtenida de <a href="http://nacidoparacuriosear.blogspot.com.es/2012/10/almacenamiento-en-cristales-datos-para.html">este blog</a>.</p>
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
