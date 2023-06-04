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

    <link rel="stylesheet" type="text/css" href="css/curriculum.css">

    <title>Generador CV</title>

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
        <?php
			//Proceso de confirmación de borrado
				if(isset($_GET['delcv']) && isset($_GET['delconf']) && empty($_GET['impcv'])){

				}
			// Proceso de eliminación de CV
				elseif (isset($_GET['delcv']) && empty($_GET['impcv'])) {
					$datos_xml = new DOMDocument();
					$datos_xml->load('xml/datos.xml');
					$xpath = new DOMXpath($datos_xml);
					$CV_id = $_GET['delcv'];
					$CV_cuenta = $_SESSION['id'];

					//Eliminar
					$CV_nodo = $xpath->query("/generadorcv/curriculums/CV[@cuenta='$CV_cuenta' and @id='$CV_id']")->item(0);
					$CV_nodo->parentNode->removeChild($CV_nodo);
					$datos_xml->save('xml/datos.xml');

					echo "<p class='mensaje'>El curriculum ha sido eliminado.</p>";
				}
			// Proceso de impresión
				elseif(isset($_GET['impcv']) && empty($_GET['delcv'])){
					$datos_xml = new DOMDocument();
					$datos_xml->load('xml/datos.xml');
					$xpath = new DOMXpath($datos_xml);
					$CV_id = $_GET['impcv'];
					$CV_cuenta = $_SESSION['id'];
					// Quiero tener el id del curriculum para mas adelante
					$_SESSION['id_cv'] = $CV_id;
					// buscar el titulo
					$titulo_cv =  $xpath->query("/generadorcv/curriculums/CV[@cuenta='$CV_cuenta' and @id='$CV_id']/titulo")->item(0)->nodeValue;
					echo "
						<section>
							<article>
								<h3>$titulo_cv</h3>
							</article>
							<article>
								<form action='descarga.php' method='POST'>
									<legend><b>Modo de impresión</b></legend>
									<p>Elige que experiencias laborales quieres mostrar filtrando por la categoría.</p>
									<p>Seleccione <b><i>no filtrar</i></b> para mostrar todas las experiencias o añada un filtro.</p><br>
									<div id='contenedor_filtros' class='contenedor_filtros'>
										<label for='categoria'>Filtro de experiencia:</label>
										<select id='categoria' name='categoria'>
											<option value='nada'>no filtrar</option>";
					$valores_categoria = array();
					$nodos_categoria = $xpath->query("/generadorcv/curriculums/CV[@cuenta='$CV_cuenta' and @id='$CV_id']/experiencia/item/categoria");
					$num_nodos_categoria = $nodos_categoria->length;
					for($i = 0; $i < $num_nodos_categoria; $i++){
							$valor = $nodos_categoria->item($i)->nodeValue;
							$valores_categoria[] = $valor;
						}
					$valores_unicos = array_unique($valores_categoria);
					for($i = 0; $i < count($valores_unicos); $i++){
						echo "<option value='{$valores_unicos[$i]}'>{$valores_unicos[$i]}</option>";
					}
					echo "
										</select><br>
									</div>
									<p>En cuanto al estilo, elige uno de los dos estilos disponibles.</p><br>
									<div id='contenedor_estilos'>
										<label for='estilo'>Indica un estilo:</label>
										<select id='estilo' name='estilo'>
											<option value='informal'>Informal</option>
											<option value='formal'>Formal</option>
										</select><br><br>
									</div>
									<input id='botonEnviar' type='submit' name='imp_filtrado' value='Mostrar'>
								</form>
							</article>
						</section>";
				}
		?>
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