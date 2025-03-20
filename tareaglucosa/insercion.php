<?php
session_start();
require_once('conexion.php');


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$idusuario = $_SESSION['idusuario']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $lenta = $_POST['lenta'];
    $deporte = $_POST['deporte'];

    try {
       
        $conn->begin_transaction();

       
        $sql_controlglu = "INSERT INTO controlglu (fecha, lenta, deporte, idusuario) VALUES (?, ?, ?, ?)";
        $stmt_controlglu = $conn->prepare($sql_controlglu);
        $stmt_controlglu->bind_param("sssi", $fecha, $lenta, $deporte, $idusuario);
        $stmt_controlglu->execute();

        $comidas = ['Desayuno', 'Comida', 'Cena'];
        foreach ($comidas as $comida) {
            $gl1h = $_POST[$comida . '_gl1h'] ?? null;
            $rac = $_POST[$comida . '_rac'] ?? null;
            $insu = $_POST[$comida . '_insu'] ?? null;
            $gl2h = $_POST[$comida . '_gl2h'] ?? null;

           
            $sql_comidas = "INSERT INTO comidas (idcomida, gl1h, rac, insu, glh2, fecha, idusuario) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_comidas = $conn->prepare($sql_comidas);
            $stmt_comidas->bind_param("ssssssi", $comida, $gl1h, $rac, $insu, $gl2h, $fecha, $idusuario);
            $stmt_comidas->execute();

            
            if (isset($_POST[$comida . '_hipo_glu'], $_POST[$comida . '_hipo_hora'])) {
                $hipo_glu = $_POST[$comida . '_hipo_glu'];
                $hipo_hora = $_POST[$comida . '_hipo_hora'];

                $sql_hipo = "INSERT INTO hipo (glu, hora, fecha, idcomida, idusuario) 
                             VALUES (?, ?, ?, ?, ?)";
                $stmt_hipo = $conn->prepare($sql_hipo);
                $stmt_hipo->bind_param("ssssi", $hipo_glu, $hipo_hora, $fecha, $comida, $idusuario);
                $stmt_hipo->execute();
            }

        
            if (isset($_POST[$comida . '_hiper_glu'], $_POST[$comida . '_hiper_hora'], $_POST[$comida . '_hiper_corr'])) {
                $hiper_glu = $_POST[$comida . '_hiper_glu'];
                $hiper_hora = $_POST[$comida . '_hiper_hora'];
                $hiper_corr = $_POST[$comida . '_hiper_corr'];

                $sql_hiper = "INSERT INTO hiper (glu, hora, corr, fecha, idcomida, idusuario) 
                              VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_hiper = $conn->prepare($sql_hiper);
                $stmt_hiper->bind_param("sssssi", $hiper_glu, $hiper_hora, $hiper_corr, $fecha, $comida, $idusuario);
                $stmt_hiper->execute();
            }
        }

      
        $conn->commit();
        echo "Datos insertados correctamente.";

    } catch (Exception $e) {
        $conn->rollback(); 
        echo "Error en la inserción de datos: " . $e->getMessage();
    }
}


?>





<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inserción de registro</title>
</head>
<body>
    <h1>Inserta los datos del registro</h1>
    <form method="POST" action="">
      
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" required><br><br>
        
        
        <label for="lenta">Lenta(uds):</label>
        <input type="number" name="lenta" id="lenta" min="0" max="30"><br><br>
        
       
        <label for="deporte">Deporte(1-5):</label>
        <input type="number" name="deporte" id="deporte" min="1" max="5"><br><br>

        
        <h2>Desayuno</h2>
        <label for="Desayuno_gl1h">GL/1H(mg/dL):</label>
        <input type="number" name="Desayuno_gl1h" id="Desayuno_gl1h" min="0" max="160"><br><br>
        
        <label for="Desayuno_rac">RAC:</label>
        <input type="number" name="Desayuno_rac" id="Desayuno_rac" min="0" max="6"><br><br>

        <label for="Desayuno_insu">INSU(uds):</label>
        <input type="number" name="Desayuno_insu" id="Desayuno_insu" min="0" max="12"><br><br>

        <label for="Desayuno_gl2h">GL/2H(mg/dL):</label>
        <input type="number" name="Desayuno_gl2h" id="Desayuno_gl2h" min="0" max="140"><br><br>

     
        <h3>HIPO</h3>
        <label for="Desayuno_hipo_glu">GLU(mg/dL):</label>
        <input type="number" name="Desayuno_hipo_glu" id="Desayuno_hipo_glu" min="0" max="180"><br><br>
        
        <label for="Desayuno_hipo_hora">HORA:</label>
        <input type="number" name="Desayuno_hipo_hora" id="Desayuno_hipo_hora" min="0" max="24"><br><br>

        <h3>HIPÉR</h3>
        <label for="Desayuno_hiper_glu">GLU(mg/dL):</label>
        <input type="number" name="Desayuno_hiper_glu" id="Desayuno_hiper_glu" min="0" max="180"><br><br>
        
        <label for="Desayuno_hiper_hora">HORA:</label>
        <input type="number" name="Desayuno_hiper_hora" id="Desayuno_hiper_hora" min="0" max="24"><br><br>
        
        <label for="Desayuno_hiper_corr">CORR(uds):</label>
        <input type="number" name="Desayuno_hiper_corr" id="Desayuno_hiper_corr" min="0" max="6"><br><br>

        
        <h2>Comida</h2>
        <label for="Comida_gl1h">GL/1H(mg/dL):</label>
        <input type="number" name="Comida_gl1h" id="Comida_gl1h" min="0" max="160"><br><br>
        
        <label for="Comida_rac">RAC:</label>
        <input type="number" name="Comida_rac" id="Comida_rac" min="0" max="6"><br><br>

        <label for="Comida_insu">INSU(uds):</label>
        <input type="number" name="Comida_insu" id="Comida_insu" min="0" max="12"><br><br>

        <label for="Comida_gl2h">GL/2H(mg/dL):</label>
        <input type="number" name="Comida_gl2h" id="Comida_gl2h" min="0" max="140"><br><br>

       
        <h3>HIPO</h3>
        <label for="Comida_hipo_glu">GLU(mg/dL):</label>
        <input type="number" name="Comida_hipo_glu" id="Comida_hipo_glu" min="0" max="180"><br><br>
        
        <label for="Comida_hipo_hora">HORA:</label>
        <input type="number" name="Comida_hipo_hora" id="Comida_hipo_hora" min="0" max="24"><br><br>

        <h3>HIPÉR</h3>
        <label for="Comida_hiper_glu">GLU(mg/dL):</label>
        <input type="number" name="Comida_hiper_glu" id="Comida_hiper_glu" min="0" max="180"><br><br>
        
        <label for="Comida_hiper_hora">HORA:</label>
        <input type="number" name="Comida_hiper_hora" id="Comida_hiper_hora" min="0" max="24"><br><br>
        
        <label for="Comida_hiper_corr">CORR(uds):</label>
        <input type="number" name="Comida_hiper_corr" id="Comida_hiper_corr" min="0" max="6"><br><br>

       
        <h2>Cena</h2>
        <label for="Cena_gl1h">GL/1H(mg/dL):</label>
        <input type="number" name="Cena_gl1h" id="Cena_gl1h" min="0" max="160"><br><br>
        
        <label for="Cena_rac">RAC:</label>
        <input type="number" name="Cena_rac" id="Cena_rac" min="0" max="6"><br><br>

        <label for="Cena_insu">INSU(uds):</label>
        <input type="number" name="Cena_insu" id="Cena_insu" min="0" max="12"><br><br>

        <label for="Cena_gl2h">GL/2H(mg/dL):</label>
        <input type="number" name="Cena_gl2h" id="Cena_gl2h" min="0" max="140"><br><br>

        
        <h3>HIPO</h3>
        <label for="Cena_hipo_glu">GLU(mg/dL):</label>
        <input type="number" name="Cena_hipo_glu" id="Cena_hipo_glu" min="0" max="180"><br><br>
        
        <label for="Cena_hipo_hora">HORA:</label>
        <input type="number" name="Cena_hipo_hora" id="Cena_hipo_hora" min="0" max="24"><br><br>

        <h3>HIPÉR</h3>
        <label for="Cena_hiper_glu">GLU(mg/dL):</label>
        <input type="number" name="Cena_hiper_glu" id="Cena_hiper_glu" min="0" max="180"><br><br>
        
        <label for="Cena_hiper_hora">HORA:</label>
        <input type="number" name="Cena_hiper_hora" id="Cena_hiper_hora" min="0" max="24"><br><br>
        
        <label for="Cena_hiper_corr">CORR(uds):</label>
        <input type="number" name="Cena_hiper_corr" id="Cena_hiper_corr" min="0" max="6"><br><br>

      
        <button type="submit">Enviar</button>
    </form>
</body>
</html>


<?php

$conn->close();
?>
