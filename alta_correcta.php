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

    <link rel="stylesheet" type="text/css" href="css/alta_correcta.css">

    <title>Generador CV</title>

	<?php 
		// Recibir datos
			if (isset($_POST['enviar']))
				{
					$nombre = ucfirst($_POST['nombre']);
					$apellidos = ucfirst($_POST['apellidos']);
					$correo = $_POST['correo'];
					$usuario = $_POST['usuario'];
					$contrasenya = $_POST['contrasenya'];
				}
			if (isset($_GET['idioma']))
				{
					$_SESSION['idioma'] = $_GET['idioma'];
				}
				else {
					$_SESSION['idioma'] = null;
				}

		// Funcion para comprobar el usuario
			function comprobar_usuario($usuario)
			{
				if (file_exists('xml/datos.xml'))
					{
						$datos_xml = new DOMDocument();
						$datos_xml->load('xml/datos.xml');

						$cantidad_cuentas = $datos_xml->getElementsByTagName('cuenta')->length;
						for($i = 0; $i < $cantidad_cuentas; $i++)
							{
								$usuario_actual = $datos_xml->getElementsByTagName('user')->item($i)->nodeValue;
								if ($usuario == $usuario_actual)
									{
										return "true";
									}
									else {
										continue;
									}
							}
						return "false";
					} 
					else {
						exit('Error abriendo datos.xml.');
					}
			}
			
		// Si el usuario se quiere llamar 'root', le negamos la creacion del usuario ya que no quiero que un no root se llame 'root'
			$accion = null;
			if ($usuario == "root")
				{
					$mensaje = "Lo sentimos. Ese nombre está reservado.";
					$accion = "dos";
				}
				else {
					// Usamos la funcion para comprobar si el usuario ya existe
						$comprobacion = comprobar_usuario($usuario);
					// dependiendo de la respuesta anterior, se crea el usuario o se manda mensaje de error
						if ($comprobacion == "true")
						{
							$mensaje = "Lo sentimos, el usuario indicado ya existe.";
							$accion = "dos";
						}
						else {
								if ($comprobacion == "false")
									{
										// Añadimos los datos de nuevo usuario a datos.xml
										$datos_xml = new DOMDocument();
										$datos_xml -> load('xml/datos.xml');
										//generar nodos
										$generadorcv = $datos_xml -> getElementsByTagName('generadorcv')->item(0);
										$usuariado = $datos_xml -> getElementsByTagName('usuariado')->item(0);
										$cuenta = $datos_xml -> createElement("cuenta");
										// Crear nodos y añadirles valores
										$nombre_nodo = $datos_xml -> createElement("nombre", $_POST['nombre']);
										$apellidos_nodo = $datos_xml -> createElement("apellidos", $_POST['apellidos']);
										$mail_nodo = $datos_xml -> createElement("mail", $_POST['correo']);
										$user_nodo = $datos_xml -> createElement("user", $_POST['usuario']);
										$pass_nodo = $datos_xml -> createElement("pass", $_POST['contrasenya']);
										// añadir los nodos nuevos
										$cuenta -> appendChild($nombre_nodo);
										$cuenta -> appendChild($apellidos_nodo);
										$cuenta -> appendChild($mail_nodo);
										$cuenta -> appendChild($user_nodo);
										$cuenta -> appendChild($pass_nodo);
										// crear y añadir atributo/s
										$cantidad_cuentas = $datos_xml->getElementsByTagName('cuenta')->length;
										$ultima_cuenta = $datos_xml->getElementsByTagName('cuenta')->item($cantidad_cuentas-1); // EXPLICACION DEL '$cantidad_cuentas-1': las cuentas han sido contadas empezando por el 1, en cambio los items empiezan por el 0, si dejo solo la variable $cantidad_cuentas
																																// nunca va a indicar un nodo que exista. Con -1 ya consigue indicar el ultimo nodo. EJEMPLO: si tengo 3 cuentas, el item de la ultima no es 3, si no 2.
										$ultimo_id = $ultima_cuenta->getAttribute("id");
										ECHO $ultimo_id;
										$cuenta -> setAttribute("id", $ultimo_id+1);
										// termino de añadir nodos
										$usuariado -> appendChild($cuenta);
										// guardo los datos
										$datos_xml -> save("xml/datos.xml");
										$mensaje = "Enhorabuena, su cuenta ha sido creada correctamente.";
										$accion = "uno";

										$_SESSION['usuario'] = $_POST['usuario'];
										$_SESSION['contrasenya'] = $_POST['contrasenya'];
									}
									else {
										$mensaje = "Error 0x00754: No se estan contrastando los datos correctamente.";
										$accion = "dos";
										}
							}
					}
	?>

	<style>
		.ing {
			display: 
					<?php
						if ($_SESSION['idioma'] == "ing")
							{
								echo "";
							}
							else {
								echo "none";
							}
					?>
		}
		.esp {
			display: 
					<?php
						if ($_SESSION['idioma'] == "esp" || $_SESSION['idioma'] == null)
							{
								echo "";
							}
						else {
								echo "none";
						}
					?>
		}
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
								echo "none";
							}
							else{
								echo "";
							}
					?>
		}
		.accion_uno {
			display:
					<?php
						if ($accion == "uno")
						{
							echo "";
						}
						else {
							echo "none";
						}
					?>
		}
		.accion_dos {
			display:
					<?php
						if ($accion == "dos" || $accion == null)
						{
							echo "";
						}
						else {
							echo "none";
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
                <li><a href="index.php#inicio">Inicio</a></li>
                <li><a href="generacion.php">Generación de CV</a></li>
				<li><a href="impresion.php">Impresión de CV</a></li>
                <li><a href="proyecto.php">Sobre el proyecto</a></li>
                <li>
                    <a href="#">Idioma</a>
                    <ul class="submenu idioma">
                        <li><a href="cuenta.php?idioma=esp"><img src="archivos/bandera_esp.png" alt="Bandera de España"></a></li>
                        <li><a href="cuenta.php?idioma=ing"><img src="archivos/bandera_ing.png" alt="Bandera de Reino Unido"></a></li>
                    </ul>
                </li>
                <li class="sesion_off">
                    <a class="sesion_off">Cuenta</a>
                    <ul class="submenu cuenta sesion_off">
                        <li><a href="inicio_sesion.php">Inicio sesión</a></li>
                        <li><a href="registro_usuario.php">Nuevo usuario</a></li>
                    </ul>
                </li>
                <li class="sesion_on">
                    <p class="sesion_on"><?php echo $_SESSION['usuario'] ?></p>
                    <ul class="submenu cuenta sesion_on">
                        <li><a href="cuenta.php">Menú usuario</a></li>
                        <li><a href="index.php?sesion=logout">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
	<main>		
		<section>
			<p><?php echo $mensaje; ?></p>
			<a class="accion_uno" href="menu_usuario.php">Menú usuario</a>
			<a class="accion_dos" href="nuevo_usuario.php">Nuevo usuario</a>
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