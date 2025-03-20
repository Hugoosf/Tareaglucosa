<?php
session_start();

if (!isset($_SESSION['idusuario'])) {
    die("No has iniciado sesión.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'conexion.php'; 

    
    $fecha = $_POST['fecha'];

    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $idusuario = $_SESSION['idusuario'];

    
    $sql_controlglu = "SELECT * FROM controlglu WHERE idusuario = ? AND fecha = ?";
    $stmt = $conn->prepare($sql_controlglu);
    $stmt->bind_param("ss", $idusuario, $fecha);
    $stmt->execute();
    $result_controlglu = $stmt->get_result();

    
    $sql_comidas = "SELECT * FROM comidas WHERE idusuario = ? AND fecha = ?";
    $stmt = $conn->prepare($sql_comidas);
    $stmt->bind_param("ss", $idusuario, $fecha);
    $stmt->execute();
    $result_comidas = $stmt->get_result();

    
    $sql_hipo = "SELECT * FROM hipo WHERE idusuario = ? AND fecha = ?";
    $stmt = $conn->prepare($sql_hipo);
    $stmt->bind_param("ss", $idusuario, $fecha);
    $stmt->execute();
    $result_hipo = $stmt->get_result();

    
    $sql_hiper = "SELECT * FROM hiper WHERE idusuario = ? AND fecha = ?";
    $stmt = $conn->prepare($sql_hiper);
    $stmt->bind_param("ss", $idusuario, $fecha);
    $stmt->execute();
    $result_hiper = $stmt->get_result();

    
    $stmt->close();
    $conn->close();
} 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Datos de Alimentación</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>



<form action="#" method="post">
<h2>Ingresa la fecha de los datos que deseas visualizar</h2>
    <label for="fecha">Fecha:</label>
    <input type="date" id="fecha" name="fecha" required><br><br>
    <button type="submit">Buscar</button>
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($result_controlglu->num_rows > 0) {
        echo "<div class=\"tabli\">";
        echo "<h3>Datos de Control de Glucosa</h3>";
        echo "<table>";
        echo "<tr><th>Fecha</th><th>Lenta</th><th>Deporte</th></tr>";
        while ($row = $result_controlglu->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['fecha'] . "</td>";
            echo "<td>" . $row['lenta'] . " uds</td>";
            echo "<td>" . $row['deporte'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    if ($result_comidas->num_rows > 0) {
        echo "<div class=\"tabli\">";
        echo "<h3>Datos de Comidas</h3>";
        echo "<table>";
        echo "<tr><th>Comida</th><th>GL/H1</th><th>RAC</th><th>INSU</th><th>GL/H2</th></tr>";
        while ($row = $result_comidas->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['idcomida'] . "</td>";
            echo "<td>" . $row['gl1h'] . " mg/dL</td>";
            echo "<td>" . $row['rac'] . " raciones</td>";
            echo "<td>" . $row['insu'] . " uds</td>";
            echo "<td>" . $row['glh2'] . " mg/dL</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    if ($result_hipo->num_rows > 0) {
        echo "<div class=\"tabli\">";
        echo "<h3>Datos de Hipo</h3>";
        echo "<table>";
        echo "<tr><th>Comida</th><th>GLU</th><th>Hora</th></tr>";
        while ($row = $result_hipo->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['idcomida'] . "</td>";
            echo "<td>" . $row['glu'] . " mg/dL</td>";
            echo "<td>" . $row['hora'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    if ($result_hiper->num_rows > 0) {
        echo "<div class=\"tabli\">";
        echo "<h3>Datos de Hiper</h3>";
        echo "<table>";
        echo "<tr><th>Comida</th><th>GLU</th><th>Hora</th><th>CORR</th></tr>";
        while ($row = $result_hiper->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['idcomida'] . "</td>";
            echo "<td>" . $row['glu'] . " mg/dL</td>";
            echo "<td>" . $row['hora'] . "</td>";
            echo "<td>" . $row['corr'] . " uds</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    
    if ($result_controlglu->num_rows == 0 && $result_comidas->num_rows == 0 && $result_hipo->num_rows == 0 && $result_hiper->num_rows == 0) {
        echo "<br>No se encontraron datos para la fecha seleccionada.";
    }
}
?>

</body>
</html>

