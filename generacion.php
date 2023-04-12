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

    <link rel="stylesheet" type="text/css" href="css/generacion.css">

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
			<article>
				<form action="procesos.php" method="post">
					<h1>Generación de CV</h1>
					<p>En primer lugar, dale un nombre a tu currículum</p><br>
					<label for="titulo_cv">Título CV: </label>
					<input id="titulo_cv" name="titulo_cv" type="text" pattern="[a-zA-Z0-9_.-() ]{2-60}" placeholder="cv_usuario_1, curriculum1, etc.">
				</form>
			</article>
			<article>
				<form action="procesos.php">
					<h3>Formación</h3><br>
					<p>En este apartado indicaras cada una de las titulaciones, ya sea en cuanto a estudios o idiomas, que quieras añadir al currículum</p><br>
					<h4>Añadir titulación</h4><br>
					<label for="nombre_titulacion">Nombre de la titulación: </label>
					<input id="nombre_titulacion" name="nombre_titulacion" type="text" pattern="[a-zA-Z0-9_.-() ]{2-60}"><br>
					<label for="fecha_titulacion">Fecha de finalización: </label>
					<input id="fecha_titulacion" name="fecha_titulacion" type="date"><br>
					<label for="centro_titulacion">Nombre del centro: </label>
					<input id="centro_titulacion" name="centro_titulacion" type="text" pattern="[a-zA-Z0-9_.-() ]{2-60}"><br>
				</form>
				<form action="procesos.php">
					<h4>Añadir idioma</h4><br>
					<label for="idioma">Idioma: </label>
					<input id="idioma" name="idioma" type="text" pattern="[a-zA-Z0-9_.-() ]{2-40}"><br>
					<label for="nivel">Nivel: </label>
					<input id="nivel" name="nivel" type="text" pattern="[a-zA-Z0-9_.-() ]{2-40}"><br>
					<label for="certificado">certificado: </label>
					<input id="certificado" name="certificado" type="text" pattern="[a-zA-Z0-9_.-() ]{2-40}"><br>
				</form>
			</article>
			<article>
				<form action="procesos.php">
					<h3>Experiencia</h3><br>
					<p>Por último, añade las Experiencia laborales que consideres</p><br>
					<h4>Añadir experiencia</h4><br>
					<label for="titulo_exp">Título de la experiencia: </label>
					<input id="titulo_exp" name="titulo_exp" type="text" pattern="[a-zA-Z0-9_.-() ]{2-60}"><br>
					<label for="categoria">Categoría del puesto: </label>
					<input id="categoria" name="categoria" type="text" pattern="[a-zA-Z0-9_.-() ]{2-60}"><br>
					<label for="descripcion">Descripción del puesto: </label>
					<input id="descripcion" name="descripcion" type="text" pattern="[a-zA-Z0-9_.-() ]{2-60}"><br>
					<label for="fecha_inicio">Fecha de inicio: </label>
					<input id="fecha_inicio" name="fecha_inicio" type="date"><br>
					<label for="fecha_fin">Fecha de finalización: </label>
					<input id="fecha_fin" name="fecha_fin" type="date"><br><br>
					<input id="boton" type="submit" name="enviar" value="Crear CV">
				</form>
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