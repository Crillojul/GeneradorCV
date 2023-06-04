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
			// Si las variables $_SESSION están vacias, redirige al inicio de sesión
			if(empty($_SESSION['usuario']) && empty($_SESSION['contrasenya'])){
				echo "
					<script>
							window.location.href = 'inicio_sesion.php';
					</script>
				";
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
	
	<script src="js/generacion.js" defer></script>
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
				<form id="formularioCV" action="gen_procesos.php" method="POST">
					<h1>Generación de CV</h1>
					<!-- Titulo del CV -->
						<p>Dale un nombre a tu currículum</p><br>
						<label for="titulo_cv">Título CV: </label>
						<input id="titulo_cv" name="titulo_cv" type="text" pattern="[a-zA-Z0-9_.-() ]{2,60}" placeholder="cv_usuario_1, curriculum1, etc." require>
					<!-- Seccion de la formación -->
						<h3>Formación</h3><br>
							<p>En este apartado indicaras cada una de las titulaciones, ya sea en cuanto a estudios o idiomas, que quieras añadir al currículum</p><br>
							<div id="contenedor_titulacion">
								<label for="nombre_titulacion">Nombre de la titulación: </label>
								<input id="nombre_titulacion" name="nombre_titulacion_0" type="text" pattern="[a-zA-Z0-9_.-() ]{2,60}"><br>
								<label for="fecha_titulacion">Fecha de finalización: </label>
								<input id="fecha_titulacion" name="fecha_titulacion_0" type="date"><br>
								<label for="centro_titulacion">Nombre del centro: </label>
								<input id="centro_titulacion" name="centro_titulacion_0" type="text" pattern="[a-zA-Z0-9_.-() ]{2,60}"><br><br>
							</div>
							<button id="añadirTitulacion" class="addBoton" type="button">Añadir titulación</button><br><br>
					<!-- Seccion del idioma -->
							<p>Añade los idiomas que consideres.</p>
							<div id="contenedor_idiomas">
								<label for="idioma">Idioma: </label>
								<input id="idioma" name="idioma_0" type="text" pattern="[a-zA-Z0-9_.-() ]{2,40}"><br>
								<label for="nivel">Nivel: </label>
								<input id="nivel" name="nivel_0" type="text" pattern="[a-zA-Z0-9_.-() ]{2,40}"><br>
								<label for="certificado">certificado: </label>
								<input id="certificado" name="certificado_0" type="text" pattern="[a-zA-Z0-9_.-() ]{2,40}"><br><br>
							</div>
							<button id="añadirIdioma" class="addBoton" type="button">Añadir idioma</button><br>
					<!-- Seccion de la experiencia -->
						<h3>Experiencia</h3><br>
							<p>Por último, añade las experiencia laborales que consideres</p><br>
							<p><i>Nota: ten en cuenta que el campo 'categoría del puesto' servirá para filtrar experiencias.</i></p>
							<div id="contenedor_experiencia">
								<label for="titulo_exp">Título de la experiencia: </label>
								<input id="titulo_exp" name="titulo_exp_0" type="text" pattern="[a-zA-Z0-9_.-() ]{2,60}"><br>
								<label for="categoria">Categoría del puesto: </label>
								<input id="categoria" name="categoria_0" type="text" pattern="[a-zA-Z0-9_.-() ]{2,60}"><br>
								<label for="descripcion">Descripción del puesto: </label>
								<input id="descripcion" name="descripcion_0" type="text" pattern="[a-zA-Z0-9_.-() ]{2,60}"><br>
								<label for="fecha_inicio">Fecha de inicio: </label>
								<input id="fecha_inicio" name="fecha_inicio_0" type="date"><br>
								<label for="fecha_fin">Fecha de finalización: </label>
								<input id="fecha_fin" name="fecha_fin_0" type="date"><br><br>
							</div>
							<button id="añadirExperiencia" class="addBoton" type="button">Añadir experiencia</button><br>
						<input id="botonEnviar" type="submit" name="enviar" value="Crear CV">
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