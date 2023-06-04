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

    <link rel="stylesheet" type="text/css" href="css/cuenta.css">

    <title>Generador CV</title>

    <?php
        if (isset($_POST['enviar'])){
            $usuario = $_POST['usuario'];
            $contrasenya = $_POST['contrasenya'];
        }

        // comprobar usuario
		if (isset($_SESSION['usuario'])){
            // en este caso, el usuario a vuelto a cuenta.php, por lo tanto no quiero que se ejecute la comprobacion del usuario
            $usuario_nodo = "true";
            $contrasenya_nodo = "true";
        }
        else{
            // vamos a comprobar si el xml con los datos existe y luego comienza la comprobacion del usuario
            if (file_exists('xml/datos.xml')){
                $datos_xml = new DOMDocument();
                $datos_xml->load('xml/datos.xml');
                // Si el usuario se llama 'root' comprobaremos los datos del root
                if ($usuario == 'root'){
                    $usuario_nodo = "true";
                    $contrasenya_root = $datos_xml->getElementsByTagName('pass')->item(0)->nodeValue;
                    if ($contrasenya == $contrasenya_root){
                        $contrasenya_nodo = "true";
                        $_SESSION['nombre'] = $datos_xml->getElementsByTagName('nombre')->item(0)->nodeValue;
                        $_SESSION['apellidos'] = $datos_xml->getElementsByTagName('apellidos')->item(0)->nodeValue;
                        $_SESSION['correo'] = $datos_xml->getElementsByTagName('mail')->item(0)->nodeValue;
                        $_SESSION['usuario'] = $datos_xml->getElementsByTagName('user')->item(0)->nodeValue;
                        $_SESSION['contrasenya'] = $datos_xml->getElementsByTagName('pass')->item(0)->nodeValue;
                    }
                    else {
                        $contrasenya_nodo = "false";
                    }
                }// Si no se llama root, comprobaremos los datos del resto de cuentas
                else {
                    $cantidad_cuentas = $datos_xml->getElementsByTagName('cuenta')->length;
                    for($i = 1; $i < $cantidad_cuentas; $i++){
                        $usuario_actual = $datos_xml->getElementsByTagName('user')->item($i)->nodeValue;
                        if ($usuario == $usuario_actual){
                            $usuario_nodo = "true";
                            $contrasenya_actual = $datos_xml->getElementsByTagName('pass')->item($i)->nodeValue;
                            if ($contrasenya == $contrasenya_actual){
                                $contrasenya_nodo = "true";
                                $_SESSION['nombre'] = $datos_xml->getElementsByTagName('nombre')->item($i)->nodeValue;
                                $_SESSION['apellidos'] = $datos_xml->getElementsByTagName('apellidos')->item($i)->nodeValue;
                                $_SESSION['correo'] = $datos_xml->getElementsByTagName('mail')->item($i)->nodeValue;
                                $_SESSION['usuario'] = $datos_xml->getElementsByTagName('user')->item($i)->nodeValue;
                                $_SESSION['contrasenya'] = $datos_xml->getElementsByTagName('pass')->item($i)->nodeValue;
                                $_SESSION['id'] = $datos_xml->getElementsByTagName('cuenta')->item($i)->getAttribute('id');
                                break;
                            }
                            else {
                                $contrasenya_nodo = "false";
                                break;
                            }
                            }
                        else{
                            continue;
                        }
                        }
                // Si el usuario no ha coincidido en ningun momento pasa a ser 'false' para que se ejecute la accion que toque
                    if ($usuario_nodo == "true"){
                        $usuario_nodo = "true";
                    }
                    else{
                        $usuario_nodo = "false";
                    }
                }
            }
            else {
                exit('Error abriendo datos.xml.');
            }
        }
        // Acciones en caso de que no coincida el usuario o la contraseña
        if ($usuario_nodo == "false"){
            echo "
                <script>
                        window.location.href = 'inicio_sesion.php?error=user';
                </script>
            ";
        }
        if ($contrasenya_nodo == "false"){
            echo "
                <script>
                        window.location.href = 'inicio_sesion.php?error=pass';
                </script>
            ";
        }

	?>
    <style>
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
        <aside class="no_root">
            <article>
                <img src="./archivos/avatar.png" alt="avatar del usuario">
            </article>
            <p><b>Opciones</b></p>
            <article>
                <a href="#mod_datos">Modificar datos</a>
                <a href="#cer_sesion">Cerrar sesión</a>
                <a href="#eli_cuenta" style="color: red">Eliminar cuenta</a>
            </article>
        </aside>
        <section class="no_root">
            <p><b>DATOS PERSONALES</b></p>
            <article>
                <table>
                    <tr>
                        <th><b>Nombre </b></th>
                        <td><?php
                            echo "{$_SESSION['nombre']} {$_SESSION['apellidos']}";
                        ?></td>
                    </tr>
                    <tr>
                        <th><b>Correo electrónico</b></th>
                        <td><?php
                            echo $_SESSION['correo'];
                        ?></td>
                    </tr>
                    <tr>
                        <th><b>Usuario</b></th>
                        <td><?php
                            echo $_SESSION['usuario'];
                        ?></td>
                    </tr>
                </table>
            </article>
            <p><b>OPCIONES</b></p>
            <article>
                <p class="opcion" id="mod_datos">Modificas datos</p>
                <form action="procesos.php" method="post">
                    <label>Nombre:</label>
                    <input type="text" pattern="[a-zA-ZÀ-ÿ\u00f1\u00d1 ]{2,60}" name="nombre" value="<?php echo $_SESSION['nombre'] ?>" required><br>
                    <label>Apellidos:</label>
                    <input type="text" pattern="[a-zA-ZÀ-ÿ\u00f1\u00d1 ]{2,150}" name="apellidos" value="<?php echo $_SESSION['apellidos'] ?>"><br>
                    <label>Correo electrócico:</label>
                    <input type="email" pattern="[a-zA-Z0-9!#$%&'*_+-]([\.]?[a-zA-Z0-9!#$%&'*_+-])+@[a-zA-Z0-9]([^@&%$\/()=?¿!.,:;]|\d)+[a-zA-Z0-9][\.][a-zA-Z]{2,4}([\.][a-zA-Z]{2})?" name="correo" value="<?php echo $_SESSION['correo'] ?>" required><br>
                    <?php $pass_oculta = str_repeat("*", strlen($_SESSION['contrasenya'])) ?>
                    <label>Contraseña actual:</label>
                    <input type="text" pattern="[a-zA-Z0-9!#$%&'*_+-]{8,20}" name="actual_contrasenya" value="<?php  echo $pass_oculta ?>" disabled><br>
                    <label>Nueva contraseña:</label>
                    <input type="password" pattern="[a-zA-Z0-9!#$%&'*_+-]{8,20}" name="nueva_contrasenya"><br><br>
                    <input class="boton" type="submit" name="modificar" value="Modificar datos" style="margin-left: 40%">
				</form>
            </article>
            <article>
                <p class="opcion" id="cer_sesion">Cerrar sesión</p>
                <p>¿Estás seguro de que quieres eliminar la cuenta?</p>
                <a class="boton" href="index.php?sesion=logout" style="margin-left: 40%">Cerrar sesión</a>
            </article>
            <article>
                <p class="opcion" id="eli_cuenta">Eliminar cuenta</p>
                <p>¿Estás seguro de que quieres eliminar la cuenta?</p>
                <a class="boton rojo" href="procesos.php?eli_cuenta=on" style="margin-left: 35%">Sí, eliminar cuenta</a>
                <a class="boton" href="#cuenta.php#inicio">No</a>
            </article>
        </section>
        <aside class="root">
            <article>
                <img src="./archivos/avatar.png" alt="avatar del usuario">
            <p><b>Opciones</b></p>
            <article>
                <a href="#lista_usuarios">Listar usuarios</a>
                <a href="#eli_usuarios">Borrar usuarios</a>
                <a href="#cer_sesion">Cerrar sesión</a>
                <a href="#eli_cuenta" style="color: red">Eliminar cuenta</a>
            </article>
        </aside>
        <section class="root">
            <p><b>DATOS PERSONALES</b></p>
            <article>
                <table>
                    <tr>
                        <th><b>Nombre </b></th>
                        <td><?php
                            echo "{$_SESSION['nombre']} {$_SESSION['apellidos']}";
                        ?></td>
                    </tr>
                    <tr>
                        <th><b>Correo electrónico</b></th>
                        <td><?php
                            echo $_SESSION['correo'];
                        ?></td>
                    </tr>
                    <tr>
                        <th><b>Usuario</b></th>
                        <td><?php
                            echo $_SESSION['usuario'];
                        ?></td>
                    </tr>
                </table>
            </article>
            <article>
                <p class="opcion" id="lista_usuarios">Listar usuarios</p>
                <?php
                    $doc = new DOMDocument;
                    $doc->load("xml/datos.xml");
                    $xpath = new DOMXpath($doc);

                    $nodos_cuenta = $xpath->query("/generadorcv/usuariado/cuenta");
                    $cantidad_cuentas = count($nodos_cuenta);
                    for($i = 1; $i < $cantidad_cuentas; $i++){
                        $usuarios = $xpath->query("/generadorcv/usuariado/cuenta/user");
                        $usuario_actual = $usuarios->item($i)->nodeValue;
                        $nombres = $xpath->query("/generadorcv/usuariado/cuenta/nombre");
                        $nombre_actual = $nombres->item($i)->nodeValue;
                        $apellidos = $xpath->query("/generadorcv/usuariado/cuenta/apellidos");
                        $apellidos_actual = $apellidos->item($i)->nodeValue;
                        echo "<p>- <b>Usuario:</b> $usuario_actual - <b>Nombre:</b> $nombre_actual $apellidos_actual.</p>";
                    }
                ?>
            </article>
            <article>
                <p class="opcion" id="lista_usuarios">Borrar usuario</p>
                <form id="eli_usuarios" action="procesos.php" method="post">
                    <select id="eli_usuario" name="eli_usuario">
                        <option value="ninguno">Ninguno</option>
                        <?php // creamos un bucle que cree todas las opciones disponibles
                            $doc = new DOMDocument();
                            $doc->load('xml/datos.xml');
                            $xpath = new DOMXpath($doc);
    
                            $nodos_cuenta = $xpath->query("/generadorcv/usuariado/cuenta");
                            $cantidad_cuentas = count($nodos_cuenta);
                            for($i = 1; $i < $cantidad_cuentas; $i++){
                                $usuarios = $xpath->query("/generadorcv/usuariado/cuenta/user");
                                $usuario_actual = $usuarios->item($i)->nodeValue;
                                echo "<option value='$usuario_actual'>$usuario_actual</option>";
                            }
                        ?>
                    </select>
                    <input type="submit" name="eliminar_usuario" value="Borrar">
                </form>
            </article>
            <article>
                <p class="opcion" id="cer_sesion">Cerrar sesión</p>
                <p>¿Estás seguro de que quieres eliminar la cuenta?</p>
                <a class="boton" href="index.php?sesion=logout" style="margin-left: 40%">Cerrar sesión</a>
            </article>
            <article>
                <p class="opcion" id="eli_cuenta">Eliminar cuenta</p>
                <p>¿Estás seguro de que quieres eliminar la cuenta?</p>
                <a class="boton rojo" href="procesos.php?eli_cuenta=on" style="margin-left: 35%">Sí, eliminar cuenta</a>
                <a class="boton" href="#cuenta.php#inicio">No</a>
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