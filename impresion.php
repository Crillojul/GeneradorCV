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

    <link rel="stylesheet" type="text/css" href="css/impresion.css">

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
                <p id="titulo_articulo">Mis curriculums</p>
                <div id="contenedor_CVs">
                    <?php
                        $doc = new DOMDocument;
                        $doc->load("xml/datos.xml");
                        $xpath = new DOMXpath($doc);

                        $usuario = $_SESSION['usuario'];
                        $nodo_id = $xpath->query("/generadorcv/usuariado/cuenta[user='$usuario']/@id");
                        $id = $nodo_id->item(0)->value;

                        $nodos_curriculum = $xpath->query("/generadorcv/curriculums/CV[@cuenta=$id]");
                        $cantidad_CVs = count($nodos_curriculum);
                        for($i = 0; $i < $cantidad_CVs; $i++){
                            $titulos_CV = $xpath->query("/generadorcv/curriculums/CV[@cuenta=$id]/titulo");
                            $titulo = $titulos_CV->item($i)->nodeValue; /*Saco cada titulo de cada CV para el enlace*/
                            $ids_CV = $xpath->query("/generadorcv/curriculums/CV[@cuenta=$id]/@id");
                            $id_CV = $ids_CV->item($i)->value; /*Saco cada id del CV para poder mandarlo en metodo GET*/
							// Quiero generar un color random para el contenedor de cada curriculum
							$r = mt_rand( 128, 255 );
							$g = mt_rand( 128, 255 );
							$b = mt_rand( 128, 255 );
							$color_random = 'rgba('.$r.','.$g.','.$b.')';
							// imprimo el div con el link de cada curriculum del actual usuario
                        	echo "
								<div class='div_link' style='background-color: $color_random;'>
									<a class='link_cv' href='curriculum.php?impcv=$id_CV'>
										$titulo
									</a>
									<a class='botonBorrar' href='imp_procesos.php?delcv=$id_CV'>
										X
									</a>
								</div>
								";
                        }
                    ?>
                </div>
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