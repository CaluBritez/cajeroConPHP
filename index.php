<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP-PHP</title>
</head>
<body>

    <h1>Bienvenido a tu cajero automatico</h1>

    <?php
    $usuarioCorrecto = false;
    $saldo = 1000000; // Saldo inicial

    // Verificamos cuando se cierra la sesión
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
        $usuarioCorrecto = false;
        echo "<p>Sesión cerrada. Vuelve a iniciar sesión.</p>";
    }

    // Verificamos el formulario de login
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        // Validamos usuario y contraseña
        if($usuario == "admin" && $password == "1234"){
            echo "<p>Acceso permitido</p>";
            $usuarioCorrecto = true;
        } else {
            echo "<p>El pin es incorrecto</p>";
        }
    }

    // Manejamos los ingresos y egresos del cajero
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ingreso_egreso'])) {
        // Verificamos ingresos
        if (!empty($_POST['ingresos'])) {
            $saldo += $_POST['ingresos'];
        }

        // Verificamos egresos
        if (!empty($_POST['egresos'])) {
            $saldo -= $_POST['egresos'];
        }

        echo "<p>Saldo actualizado: $$saldo</p>";
        $usuarioCorrecto = true;
    }

    // Mostramos los inputs correspondientes dependiendo si el usuario esta logueado
    if (!$usuarioCorrecto) {
    ?>

        <!-- Formulario para ingresar usuario y contraseña -->
        <form method="post" action="">
            <input type="text" name="usuario" placeholder="Usuario">
            <input type="password" name="password" placeholder="Contraseña">
            <button type="submit" name="login">Enviar</button>
        </form>

    <?php
    } else {
    ?>

        <!-- Formulario para ingresos y egresos -->
        <?php
        echo "<p>Saldo: $$saldo</p>"
        ?>
        <form method="post" action="">
            <input type="number" name="ingresos" placeholder="Depositar">
            <input type="number" name="egresos" placeholder="Extraer">
            <button type="submit" name="ingreso_egreso">Realizar Operación</button>
        </form>

        <!-- Botón para cerrar sesión -->
        <form method="post" action="">
            <button type="submit" name="logout" style="margin-top: 10px;">Cerrar sesión</button>
        </form>

    <?php
    }
    ?>

</body>
</html>
