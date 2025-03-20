<?php
session_start(); 

require_once('conexion.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = htmlspecialchars($_POST['correo']);
    $contrasena = $_POST['contrasena'];

   
    $stmt = $conn->prepare("SELECT idusuario, contrasena FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);

  
    $stmt->execute();
    $stmt->store_result();

   
    if ($stmt->num_rows > 0) {
       
        $stmt->bind_result($idusuario, $hashed_contrasena);

        
        $stmt->fetch();

     
        if (password_verify($contrasena, $hashed_contrasena)) {
        
            $_SESSION['idusuario'] = $idusuario;
            header("Location: eleccion.php"); 
            exit;
        } else {
          
            $error = "Contraseña incorrecta.";
        }
    } else {
      
        $error = "El correo electrónico no está registrado.";
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
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <form method="POST" action="">
    <h2>Inicio de Sesión</h2>
        <label for="correo">Correo electrónico:</label><br>
        <input type="text" id="correo" name="correo" required><br><br>

        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena" required><br><br>

        <input type="submit" value="Iniciar sesión">

        <p class="mensaje-registro">¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>
        <?php
    if (!empty($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>

    </form>

    
</body>
</html>




