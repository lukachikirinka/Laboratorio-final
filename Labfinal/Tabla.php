<!DOCTYPE html>
<html>
<head>
    <title> Registro </title>
    <link href=estilo.css rel='stylesheet' type='text/CSS'>
</head>
<body>

<?php
    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Labfinal";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['primer_apellido'];
    $apellido2 = $_POST['segundo_apellido'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Validar los datos del formulario
    if (empty($nombre) || empty($apellido1) || empty($apellido2) || empty($email) || empty($login) || empty($password)) {
        echo "Por favor, rellene todos los campos.";
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo "<div class='container'>El email ingresado no es válido. Por favor, vuelve a intentarlo.</div>";
        exit;
    } elseif (strlen($password) < 4 || strlen($password) > 8) {
        echo "<div class='container'>La contraseña debe tener entre 4 y 8 caracteres. Por favor, vuelve a intentarlo.</div>";
        exit;
    }

        // Verificar si el email ya está registrado en la base de datos
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='container'>El email ingresado ya está registrado. Por favor, vuelve a intentarlo.</div>";
            exit;
        }
        
    // Insertar los datos en la base de datos
    $sql = "INSERT INTO usuarios (nombre, primer_apellido, segundo_apellido, email, login, password) VALUES ('$nombre', '$apellido1', '$apellido2', '$email', '$login', '$password')";

    if ($conn->query($sql) === true) {
        echo "<div class='container'>Registro completado con éxito.</div>";
    } else {
        echo "<div class='container'>Error al registrar los datos: " . $conn->error. "</div>";
    }

$conn->close();
?>
</body>
</html>
