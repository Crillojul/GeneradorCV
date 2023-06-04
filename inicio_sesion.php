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

    <link rel="stylesheet" type="text/css" href="css/inicio_sesion.css">

    <title>Generador CV</title>

    <?php 
		if (empty($_GET['error'])){
			$_GET['error'] = null;
		}
	?>
    <style>
		.error_user{
			display:
					<?php
						if($_GET['error'] != "user"){
							echo "none";
						}
						else{
							echo "";
						}
					?>
		}
		.error_pass{
			display:
					<?php
						if($_GET['error'] != "pass"){
							echo "none";
						}
						else{
							echo "";
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
        <section id="section_form">
            <form class="esp sesion_off" action="./cuenta.php" method="post">
                <legend>
                    <b>Inicio de sesión</b>
                </legend>
                <input class="recuadro_input" type="text" id="usuario" pattern="[a-zA-Z0-9!#$%&'*_+-]{3,20}" name="usuario" autocomplete="on" placeholder="Usuario" required autofocus><br>
                <input class="recuadro_input" type="password" id="password" pattern="[a-zA-Z0-9!#$%&'*_+-]{6,20}" name="contrasenya" placeholder="Contraseña" required><br>
				<p class="error_user">El usuario indicado no existe.</p>
				<p class="error_pass">La contraseña indicada es incorrecta.</p>
				<br>
				<label>Si aún no está registrado: <a href="registro_usuario.php">Nuevo usuario</a></label><br><br>
                <input type="submit" name="enviar" value="Iniciar sesión">
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