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

    <link rel="stylesheet" type="text/css" href="css/procesos.css">

    <title>Generador CV</title>

	<?php
	// proceso de modificación de datos
		if (isset($_POST['modificar'])){
			$datos_xml = new DOMDocument();
			$datos_xml->load('xml/datos.xml');
			$xpath = new DOMXpath($datos_xml);

			$usuario = $_SESSION['usuario'];
			$nodo_del_usuario = $xpath->query("/generadorcv/usuariado/cuenta[user='$usuario']");

			$nombre = $xpath->query("/generadorcv/usuariado/cuenta[user='$usuario']/nombre");
			$apellidos = $xpath->query("/generadorcv/usuariado/cuenta[user='$usuario']/apellidos");
			$correo = $xpath->query("/generadorcv/usuariado/cuenta[user='$usuario']/mail");
			if ($_POST['nueva_contrasenya'] != null)
				{
					$contrasenya = $xpath->query("/generadorcv/usuariado/cuenta[user='$usuario']/pass");
				}

			$nombre->item(0)->nodeValue = $_POST['nombre'];
			$apellidos->item(0)->nodeValue = $_POST['apellidos'];
			$correo->item(0)->nodeValue = $_POST['correo'];
			if ($_POST['nueva_contrasenya'] != null)
				{
					$contrasenya->nodeValue = $_POST['nueva_contrasenya'];
				}
			// Le damos el nuevo valor a las variables de sesion
				$_SESSION['nombre'] = $_POST['nombre'];
				$_SESSION['apellidos'] = $_POST['apellidos'];
				$_SESSION['correo'] = $_POST['correo'];
				if ($_POST['nueva_contrasenya'] != null)
				{
					$_SESSION['contrasenya'] = $_POST['nueva_contrasenya'];
				}
			$datos_xml->save('xml/datos.xml');
			$GLOBALS['mensaje'] = "<p>Los cambios han sido modificados correctamente.</p>";
			}
	// Proceso de eliminación de cuenta por parte del propio usuario
		if (isset($_GET['eli_cuenta'])){
			$datos_xml = new DOMDocument();
			$datos_xml->load('xml/datos.xml');
			$xpath = new DOMXpath($datos_xml);
			// Eliminar la cuenta
			$usuario = $_SESSION['usuario'];
			$usuario_id = $_SESSION['id'];
			$nodo_del_usuario = $xpath->query("/generadorcv/usuariado/cuenta[user='$usuario']");
			if ($nodo_del_usuario->length > 0){
				$cuenta = $nodo_del_usuario->item(0);
				$cuenta->parentNode->removeChild($cuenta);
				$datos_xml->save('xml/datos.xml');
				$GLOBALS['mensaje'] = "<p>La cuenta ha sido eliminada correctamente.</p>";
			}
			else{
				$GLOBALS['mensaje'] = "<p>Lo sentimos, ha surgido un error al intentar eliminar la cuenta.</p>";
			}
			// Eliminar los CVs
			$curriculums = $xpath->query("/generadorcv/curriculums/CV[@cuenta='$usuario_id']");
			foreach ($curriculums as $curriculum) {
				$curriculum->parentNode->removeChild($curriculum);
			}
			$datos_xml->save('xml/datos.xml');
			// redirecciona a index.php en 5 segundos con una variable GET para cerrar la sesion.
			$redireccion = '
				<script>
					setTimeout(function() {
					window.location.href = "index.php?sesion=logout";
					}, 5000);
				</script>';
		}
		else{
			$redireccion = null;
		}
	// Proceso de eliminación de usuario y sus CVs, por parte del root
		if (isset($_POST['eli_usuario']) && $_POST['eli_usuario'] != "ninguno") {
			$datos_xml = new DOMDocument();
			$datos_xml->load('xml/datos.xml');
			$eli_usuario = $_POST['eli_usuario'];

			// Eliminar la cuenta de usuario
			$xpath = new DOMXpath($datos_xml);
			$usuario_nodo = $xpath->query("/generadorcv/usuariado/cuenta[user='$eli_usuario']")->item(0);
			$usuario_id = $usuario_nodo->getAttribute('id'); // saco el id para luego eliminar los CVs
			$usuario_nodo->parentNode->removeChild($usuario_nodo);
			$datos_xml->save('xml/datos.xml');

			// Eliminar los CVs del usuario
			$curriculums = $xpath->query("/generadorcv/curriculums/CV[@cuenta='$usuario_id']");
			foreach ($curriculums as $curriculum) {
				$curriculum->parentNode->removeChild($curriculum);
			}
			$datos_xml->save('xml/datos.xml');
			$GLOBALS['mensaje'] = "<p>La cuenta y todos sus curriculums han sido eliminados.</p>";
		}
		else{
			$GLOBALS['mensaje'] = "<p>La opción elegida no ha realizado ningún cambio.</p>";
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
		<?php
			if(isset($GLOBALS['mensaje'])){
				echo $GLOBALS['mensaje'];
				if($GLOBALS['mensaje'] = "<p>La cuenta ha sido eliminada correctamente.</p>"){
					echo $redireccion;
				}
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