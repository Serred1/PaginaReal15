<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/demoalert.js"></script>
</head>

<body>
    <div id="alert-container"></div>
    <?php
    session_start();
    $alertMessage = '';
    $alertType = '';
    if (!empty($_POST["btningresar"])) {
        if (empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["password"])) {
            $alertMessage = 'Llene todos los campos';
            $alertType = 'error';
        } else {
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $clave = $_POST["password"];
            $sql = $conexion->query("select * from administrador where clave_ad='$clave'");
            if ($user = $sql->fetch_object()) {
                $sql = $conexion->query("select * from usuarios where nombre='$nombre' and apellido='$apellido'");
                if ($datos = $sql->fetch_object()) {
                    $_SESSION["nombre"] = $nombre;
                    $_SESSION["apellido"] = $apellido;
                    $_SESSION["usuario_id"] = $datos->id;
                    $_SESSION["hora_conexion"] = date("Y-m-d H:i:s");
                    header("location:inicio/index.php");
                    // ... Después de una autenticación exitosa ...
                    $fecha_hora_actual = date("Y-m-d H:i:s");
                    $sql = "UPDATE usuarios SET ultima_conexion = '$fecha_hora_actual' WHERE nombre='$nombre' AND apellido='$apellido'";
                    $conexion->query($sql);
                    $usuario_id = $datos->id;
                    $sql = "INSERT INTO conexiones (usuario_id, fecha_conexion) VALUES ('$usuario_id', '$fecha_hora_actual') ";
                    $conexion->query($sql);
                } else {
                    $alertMessage = 'Debe Registrarse Primero';
                    $alertType = 'error';
                }
            } else {
                $nombre = $_POST["nombre"];
                $apellido = $_POST["apellido"];
                $clave = $_POST["password"];
                $sql = $conexion->query("select * from estudiante where clave_es='$clave'");
                if ($user = $sql->fetch_object()) {
                    $sql = $conexion->query("select * from usuarios where nombre='$nombre' and apellido='$apellido'");
                    if ($datos = $sql->fetch_object()) {
                        $_SESSION["nombre"] = $nombre;
                        $_SESSION["apellido"] = $apellido;
                        $_SESSION["usuario_id"] = $datos->id;
                        $_SESSION["hora_conexion"] = date("Y-m-d H:i:s");
                        header("location:inicio/inicio_Es.php");
                        // ... Después de una autenticación exitosa ...
                        $fecha_hora_actual = date("Y-m-d H:i:s");
                        $sql = "UPDATE usuarios SET ultima_conexion = '$fecha_hora_actual' WHERE nombre='$nombre' AND apellido='$apellido'";
                        $conexion->query($sql);
                        $usuario_id = $datos->id;
                        $sql = "INSERT INTO conexiones (usuario_id, fecha_conexion) VALUES ('$usuario_id', '$fecha_hora_actual') ";
                        $conexion->query($sql);
                    } else {
                        $alertMessage = 'Debe registrarse primero';
                        $alertType = 'error';
                    }
                } else {
                    $alertMessage = 'La clave ingresa es incorrecta';
                    $alertType = 'error';
                }
            }
        }
    }
    if (!empty($_POST["btnregistrar"])) {
        if (empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["password"])) {
            $alertMessage = 'Llene todos los campos';
            $alertType = 'error';
        } else {
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $clave = $_POST["password"];
            $sql = $conexion->query("SELECT * FROM usuarios WHERE nombre='$nombre' AND apellido='$apellido'");
            if ($datos = $sql->fetch_object()) {
                $alertMessage = 'Ya existe este usuario ingrese otro apellido';
                $alertType = 'error';
            } else {
                $sql = $conexion->query("select * from administrador where clave_ad='$clave'");
                if ($user=$sql->fetch_object()) {
                    $sql = $conexion->query("INSERT INTO usuarios(nombre, apellido)VALUES('$nombre','$apellido')");
                    if ($sql == 1) {
                        $alertMessage = 'Guardado Exitoso';
                        $alertType = 'success';
                    } else {
                        $alertMessage = 'Fallo al Guardar';
                        $alertType = 'error';
                    }
                } else{
                    $nombre = $_POST["nombre"];
                    $apellido = $_POST["apellido"];
                    $clave = $_POST["password"];
                    $sql=$conexion->query("select * from estudiante where clave_es='$clave'");
                    if ($user=$sql->fetch_object()) {
                        $sql = $conexion->query("INSERT INTO usuarios(nombre, apellido)VALUES('$nombre','$apellido')");
                        if ($sql == 1) {
                            $alertMessage = 'Guardado Exitoso';
                            $alertType = 'success';
                        } else {
                            $alertMessage = 'Fallo al Guardar';
                            $alertType = 'error';
                        }

                }else{
                    $alertMessage = 'La contraseña ingresada no es valida';
                    $alertType = 'error';
                }
                
            }
        }
    }
}

    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (!empty($alertMessage)) : ?>
                Swal.fire({
                    title: '<?php echo $alertMessage; ?>',
                    icon: '<?php echo $alertType; ?>',
                });
            <?php endif; ?>
        });
    </script>
</body>

</html>