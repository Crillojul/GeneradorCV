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

    <link rel="stylesheet" type="text/css" href="css/descarga.css">

    <title>Generador CV</title>

	<?php
		// Generar las variables que necesitas
		$estilo = $_POST['estilo'];
		$categoria = $_POST['categoria'];
		$id_usuario = $_SESSION['id'];
		$id_cv = $_SESSION['id_cv'];

		// Cargar el archivo XML
		$xml = new DOMDocument();
		$xml->load("xml/datos.xml");
		$xpath = new DOMXpath($xml);

		// Saco el titulo del CV
		$titulo_cv =  $xpath->query("/generadorcv/curriculums/CV[@cuenta='$id_usuario' and @id='$id_cv']/titulo")->item(0)->nodeValue;
		$titulo_cv_js = json_encode($titulo_cv);

		// Cargar la hoja de estilo XSLT
		$xsl = new DOMDocument();
		switch($estilo){
			case 'informal':
				$xsl->load("xml/informal.xsl");
				break;
			case 'formal':
				$xsl->load("xml/formal.xsl");
				break;
			default:
				$xsl->load("xml/informal.xsl");
				break;
		}

		// Crear un procesador XSLT
		$proc = new XSLTProcessor();
		$proc->importStylesheet($xsl);

		// Establecer los parámetros
		$proc->setParameter('', 'categoria', (string) $categoria);
		$proc->setParameter('', 'id_usuario', (string) $id_usuario);
		$proc->setParameter('', 'id_cv', (string) $id_cv);

		// Realizar la transformación
		$resultado = $proc->transformToXml($xml);
	?>

<script src="js/descarga_pdf.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.1/dist/html2canvas.min.js"></script>

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
		<section id="info_descarga">
			<p>Estilo <?php echo $estilo ?> </p>
			<button id="botonDescarga">Descargar PDF</button>
		</section>
		<section id="contenedor_CV">
			<?php echo $resultado; ?>
		</section>
    </main>
    <footer>
		<div>
			<h1>Generador</h1><h1>CV</h1>
		</div>
	</footer>
</body>
</html>