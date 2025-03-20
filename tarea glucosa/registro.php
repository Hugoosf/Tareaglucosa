<?php

require_once('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $correo = htmlspecialchars($_POST['correo']);
    $fechanac = $_POST['fechanac'];
    $contrasena = $_POST['contrasena'];

   
    $hashed_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

  
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidos, correo, fechanac, contrasena) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $apellidos, $correo, $fechanac, $hashed_contrasena);

   
    if ($stmt->execute()) {
        header("Location: login.php"); 
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

   
    $stmt->close();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <form method="POST" action="">
    <h2>Regístrate</h2>

        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellidos">Apellidos:</label><br>
        <input type="text" id="apellidos" name="apellidos" required><br><br>

        <label for="correo">Nombre de usuario:</label><br>
        <input type="text" id="correo" name="correo" required><br><br>

        <label for="fechanac">Fecha de nacimiento:</label><br>
        <input type="date" id="fechanac" name="fechanac" required><br><br>

        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena" required><br><br>

        <input type="submit" value="Registrarme">
        <p class="mensaje-registro">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </form>
   
</body>
</html>

