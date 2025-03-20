<?php
session_start();
include('conexion.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];

    
    if (isset($_SESSION['idusuario'])) {
        $idusuario = $_SESSION['idusuario'];

       
        $query = "SELECT idcomida, glu, hora, corr FROM hiper WHERE fecha = ? AND idusuario = ?";
        $stmt = $conn->prepare($query); 
        $stmt->bind_param("si", $fecha, $idusuario);
        $stmt->execute();
        $result = $stmt->get_result();
        echo "<h1>Registro seleccionado</h1>";
        
        if ($result->num_rows > 0) {
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr><th>TIPO DE COMIDA</th><th>GLU</th><th>HORA</th><th>CORR</th><th>GRÁFICO GLU</th></tr>';
            echo '</thead>';
            echo '<tbody>';

           
            while ($row = $result->fetch_assoc()) {
                $idcomida = $row['idcomida'];
                $glu = $row['glu'];
                $hora = $row['hora'];
                $corr = $row['corr'];

                
                $barra = '<div style="width: ' . ($glu / 3) . '%; height: 20px; background-color:rgb(204, 216, 35);"></div>';

                echo '<tr>';
                echo '<td>' . htmlspecialchars($idcomida) . '</td>'; 
                echo '<td>' . htmlspecialchars($glu) . ' mg/dL</td>';
                echo '<td>' . htmlspecialchars($hora) . 'h</td>';
                echo '<td>' . htmlspecialchars($corr) . 'uds</td>';
                echo '<td>' . $barra . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'No se encontraron resultados para la fecha seleccionada.';
        }

        $stmt->close();
    } else {
        echo 'No hay usuario autenticado en la sesión.';
    }
} else {
    echo "<h1>Selecciona la fecha del registro para ver los datos de hiperglucemia</h1>";
    echo '<form method="POST" action="">';
    echo 'Fecha: <input type="date" name="fecha" required>';
    echo '<input type="submit" value="Consultar">';
    echo '</form>';
}
?>
