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

    <link rel="stylesheet" type="text/css" href="css/index.css">

    <title>Generador CV</title>

    <?php 
		if (isset($_GET['sesion'])){
				unset($_SESSION['nombre']);
				unset($_SESSION['apellidos']);
				unset($_SESSION['correo']);
				unset($_SESSION['usuario']);
				unset($_SESSION['contrasenya']);
				unset($_SESSION['id']);
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
			<article class="mensaje_principal">
				<p>¡Te ayudamos a crear tus curriculums de una forma sencilla!</p>
			</article>
		</section>
		<section>
			<article>
				<video autoplay loop>
					<source src="archivos/generacion.mp4" type="video/mp4">
					Su navegador no soporta la etiqueta de vídeo.
				</video>
			</article>
			<article>
				<p>
					<b>Generación de CV</b><br>Aquí podrás crear tu curriculum.<br>Indica tu formación ya sea titulaciones o idiomas.
					<br>Después, añade tu experiencia laboral, si has trabajado en distintos sectores o has ido ascendiendo de categoria
					puedes añadir una palabra al campo '<i>categoria del puesto</i>' para poder filtrar esas experiencia más adelante.
				</p>
			</article>
		</section>
		<section>
			<article>
				<p>
					<b>Impresión de CV</b><br>En esta sección tendrás tus curriculums, donde podrás decargarlos o eliminarlos.<br>
					Una vez seleccionado el curriculum, entra en el modo impresión donde deberás indicar si quieres filtrar tus experiencias y el estilo de curriculum que deseas.<br>
					Muestra tu curriculum y si estás conforme, descargalo en PDF.
				</p>
			</article>
			<article>
				<video autoplay loop>
					<source src="archivos/impresion.mp4" type="video/mp4">
					Su navegador no soporta la etiqueta de vídeo.
				</video>
			</article>
		</section>
		<section>
			<?php
				if(isset($_SESSION['usuario'])){ // Si existe la variable significa que ya has iniciado sesión, te llevará directamente a la pagina de generacion de CV.
					echo '
					<article class="contenedor_boton">
						<a class="boton" href="generacion.php">Empezar ahora</a>
					</article>
					';
				}
				else{ 							// De lo contrario, te llevará a iniciar la sesión.
					echo '
					<article class="contenedor_boton"> 
						<a class="boton" href="inicio_sesion.php">Empezar ahora</a>
					</article>
					';
				}
			?>
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