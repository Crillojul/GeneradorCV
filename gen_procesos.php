<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/gen_procesos.css">

    <title>Generador CV</title>

    <?php
		// Proceso de añadir un nuevo CV
		if (isset($_POST['enviar'])){
			$datos_xml = new DOMDocument();
			$datos_xml -> load('xml/datos.xml');
			$xpath = new DOMXpath($datos_xml);
			//generar y crear los nodos necesarios
			$generadorcv = $datos_xml -> getElementsByTagName('generadorcv')->item(0);
			$curriculums = $datos_xml -> getElementsByTagName('curriculums')->item(0);
			$CV = $datos_xml -> createElement("CV");
			// Primer nodo del curriculum, el titulo
			$tituloCV = $datos_xml -> createElement("titulo", $_POST['titulo_cv']);
			//segundo nodo, la formacion
			$formacion = $datos_xml -> createElement("formacion");

				// Bucle para insertar la titulacion
				$contador_bucle = 0;
				$continuar_bucle = true;
				while($continuar_bucle){
					if(isset($_POST["nombre_titulacion_{$contador_bucle}"])){
						$titulacion = $datos_xml -> createElement("titulacion");

						$nombreTitulacion = $datos_xml -> createElement("nombre", $_POST["nombre_titulacion_{$contador_bucle}"]);
						$fechaTitulacion = $datos_xml -> createElement("fecha", $_POST["fecha_titulacion_{$contador_bucle}"]);
						$centroTitulacion = $datos_xml -> createElement("centro", $_POST["centro_titulacion_{$contador_bucle}"]);

						$titulacion -> appendChild($nombreTitulacion);
						$titulacion -> appendChild($fechaTitulacion);
						$titulacion -> appendChild($centroTitulacion);

						$formacion -> appendChild($titulacion);
					}
					else{
						$continuar_bucle = false;
					}
					$contador_bucle++;
				}
				// Bucle para insertar los idiomas
				$contador_bucle = 0;
				$continuar_bucle = true;
				while($continuar_bucle){
					if(isset($_POST["idioma_{$contador_bucle}"])){
						$idioma = $datos_xml -> createElement("idioma");

						$nombreIdioma = $datos_xml -> createElement("nombre", $_POST["idioma_{$contador_bucle}"]);
						$nivelIdioma = $datos_xml -> createElement("nivel", $_POST["nivel_{$contador_bucle}"]);
						$certificadoIdioma = $datos_xml -> createElement("certificado", $_POST["certificado_{$contador_bucle}"]);

						$idioma -> appendChild($nombreIdioma);
						$idioma -> appendChild($nivelIdioma);
						$idioma -> appendChild($certificadoIdioma);

						$formacion -> appendChild($idioma);
					}
					else{
						$continuar_bucle = false;
					}
					$contador_bucle++;
				}
			//tercer nodo, la experiencia
			$experiencia = $datos_xml -> createElement("experiencia");

				// Bucle para insertar las experiencias
				$contador_bucle = 0;
				$continuar_bucle = true;
				while($continuar_bucle){
					if(isset($_POST["titulo_exp_{$contador_bucle}"])){
						$item = $datos_xml -> createElement("item");

						$tituloExperiencia = $datos_xml -> createElement("titulo", $_POST["titulo_exp_{$contador_bucle}"]);
						$categoriaExperiencia = $datos_xml -> createElement("categoria", $_POST["categoria_{$contador_bucle}"]);
						$descripcionExperiencia = $datos_xml -> createElement("descripcion", $_POST["descripcion_{$contador_bucle}"]);
						$fecha_inicioExperiencia = $datos_xml -> createElement("fecha_inicio", $_POST["fecha_inicio_{$contador_bucle}"]);
						$fecha_finExperiencia = $datos_xml -> createElement("fecha_fin", $_POST["fecha_fin_{$contador_bucle}"]);

						$item -> appendChild($tituloExperiencia);
						$item -> appendChild($categoriaExperiencia);
						$item -> appendChild($descripcionExperiencia);
						$item -> appendChild($fecha_inicioExperiencia);
						$item -> appendChild($fecha_finExperiencia);

						$experiencia -> appendChild($item);
					}
					else{
						$continuar_bucle = false;
					}
					$contador_bucle++;
				}

			// Añadir los atributos a la etiqueta CV
			$id = $_SESSION['id'];
			$CV -> setAttribute("cuenta", $id);
			$ultimo_id = $xpath->query("/generadorcv/curriculums/CV[@cuenta={$id}]/../CV[last()]/@id")->item(0)->nodeValue;
			if($ultimo_id == null){
				$CV -> setAttribute("id", 0);
			}
			else{
				$CV -> setAttribute("id", $ultimo_id+1);
			}

			// Añadir los tres nodos principales a sus nodos padre, y guardar los datos
			$CV -> appendChild($tituloCV);
			$CV -> appendChild($formacion);
			$CV -> appendChild($experiencia);
			$curriculums -> appendChild($CV);

			$datos_xml -> save("xml/datos.xml");
			$mensaje = "Enhorabuena, el curriculum a sido creado satisfactoriamente.";
		}
		else{
			$mensaje = "Error 0x00754: La variable 'enviar' no existe o esta vacia.";
		}
	?>
    <style>
		.sesion_on{
			display:
					<?php
						if (isset($_SESSION['usuario']))
							{
								echo "";
							}
							else{
								echo "none";
							}
					?>
		}
		.sesion_off{
			display:
					<?php
						if (isset($_SESSION['usuario']))
							{
								echo "none !important";
							}
							else{
								echo "";
							}
					?>
		}
	</style>
</head>
<body>
	<header>
		<nav id="inicio">
            <ul class="menu">
                <li><h1>Generador</h1><h1>CV</h1></li>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="generacion.php">Generación de CV</a></li>
				<li><a href="impresion.php">Impresión de CV</a></li>
                <li><a href="proyecto.php">Sobre el proyecto</a></li>
                <li class="sesion_off">
                    <a class="sesion_off" href="">Cuenta</a>
                    <ul class="submenu cuenta sesion_off">
                        <li><a href="inicio_sesion.php">Inicio sesión</a></li>
                        <li><a href="registro_usuario.php">Nuevo usuario</a></li>
                    </ul>
                </li>
                <li class="sesion_on">
                    <p class="sesion_on"><?php echo '<b>'.$_SESSION['usuario'].'</b>' ?></p>
                    <ul class="submenu usuario sesion_on">
                        <li><a href="cuenta.php">Menú usuario</a></li>
                        <li><a href="index.php?sesion=logout">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <main>
		<section>
			<article>
		<?php
			echo "<p class='mensaje'>$mensaje</p>";
		?>
			</article>
		</section>
    </main>
    <footer>
		<table>
			<tr>
				<td>
					<ul>
						<li><h1>Generador</h1><h1>CV</h1></li>
						<li>
							<div class="contenedor_iconos">
								<a class="icono_contactos" href="#"><img src="archivos/instagram.svg" alt="logo de instagram"></a>
								<a class="icono_contactos" href="#"><img src="archivos/facebook.svg" alt="logo de facebook"></a>
								<a class="icono_contactos" href="#"><img src="archivos/twitter.svg" alt="logo de twitter"></a>
								<a class="icono_contactos" href="#"><img src="archivos/gmail.svg" alt="logo de gmail"></a>
							</div>
						</li>
					</ul>
				</td>
				<td>
					<ul>
						<li>Cristian Llorens Julio</li>
						<li>1º ASIR</li>
						<li>Lenguaje de marcas</li>
						<li>I.E.S. La Vereda</li>
						<li>© 2022-2023 by generadorcv.com, Inc.</li>
					</ul>
				</td>
			</tr>
		</table>
        
	</footer>
</body>
</html>