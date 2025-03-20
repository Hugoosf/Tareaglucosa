<?php

session_start();


include('conexion.php');  


if (!isset($_SESSION['idusuario'])) {
    die("No se ha encontrado el id de usuario en la sesión. Inicia sesión primero.");
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar registros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <form action="" method="POST">
    <h2>Selecciona la fecha del registro que quieras borrar</h2>
        <label for="fecha">Fecha: </label>
        <input type="date" id="fecha" name="fecha" required><br><br>
        
        <button type="submit">Borrar registro</button>
        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
        $fecha = $_POST['fecha'];
    
        
        $idusuario = $_SESSION['idusuario'];
    
        
        $sql = "DELETE FROM controlglu WHERE fecha = ? AND idusuario = ?";
    
        
        if ($stmt = $conn->prepare($sql)) {
           
            $stmt->bind_param("si", $fecha, $idusuario);
    
            
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo "<br>El registro se ha eliminado correctamente";
                } else {
                    echo "No se encontraron registros que coincidan con la fecha proporcionada.";
                }
            } else {
                echo "Error al ejecutar la consulta: " . $stmt->error;
            }
    
            
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }
    }
    ?>
    </form>

</body>
</html>


