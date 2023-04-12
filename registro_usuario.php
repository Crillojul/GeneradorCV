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

    <link rel="stylesheet" type="text/css" href="css/registro_usuario.css">

    <title>Generador CV</title>

    <?php 
			if (isset($_GET['idioma']))
				{
					$_SESSION['idioma'] = $_GET['idioma'];
				}
				else {
					$_SESSION['idioma'] = null;
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
		.root {
			display: 
					<?php 
						if ($_SESSION['usuario'] == "root" && $contrasenya_nodo = "true")
							{
								echo "";
							}
						else {
								echo "none";
							}
					?>
		}
		.no_root {
			display: 
					<?php 
						if ($_SESSION['usuario'] != "root" && $contrasenya_nodo = "true")
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
            <form class="esp" action="alta_correcta.php" method="post">
                <legend>
                    <b>Nuevo usuario</b>
                </legend>
                <label>Nombre:</label>
                <input type="text" pattern="[a-zA-Z/s]{2,60}" name="nombre" placeholder="Escriba aquí su nombre" autocomplete="on" required autofocus><br>
                <label>Apellidos:</label>
                <input type="text" pattern="[a-zA-Z/s]{2,150}" name="apellidos" placeholder="Escriba aquí sus apellidos" autocomplete="on"><br>
                <label>Correo electrócico:</label>
                <input type="email" pattern="[a-zA-Z0-9!#$%&'*_+-]([\.]?[a-zA-Z0-9!#$%&'*_+-])+@[a-zA-Z0-9]([^@&%$\/()=?¿!.,:;]|\d)+[a-zA-Z0-9][\.][a-zA-Z]{2,4}([\.][a-zA-Z]{2})?" name="correo" placeholder="Escriba aquí su correo" autocomplete="on" required><br>
                <label>Usuario:</label>
                <input type="text" pattern="[a-zA-Z0-9!#$%&'*_+-]{3,20}" name="usuario" placeholder="Escriba aquí un usuario" autocomplete="on" required><br>
                <label>Contraseña:</label>
                <input type="password" pattern="[a-zA-Z0-9!#$%&'*_+-]{6,20}" name="contrasenya" placeholder="Escriba aquí una contraseña" autocomplete="on" required><br><br>
				<input type="checkbox" name="terminos" require>
				<label class="check" for="terminos">He leído y estoy de acuerdo con los <a href="trabajando_en_ello.php">terminos y condiciones</a>.</label><br>
				<input type="checkbox" name="privacidad" require>
				<label class="check" for="privacidad">He leído y estoy de acuerdo con la <a href="trabajando_en_ello.php">política de privacidad</a>.</label><br><br>
                <input class="boton" type="reset" name="borrar" value="Borrar">
                <input type="submit" name="enviar" value="Crear usuario">
            </form>
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