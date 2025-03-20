<?php

session_start();

require_once 'conexion.php';
if (!isset($_SESSION['idusuario'])) {
    die("No has iniciado sesión.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    $error = true;
    
    
    $fecha = $_POST['fecha'];

    $query = "SELECT COUNT(*) FROM controlglu WHERE fecha = '$fecha'";

    
    $resultado = mysqli_query($conn, $query);

    
    if ($resultado) {
        
        $row = mysqli_fetch_array($resultado);

        
        if ($row[0] > 0) {
            $error = false;
            $efecha = 'Ya hay un registro con esa fecha, prueba con otra';
        } else {
            
        

    if($_POST['LENTA'] >= 0 && $_POST['LENTA'] <= 50){
        $lenta = $_POST['LENTA'];
    }else{
        $elenta = 'Solo se puden insertar de 0-50 uds';
        $error = false;
    }


    if($_POST['DEPORTE'] >= 1 && $_POST['DEPORTE'] <= 5){
        $deporte = $_POST['DEPORTE'];
    }else{
        $edeporte = 'Solo se pueden insertar números del 1 al 5';
        $error = false;
    }




    if($_POST['desayuno_GLH1'] >= 0 && $_POST['desayuno_GLH1'] <= 180){
        $desayuno_GLH1 = $_POST['desayuno_GLH1'];
    }else{
        $deglh1 = 'Solo se pueden insertar cantidades de 0 a 180';
        $error = false;
    }

    if($_POST['desayuno_GLH2'] >= 0 && $_POST['desayuno_GLH2'] <= 140){
        $desayuno_GLH2 = $_POST['desayuno_GLH2'];
    }else{
        $deglh2 = 'Solo se pueden insertar cantidades de 0 a 140';
        $error = false;
    }

    if($_POST['desayuno_RAC'] >= 0 && $_POST['desayuno_RAC'] <= 10){
        $desayuno_RAC = $_POST['desayuno_RAC'];
    }else{
        $derac = 'Solo se puden insertar de 0-10 raciones';
        $error = false;
    }

    if($_POST['desayuno_INSU'] >= 0 && $_POST['desayuno_INSU'] <= 20){
        $desayuno_INSU = $_POST['desayuno_INSU'];
    }else{
        $desinsu = 'Solo se puden insertar de 0-20 uds';
        $error = false;
    }



    if($_POST['comida_GLH1'] >= 0 && $_POST['comida_GLH1'] <= 180){
        $comida_GLH1 = $_POST['comida_GLH1'];
    }else{
        $coglh1 = 'Solo se pueden insertar cantidades de 0 a 180';
        $error = false;
    }

    if($_POST['comida_GLH2'] >= 0 && $_POST['comida_GLH2'] <= 140){
        $comida_GLH2 = $_POST['comida_GLH2'];
    }else{
        $coglh2 = 'Solo se pueden insertar cantidades de 0 a 140';
        $error = false;
    }

    if($_POST['comida_RAC'] >= 0 && $_POST['comida_RAC'] <= 10){
        $comida_RAC = $_POST['comida_RAC'];
    }else{
        $corac = 'Solo se puden insertar de 0-10 raciones';
        $error = false;
    }

    if($_POST['comida_INSU'] >= 0 && $_POST['comida_INSU'] <= 20){
        $comida_INSU = $_POST['comida_INSU'];
    }else{
        $coinsu = 'Solo se puden insertar de 0-20 uds';
        $error = false;
    }




    if($_POST['cena_GLH1'] >= 0 && $_POST['cena_GLH1'] <= 180){
        $cena_GLH1 = $_POST['cena_GLH1'];
    }else{
        $ceeglh1 = 'Solo se pueden insertar cantidades de 0 a 180';
        $error = false;
    }

    if($_POST['cena_GLH2'] >= 0 && $_POST['cena_GLH2'] <= 140){
        $cena_GLH2 = $_POST['cena_GLH2'];
    }else{
        $ceeglh2 = 'Solo se pueden insertar cantidades de 0 a 140';
        $error = false;
    }

    if($_POST['cena_RAC'] >= 0 && $_POST['cena_RAC'] <= 10){
        $cena_RAC = $_POST['cena_RAC'];
    }else{
        $cerac = 'Solo se puden insertar de 0-10 raciones';
        $error = false;
    }

    if($_POST['cena_INSU'] >= 0 && $_POST['cena_INSU'] <= 20){
        $cena_INSU = $_POST['cena_INSU'];
    }else{
        $ceinsu = 'Solo se puden insertar de 0-20 uds';
        $error = false;
    }



    
    $hipo_hiper_desayuno = isset($_POST['hipo_hiper_desayuno']) ? $_POST['hipo_hiper_desayuno'] : '';
    $hipo_hiper_comida = isset($_POST['hipo_hiper_comida']) ? $_POST['hipo_hiper_comida'] : '';
    $hipo_hiper_cena = isset($_POST['hipo_hiper_cena']) ? $_POST['hipo_hiper_cena'] : '';

    

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    
    $idusuario = $_SESSION['idusuario'];

    if($error == true){
    
    $sql_controlglu = "INSERT INTO controlglu (idusuario, fecha, lenta, deporte) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_controlglu);
    $stmt->bind_param("ssss", $idusuario, $fecha, $lenta, $deporte);
    $stmt->execute();

    
    $sql_comida = "INSERT INTO comidas (idusuario, fecha, idcomida, gl1h, rac, insu, glh2) VALUES (?, ?, 'desayuno', ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_comida);
    $stmt->bind_param("ssssss", $idusuario, $fecha, $desayuno_GLH1, $desayuno_RAC, $desayuno_INSU, $desayuno_GLH2);
    $stmt->execute();

   
    $sql_comida = "INSERT INTO comidas (idusuario, fecha, idcomida, gl1h, rac, insu, glh2) VALUES (?, ?, 'comida', ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_comida);
    $stmt->bind_param("ssssss", $idusuario, $fecha, $comida_GLH1, $comida_RAC, $comida_INSU, $comida_GLH2);
    $stmt->execute();

    
    $sql_comida = "INSERT INTO comidas (idusuario, fecha, idcomida, gl1h, rac, insu, glh2) VALUES (?, ?, 'cena', ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_comida);
    $stmt->bind_param("ssssss", $idusuario, $fecha, $cena_GLH1, $cena_RAC, $cena_INSU, $cena_GLH2);
    $stmt->execute();

    }
    if ($hipo_hiper_desayuno == "HIPO") {

        if($_POST['GLU_desayuno'] > 0 && $_POST['GLU_desayuno'] < 70){
            $glu_desayuno = $_POST['GLU_desayuno'];
        }else{
            $hipodes = 'Solo se pueden insertar cantidades de 0 a 70';
            $error = false;
        }


        
        $hora_desayuno = htmlspecialchars($_POST['HORA_desayuno']);

        if($error == true){

        $sql_hipo = "INSERT INTO hipo (idusuario, fecha, idcomida, glu, hora) VALUES (?, ?, 'desayuno', ?, ?)";
        $stmt = $conn->prepare($sql_hipo);
        $stmt->bind_param("ssss", $idusuario, $fecha, $glu_desayuno, $hora_desayuno);
        $stmt->execute();

        }
    } elseif ($hipo_hiper_desayuno == "HIPÉR") {



        if($_POST['GLU2_desayuno'] > 180){
            $glu_desayuno = $_POST['GLU2_desayuno'];
        }else{
            $hiperdes = 'Solo se pueden insertar cantidades superiores a 180';
            $error = false;
        }

       
        $hora_desayuno = htmlspecialchars($_POST['HORA2_desayuno']);

        if($_POST['CORR_desayuno'] >= 0 && $_POST['CORR_desayuno'] <= 10){
            $corr_desayuno = $_POST['CORR_desayuno'];
        }else{
            $descorr = 'Solo se puden insertar de 0-10 uds';
            $error = false;
        }

        if($error == true){
        $sql_hiper = "INSERT INTO hiper (idusuario, fecha, idcomida, glu, hora, corr) VALUES (?, ?, 'desayuno', ?, ?, ?)";
        $stmt = $conn->prepare($sql_hiper);
        $stmt->bind_param("sssss", $idusuario, $fecha, $glu_desayuno, $hora_desayuno, $corr_desayuno);
        $stmt->execute();
        }
    }

   
    if ($hipo_hiper_comida == "HIPO") {

        if($_POST['GLU_comida'] > 0 && $_POST['GLU_comida'] < 70){
            $glu_comida = $_POST['GLU_comida'];
        }else{
            $hipoco = 'Solo se pueden insertar cantidades de 0 a 70';
            $error = false;
        }

       
        $hora_comida = htmlspecialchars($_POST['HORA_comida']);
        if($error == true){
        $sql_hipo = "INSERT INTO hipo (idusuario, fecha, idcomida, glu, hora) VALUES (?, ?, 'comida', ?, ?)";
        $stmt = $conn->prepare($sql_hipo);
        $stmt->bind_param("ssss", $idusuario, $fecha, $glu_comida, $hora_comida);
        $stmt->execute();
        }
    } elseif ($hipo_hiper_comida == "HIPÉR") {

        if($_POST['GLU2_comida'] > 180){
            $glu_comida = $_POST['GLU2_comida'];
        }else{
            $hiperco = 'Solo se pueden insertar cantidades superiores a 180';
            $error = false;
        }

       
        $hora_comida = htmlspecialchars($_POST['HORA2_comida']);

        if($_POST['CORR_comida'] >= 0 && $_POST['CORR_comida'] <= 10){
            $corr_comida = $_POST['CORR_comida'];
        }else{
            $cocorr = 'Solo se puden insertar de 0-10 uds';
            $error = false;
        }

        if($error == true){
        $sql_hiper = "INSERT INTO hiper (idusuario, fecha, idcomida, glu, hora, corr) VALUES (?, ?, 'comida', ?, ?, ?)";
        $stmt = $conn->prepare($sql_hiper);
        $stmt->bind_param("sssss", $idusuario, $fecha, $glu_comida, $hora_comida, $corr_comida);
        $stmt->execute();
        }
    }

   
    if ($hipo_hiper_cena == "HIPO") {

        if($_POST['GLU_cena'] > 0 && $_POST['GLU_cena'] < 70){
            $glu_cena = $_POST['GLU_cena'];
            
        }else{
            $hipoce = 'Solo se pueden insertar cantidades de 0 a 70';
            $error = false;
        }

        
        $hora_cena = htmlspecialchars($_POST['HORA_cena']);
        if($error == true){
        $sql_hipo = "INSERT INTO hipo (idusuario, fecha, idcomida, glu, hora) VALUES (?, ?, 'cena', ?, ?)";
        $stmt = $conn->prepare($sql_hipo);
        $stmt->bind_param("ssss", $idusuario, $fecha, $glu_cena, $hora_cena);
        $stmt->execute();
        }
    } elseif ($hipo_hiper_cena == "HIPÉR") {

        if($_POST['GLU2_cena'] > 180){
            $glu_cena = $_POST['GLU2_cena'];
        }else{
            $hiperce = 'Solo se pueden insertar cantidades superiores a 180';
            $error = false;
        }

        
        $hora_cena = htmlspecialchars($_POST['HORA2_cena']);

        if($_POST['CORR_cena'] >= 0 && $_POST['CORR_cena'] <= 10){
            $corr_cena = $_POST['CORR_cena'];
        }else{
            $cecorr = 'Solo se puden insertar de 0-10 uds';
            $error = false;
        }

        if($error == true){
        $sql_hiper = "INSERT INTO hiper (idusuario, fecha, idcomida, glu, hora, corr) VALUES (?, ?, 'cena', ?, ?, ?)";
        $stmt = $conn->prepare($sql_hiper);
        $stmt->bind_param("sssss", $idusuario, $fecha, $glu_cena, $hora_cena, $corr_cena);
        $stmt->execute();
        $stmt->close();
    $conn->close();
        }
    }
        }
    }
   

} 

?>





<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Alimentación</title>
    <link rel="stylesheet" href="style.css">
    <script>
        
        function showFields() {
            const mealType = document.getElementById("mealType").value;
            const desayunoFields = document.getElementById("desayunoFields");
            const comidaFields = document.getElementById("comidaFields");
            const cenaFields = document.getElementById("cenaFields");

            
            desayunoFields.style.display = "none";
            comidaFields.style.display = "none";
            cenaFields.style.display = "none";

            
            if (mealType === "desayuno") {
                desayunoFields.style.display = "block";
                document.getElementById("hipo_hiper_desayuno").style.display = "block";
            } else if (mealType === "comida") {
                comidaFields.style.display = "block";
                document.getElementById("hipo_hiper_comida").style.display = "block";
            } else if (mealType === "cena") {
                cenaFields.style.display = "block";
                document.getElementById("hipo_hiper_cena").style.display = "block";
            }
        }

        
        function toggleFields(mealType) {
            const hipoFields = document.getElementById("hipoFields_" + mealType);
            const hiperFields = document.getElementById("hiperFields_" + mealType);
            const selectedOption = document.querySelector('input[name="hipo_hiper_' + mealType + '"]:checked')?.value;

            if (selectedOption === "HIPO") {
                hipoFields.style.display = "block";
                hiperFields.style.display = "none";
            } else if (selectedOption === "HIPÉR") {
                hipoFields.style.display = "none";
                hiperFields.style.display = "block";
            } else {
                hipoFields.style.display = "none";
                hiperFields.style.display = "none";
            }
        }
    </script>
</head>
<body onload="showFields()">



<form action="#" method="post">
<h2>Rellena los datos para insertar el registro</h2>
    
    <label for="fecha">Fecha:</label>
    <input type="date" id="fecha" name="fecha" required <?php if(isset($efecha)){echo "<span><br> *$efecha </span>";}?>><br><br>

    
    <label for="mealType">Selecciona el tipo de comida:</label>
    <select name="mealType" id="mealType" onchange="showFields()">
        <option value="desayuno">Desayuno</option>
        <option value="comida">Comida</option>
        <option value="cena">Cena</option>
    </select><br><br>

    
    <fieldset id="desayunoFields" style="display:none;">
        <legend>Desayuno</legend>
        <label for="GLH1">GL/H1:</label>
        <input type="text" id="GLH1" name="desayuno_GLH1"><?php if(isset($deglh1)){echo "<span><br> *$deglh1</span>";}?><br><br>

        <label for="RAC">RAC:</label>
        <input type="text" id="RAC" name="desayuno_RAC"><?php if(isset($derac)){echo "<span><br> *$derac</span>";}?><br><br>

        <label for="INSU">INSU:</label>
        <input type="text" id="INSU" name="desayuno_INSU"><?php if(isset($desinsu)){echo "<span><br> *$desinsu</span>";}?><br><br>

        <label for="GLH2">GL/H2:</label>
        <input type="text" id="GLH2" name="desayuno_GLH2"><?php if(isset($deglh2)){echo "<span><br> *$deglh2</span>";}?><br><br>

        
        <div id="hipo_hiper_desayuno" style="display:none;">
            <label>Selecciona una opción para HIPO/HIPÉR:</label><br>
            <input type="radio" id="HIPO_desayuno" name="hipo_hiper_desayuno" value="HIPO" onclick="toggleFields('desayuno')"> HIPO
            <input type="radio" id="HIPÉR_desayuno" name="hipo_hiper_desayuno" value="HIPÉR" onclick="toggleFields('desayuno')"> HIPÉR<br><br>

            
            <div id="hipoFields_desayuno" style="display:none;">
                <label for="GLU_desayuno">GLU:</label>
                <input type="text" id="GLU_desayuno" name="GLU_desayuno"><?php if(isset($hipodes)){echo "<span><br> *$hipodes</span>";}?><br><br>

                <label for="HORA_desayuno">HORA:</label>
                <input type="time" id="HORA_desayuno" name="HORA_desayuno"><br><br>
            </div>

            <div id="hiperFields_desayuno" style="display:none;">
                <label for="GLU_desayuno">GLU:</label>
                <input type="text" id="GLU2_desayuno" name="GLU2_desayuno"><?php if(isset($hiperdes)){echo "<span><br> *$hiperdes</span>";}?><br><br>

                <label for="HORA_desayuno">HORA:</label>
                <input type="time" id="HORA2_desayuno" name="HORA2_desayuno"><br><br>

                <label for="CORR_desayuno">CORR:</label>
                <input type="text" id="CORR_desayuno" name="CORR_desayuno"><?php if(isset($descorr)){echo "<span><br> *$descorr</span>";}?><br><br>
            </div>
        </div>
    </fieldset>

    
    <fieldset id="comidaFields" style="display:none;">
        <legend>Comida</legend>
        <label for="GLH1">GL/H1:</label>
        <input type="text" id="GLH1" name="comida_GLH1"><?php if(isset($coglh1)){echo "<span><br> *$coglh1</span>";}?><br><br>

        <label for="RAC">RAC:</label>
        <input type="text" id="RAC" name="comida_RAC"><?php if(isset($corac)){echo "<span><br> *$corac</span>";}?><br><br>

        <label for="INSU">INSU:</label>
        <input type="text" id="INSU" name="comida_INSU"><?php if(isset($coinsu)){echo "<span><br> *$coinsu</span>";}?><br><br>

        <label for="GLH2">GL/H2:</label>
        <input type="text" id="GLH2" name="comida_GLH2"><?php if(isset($coglh2)){echo "<span><br> *$coglh2</span>";}?><br><br>

        
        <div id="hipo_hiper_comida" style="display:none;">
            <label>Selecciona una opción para HIPO/HIPÉR:</label><br>
            <input type="radio" id="HIPO_comida" name="hipo_hiper_comida" value="HIPO" onclick="toggleFields('comida')"> HIPO
            <input type="radio" id="HIPÉR_comida" name="hipo_hiper_comida" value="HIPÉR" onclick="toggleFields('comida')"> HIPÉR<br><br>

            
            <div id="hipoFields_comida" style="display:none;">
                <label for="GLU_comida">GLU:</label>
                <input type="text" id="GLU_comida" name="GLU_comida"><?php if(isset($hipoco)){echo "<span><br> *$hipoco</span>";}?><br><br>

                <label for="HORA_comida">HORA:</label>
                <input type="time" id="HORA_comida" name="HORA_comida"><br><br>
            </div>

            <div id="hiperFields_comida" style="display:none;">
                <label for="GLU_comida">GLU:</label>
                <input type="text" id="GLU2_comida" name="GLU2_comida"><?php if(isset($hiperco)){echo "<span><br> *$hiperco</span>";}?><br><br>

                <label for="HORA_comida">HORA:</label>
                <input type="time" id="HORA2_comida" name="HORA2_comida"><br><br>

                <label for="CORR_comida">CORR:</label>
                <input type="text" id="CORR_comida" name="CORR_comida"><?php if(isset($cocorr)){echo "<span><br> *$cocorr</span>";}?><br><br>
            </div>
        </div>
    </fieldset>

    
    <fieldset id="cenaFields" style="display:none;">
        <legend>Cena</legend>
        <label for="GLH1">GL/H1:</label>
        <input type="text" id="GLH1" name="cena_GLH1"><?php if(isset($ceeglh1)){echo "<span><br> *$ceeglh1</span>";}?><br><br>

        <label for="RAC">RAC:</label>
        <input type="text" id="RAC" name="cena_RAC"><?php if(isset($cerac)){echo "<span><br> *$cerac</span>";}?><br><br>

        <label for="INSU">INSU:</label>
        <input type="text" id="INSU" name="cena_INSU"><?php if(isset($ceinsu)){echo "<span><br> *$ceinsu</span>";}?><br><br>

        <label for="GLH2">GL/H2:</label>
        <input type="text" id="GLH2" name="cena_GLH2"><?php if(isset($ceeglh2)){echo "<span><br> *$ceeglh2</span>";}?><br><br>

        
        <div id="hipo_hiper_cena" style="display:none;">
            <label>Selecciona una opción para HIPO/HIPÉR:</label><br>
            <input type="radio" id="HIPO_cena" name="hipo_hiper_cena" value="HIPO" onclick="toggleFields('cena')"> HIPO
            <input type="radio" id="HIPÉR_cena" name="hipo_hiper_cena" value="HIPÉR" onclick="toggleFields('cena')"> HIPÉR<br><br>

            
            <div id="hipoFields_cena" style="display:none;">
                <label for="GLU_cena">GLU:</label>
                <input type="text" id="GLU_cena" name="GLU_cena"><?php if(isset($hipoce)){echo "<span><br> *$hipoce</span>";}?><br><br>

                <label for="HORA_cena">HORA:</label>
                <input type="time" id="HORA_cena" name="HORA_cena"><br><br>
            </div>

            <div id="hiperFields_cena" style="display:none;">
                <label for="GLU_cena">GLU:</label>
                <input type="text" id="GLU2_cena" name="GLU2_cena"><?php if(isset($hiperce)){echo "<span><br> *$hiperce</span>";}?><br><br>

                <label for="HORA_cena">HORA:</label>
                <input type="time" id="HORA2_cena" name="HORA2_cena"><br><br>

                <label for="CORR_cena">CORR:</label>
                <input type="text" id="CORR_cena" name="CORR_cena"><?php if(isset($cecorr)){echo "<span><br> *$cecorr</span>";}?><br><br>
            </div>
        </div>
    </fieldset>

    
    <label for="LENTA">LENTA:</label>
    <input type="text" id="LENTA" name="LENTA"><?php if(isset($elenta)){echo "<span><br> *$elenta</span>";}?><br><br>

    <label for="DEPORTE">DEPORTE:</label>
    <input type="text" id="DEPORTE" name="DEPORTE"><?php if(isset($edeporte)){echo "<span><br> *$edeporte</span>";}?><br><br>

    
    <button type="submit">Enviar</button>
    <?php

        if($_SERVER['REQUEST_METHOD'] == 'POST' && $error == true){echo "Datos insertados correctamente";}elseif($_SERVER['REQUEST_METHOD'] == 'POST' && $error == false){echo "No se han podido insertar los datos";}

?>    
</form>
</body>
</html>
