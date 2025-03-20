<?php
session_start(); 


include('conexion.php'); 


if (!isset($_SESSION['idusuario'])) {
    die("No has iniciado sesión.");
}

$idusuario = $_SESSION['idusuario'];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fecha'])) {
    $fecha = $_POST['fecha'];

  
    $sql = "
        SELECT 
            c.lenta, c.deporte, 
            m.idcomida, m.gl1h, m.rac, m.insu, m.glh2, 
            h.glu AS glu_hiper, h.hora AS hora_hiper, h.corr, 
            i.glu AS glu_hipo, i.hora AS hora_hipo
        FROM 
            controlglu c
        LEFT JOIN comidas m ON c.idusuario = m.idusuario AND c.fecha = m.fecha
        LEFT JOIN hiper h ON c.idusuario = h.idusuario AND c.fecha = h.fecha AND m.idcomida = h.idcomida
        LEFT JOIN hipo i ON c.idusuario = i.idusuario AND c.fecha = i.fecha AND m.idcomida = i.idcomida
        WHERE c.fecha = ? AND c.idusuario = ?
    ";

   
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $fecha, $idusuario); 
        $stmt->execute();
        $result = $stmt->get_result();
        echo "<h1>Registro seleccionado</h1>";
       
        if ($result->num_rows > 0) {
           
            while ($row = $result->fetch_assoc()) {
                echo "<p><strong>Fecha:</strong> " . $fecha . "</p>";
                echo "<p><strong>Lenta:</strong> " . $row['lenta'] . " unidades</p>";
                echo "<p><strong>Deporte:</strong> " . $row['deporte'] . "</p>";
                echo "<p><strong>Tipo de comida:</strong> " . $row['idcomida'] . "</p>";
                echo "<p><strong>GL/1H:</strong> " . $row['gl1h'] . " mg/dL</p>";
                echo "<p><strong>Raciones:</strong> " . $row['rac'] . "</p>";
                echo "<p><strong>Insulina:</strong> " . $row['insu'] . " unidades</p>";
                echo "<p><strong>GL/H2:</strong> " . $row['glh2'] . " mg/dL</p>";
                echo "<p><strong>Glu. Hiper:</strong> " . $row['glu_hiper'] . " mg/dL</p>";
                echo "<p><strong>Hora Hiper:</strong> " . $row['hora_hiper'] . "h</p>";
                echo "<p><strong>Corr. Hiper:</strong> " . $row['corr'] . " unidades</p>";
                echo "<p><strong>Glu. Hipo:</strong> " . $row['glu_hipo'] . " mg/dL</p>";
                echo "<p><strong>Hora Hipo:</strong> " . $row['hora_hipo'] . "h</p>";
                echo "<hr>";
            }
        } else {
            echo "<p>No se encontraron resultados para esa fecha.</p>";
        }

        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    $conn->close();
} else {
  
    


?>
<h1>Selecciona la fecha del registro que quieras visualizar</h1>
<form method="POST" action="">
    <label for="fecha">Fecha:</label>
    <input type="date" id="fecha" name="fecha" required>
    <input type="submit" value="Buscar">
</form>
<?php
}

?>
