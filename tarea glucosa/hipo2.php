
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Consulta de GLU</title>
    </head>
    <link rel="stylesheet" href="style.css">
    <body>
        
    <?php
session_start();
include('conexion.php');


if (!isset($_SESSION['idusuario'])) {
    die("No estás autenticado. Inicia sesión primero.");
}

$idusuario = $_SESSION['idusuario'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $mes = $_POST['mes'];

    
    $meses = [
        'enero' => '01',
        'febrero' => '02',
        'marzo' => '03',
        'abril' => '04',
        'mayo' => '05',
        'junio' => '06',
        'julio' => '07',
        'agosto' => '08',
        'septiembre' => '09',
        'octubre' => '10',
        'noviembre' => '11',
        'diciembre' => '12',
       
    ];
    if (!isset($meses[$mes])) {
        die("Mes no válido.");
    }
    $mes_num = $meses[$mes];

    
    $sql = "SELECT glu, fecha, idcomida FROM hipo WHERE idusuario = ? AND MONTH(fecha) = ?";

    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $idusuario, $mes_num);
    $stmt->execute();
    $stmt->bind_result($glu, $fecha, $idcomida);

    
    $glus = [];
    $total_glu = 0;
    while ($stmt->fetch()) {
        $glus[] = ['glu' => $glu, 'fecha' => $fecha, 'idcomida' => $idcomida];
        $total_glu += $glu;
    }

   
    if (count($glus) == 0) {
        echo "No se encontraron registros para este usuario y mes.";
        exit();
    }

    
    $porcentajes = [];
    $dias = [];
    $tipos_comida = []; 
    foreach ($glus as $registro) {
        
        $fecha = $registro['fecha'];
        $dia = date('d', strtotime($fecha)); 

        
        $glu = $registro['glu'];

        
        $porcentaje = ($glu / $total_glu) * 100;

        
        $dias[] = $dia;
        $porcentajes[] = round($porcentaje, 2);
        $tipos_comida[] = $registro['idcomida']; 
    }

   
    function generarColorAleatorio() {
        return '#' . dechex(rand(0x000000, 0xFFFFFF));
    }

    
    $colores = array_map(function() { return generarColorAleatorio(); }, $porcentajes);

    echo "<div class=\"e\">";
    echo "<div class=\"esta\">";
    echo "<h3>Resultados para el mes de $mes:</h3>";
    echo "<table border='1'>
            <tr>
                <th>Día</th>
                <th>Tipo de comida</th>
                <th>GLU</th>
                <th>Porcentaje</th>
                
            </tr>";

    foreach ($glus as $registro) {
        
        $fecha = $registro['fecha'];
        $dia = date('d', strtotime($fecha)); 

        
        $glu = $registro['glu'];

        
        $porcentaje = ($glu / $total_glu) * 100;

        
        $idcomida = $registro['idcomida'];

       
        echo "<tr>
                <td>$dia</td>
                <td>$idcomida</td>  <!-- Mostrar el tipo de comida -->
                <td>$glu</td>
                <td>" . round($porcentaje, 2) . "%</td>
              </tr>";
    }

    echo "</table>";
    echo "</div>";

    echo "<div class=\"est\">";
    echo "<h3>Gráfico Circular de GLU por Día:</h3>";
    echo "<canvas id='graficoCircular' width='150' height='150' style='max-width: 150px; max-height: 150px;'></canvas>";  // Tamaño pequeño
    echo "<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>";
    echo "<script>
        var ctx = document.getElementById('graficoCircular').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: " . json_encode($dias) . ",
                datasets: [{
                    data: " . json_encode($porcentajes) . ",
                    backgroundColor: " . json_encode($colores) . ",
                    borderColor: 'black',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>";
    echo "</div>";
    echo "</div>";
    $stmt->close();
    $conn->close();
} else {
   
    ?>
        <form action="" method="POST">
        <h2>Consulta de GLU por Mes (Hipoglucemia)</h2>
            <label for="mes">Selecciona el mes:</label>
            <select name="mes" id="mes">
                <option value="enero">Enero</option>
                <option value="febrero">Febrero</option>
                <option value="marzo">Marzo</option>
                <option value="abril">Abril</option>
                <option value="mayo">Mayo</option>
                <option value="junio">Junio</option>
                <option value="julio">Julio</option>
                <option value="agosto">Agosto</option>
                <option value="septiembre">Septiembre</option>
                <option value="octubre">Octubre</option>
                <option value="noviembre">Noviembre</option>
                <option value="diciembre">Diciembre</option>
                
            </select><br><br>

            <input type="submit" value="Consultar GLU">
        </form>
    </body>
    </html>
    <?php
}
?>
