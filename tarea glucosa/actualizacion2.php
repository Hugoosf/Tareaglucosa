<?php

include('conexion.php');


session_start();
if (!isset($_SESSION['idusuario'])) {
    die("No estás autenticado.");
}


$idusuario = $_SESSION['idusuario'];


if (isset($_POST['fecha'])) {
    $fecha = $_POST['fecha'];

    $query = "SELECT COUNT(*) FROM controlglu WHERE fecha = '$fecha'";

    
    $resultado = mysqli_query($conn, $query);

    
    if ($resultado) {
        
        $row = mysqli_fetch_array($resultado);

        
        if ($row[0] > 0) {
            $error = false;
            $efecha = 'Ya hay un registro con esa fecha, prueba con otra';
        

    $sql_controlglu = "SELECT lenta, deporte FROM controlglu WHERE idusuario = ? AND fecha = ?";
    $stmt_controlglu = $conn->prepare($sql_controlglu);
    $stmt_controlglu->bind_param('is', $idusuario, $fecha);
    $stmt_controlglu->execute();
    $stmt_controlglu->bind_result($lenta, $deporte);
    $stmt_controlglu->fetch();
    $stmt_controlglu->close();

    
    $sql_comidas = "SELECT idcomida, gl1h, rac, insu, glh2 FROM comidas WHERE idusuario = ? AND fecha = ?";
    $stmt_comidas = $conn->prepare($sql_comidas);
    $stmt_comidas->bind_param('is', $idusuario, $fecha);
    $stmt_comidas->execute();
    $stmt_comidas->bind_result($idcomida, $gl1h, $rac, $insu, $glh2);

    
    $gl1h_desayuno = $rac_desayuno = $insu_desayuno = $glh2_desayuno = null;
    $gl1h_comida = $rac_comida = $insu_comida = $glh2_comida = null;
    $gl1h_cena = $rac_cena = $insu_cena = $glh2_cena = null;

    while ($stmt_comidas->fetch()) {
        if ($idcomida == 'desayuno') {
            $gl1h_desayuno = $gl1h;
            $rac_desayuno = $rac;
            $insu_desayuno = $insu;
            $glh2_desayuno = $glh2;
        } elseif ($idcomida == 'comida') {
            $gl1h_comida = $gl1h;
            $rac_comida = $rac;
            $insu_comida = $insu;
            $glh2_comida = $glh2;
        } elseif ($idcomida == 'cena') {
            $gl1h_cena = $gl1h;
            $rac_cena = $rac;
            $insu_cena = $insu;
            $glh2_cena = $glh2;
        }
    }
    $stmt_comidas->close();

    
    $sql_hipo = "SELECT idcomida, glu, hora FROM hipo WHERE idusuario = ? AND fecha = ?";
    $stmt_hipo = $conn->prepare($sql_hipo);
    $stmt_hipo->bind_param('is', $idusuario, $fecha);
    $stmt_hipo->execute();
    $stmt_hipo->bind_result($idcomida_hipo, $glu, $hora);

    
    $glu_desayuno = $hora_desayuno = null;
    $glu_comida = $hora_comida = null;
    $glu_cena = $hora_cena = null;

    while ($stmt_hipo->fetch()) {
        if ($idcomida_hipo == 'desayuno') {
            $glu_desayuno = $glu;
            $hora_desayuno = $hora;
        } elseif ($idcomida_hipo == 'comida') {
            $glu_comida = $glu;
            $hora_comida = $hora;
        } elseif ($idcomida_hipo == 'cena') {
            $glu_cena = $glu;
            $hora_cena = $hora;
        }
    }
    $stmt_hipo->close();

    
    $sql_hiper = "SELECT idcomida, glu, hora, corr FROM hiper WHERE idusuario = ? AND fecha = ?";
    $stmt_hiper = $conn->prepare($sql_hiper);
    $stmt_hiper->bind_param('is', $idusuario, $fecha);
    $stmt_hiper->execute();
    $stmt_hiper->bind_result($idcomida_hiper, $glu_hiper, $hora_hiper, $corr);

    
    $glu_desayuno_hiper = $hora_desayuno_hiper = $corr_desayuno = null;
    $glu_comida_hiper = $hora_comida_hiper = $corr_comida = null;
    $glu_cena_hiper = $hora_cena_hiper = $corr_cena = null;

    while ($stmt_hiper->fetch()) {
        if ($idcomida_hiper == 'desayuno') {
            $glu_desayuno_hiper = $glu_hiper;
            $hora_desayuno_hiper = $hora_hiper;
            $corr_desayuno = $corr;
        } elseif ($idcomida_hiper == 'comida') {
            $glu_comida_hiper = $glu_hiper;
            $hora_comida_hiper = $hora_hiper;
            $corr_comida = $corr;
        } elseif ($idcomida_hiper == 'cena') {
            $glu_cena_hiper = $glu_hiper;
            $hora_cena_hiper = $hora_hiper;
            $corr_cena = $corr;
        }
    }
    $stmt_hiper->close();
}else{  $mensajefech= 'No hay ningún registro con esa fecha.';} }
} 



?>

<?php
    if (isset($_POST['actualizar'])) {

        $error = true;

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
        $sql_controlglu = "UPDATE controlglu SET lenta = ?, deporte = ? WHERE idusuario = ? AND fecha = ?";
        $stmt = $conn->prepare($sql_controlglu);
        $stmt->bind_param("ssss", $lenta, $deporte, $idusuario, $fecha);
        $stmt->execute();
    
        
        $sql_comida = "UPDATE comidas SET gl1h = ?, rac = ?, insu = ?, glh2 = ? WHERE idusuario = ? AND fecha = ? AND idcomida = 'desayuno'";
        $stmt = $conn->prepare($sql_comida);
        $stmt->bind_param("ssssss", $desayuno_GLH1, $desayuno_RAC, $desayuno_INSU, $desayuno_GLH2, $idusuario, $fecha);
        $stmt->execute();
    
        $sql_comida = "UPDATE comidas SET gl1h = ?, rac = ?, insu = ?, glh2 = ? WHERE idusuario = ? AND fecha = ? AND idcomida = 'comida'";
        $stmt = $conn->prepare($sql_comida);
        $stmt->bind_param("ssssss", $comida_GLH1, $comida_RAC, $comida_INSU, $comida_GLH2, $idusuario, $fecha);
        $stmt->execute();
    
        $sql_comida = "UPDATE comidas SET gl1h = ?, rac = ?, insu = ?, glh2 = ? WHERE idusuario = ? AND fecha = ? AND idcomida = 'cena'";
        $stmt = $conn->prepare($sql_comida);
        $stmt->bind_param("ssssss", $cena_GLH1, $cena_RAC, $cena_INSU, $cena_GLH2, $idusuario, $fecha);
        $stmt->execute();
        }
        
        if ($hipo_hiper_desayuno == "HIPO") {
            if($_POST['GLU_desayuno'] > 0 && $_POST['GLU_desayuno'] < 70){
                $glu_desayuno = $_POST['GLU_desayuno'];
            }else{
                $hipodes = 'Solo se pueden insertar cantidades de 0 a 70';
                $error = false;
            }
            $hora_desayuno = $_POST['HORA_desayuno'];

            if($error == true){
            $sql_hipo = "UPDATE hipo SET glu = ?, hora = ? WHERE idusuario = ? AND fecha = ? AND idcomida = 'desayuno'";
            $stmt = $conn->prepare($sql_hipo);
            $stmt->bind_param("ssss", $glu_desayuno, $hora_desayuno, $idusuario, $fecha);
            $stmt->execute();
            }
        } elseif ($hipo_hiper_desayuno == "HIPÉR") {
            if($_POST['GLU2_desayuno'] > 180){
                $glu_desayuno = $_POST['GLU2_desayuno'];
            }else{
                $hiperdes = 'Solo se pueden insertar cantidades superiores a 180';
                $error = false;
            }

            $hora_desayuno = $_POST['HORA2_desayuno'];

            if($_POST['CORR_desayuno'] >= 0 && $_POST['CORR_desayuno'] <= 10){
                $corr_desayuno = $_POST['CORR_desayuno'];
            }else{
                $descorr = 'Solo se puden insertar de 0-10 uds';
                $error = false;
            }
            if($error == true){
            $sql_hiper = "UPDATE hiper SET glu = ?, hora = ?, corr = ? WHERE idusuario = ? AND fecha = ? AND idcomida = 'desayuno'";
            $stmt = $conn->prepare($sql_hiper);
            $stmt->bind_param("sssss", $glu_desayuno, $hora_desayuno, $corr_desayuno, $idusuario, $fecha);
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
            $hora_comida = $_POST['HORA_comida'];
            if($error == true){
            $sql_hipo = "UPDATE hipo SET glu = ?, hora = ? WHERE idusuario = ? AND fecha = ? AND idcomida = 'comida'";
            $stmt = $conn->prepare($sql_hipo);
            $stmt->bind_param("ssss", $glu_comida, $hora_comida, $idusuario, $fecha);
            $stmt->execute();
            }
        } elseif ($hipo_hiper_comida == "HIPÉR") {

            if($_POST['GLU2_comida'] > 180){
            $glu_comida = $_POST['GLU2_comida'];
        }else{
            $hiperco = 'Solo se pueden insertar cantidades superiores a 180';
            $error = false;
        }
            $hora_comida = $_POST['HORA2_comida'];

            if($_POST['CORR_comida'] >= 0 && $_POST['CORR_comida'] <= 10){
                $corr_comida = $_POST['CORR_comida'];
            }else{
                $cocorr = 'Solo se puden insertar de 0-10 uds';
                $error = false;
            }
            if($error == true){
            $sql_hiper = "UPDATE hiper SET glu = ?, hora = ?, corr = ? WHERE idusuario = ? AND fecha = ? AND idcomida = 'comida'";
            $stmt = $conn->prepare($sql_hiper);
            $stmt->bind_param("sssss", $glu_comida, $hora_comida, $corr_comida, $idusuario, $fecha);
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
            $hora_cena = $_POST['HORA_cena'];
            if($error == true){
            $sql_hipo = "UPDATE hipo SET glu = ?, hora = ? WHERE idusuario = ? AND fecha = ? AND idcomida = 'cena'";
            $stmt = $conn->prepare($sql_hipo);
            $stmt->bind_param("ssss", $glu_cena, $hora_cena, $idusuario, $fecha);
            $stmt->execute();
            }
        } elseif ($hipo_hiper_cena == "HIPÉR") {

            if($_POST['GLU2_cena'] > 180){
                $glu_cena = $_POST['GLU2_cena'];
            }else{
                $hiperce = 'Solo se pueden insertar cantidades superiores a 180';
                $error = false;
            }

            $hora_cena = $_POST['HORA2_cena'];

            if($_POST['CORR_cena'] >= 0 && $_POST['CORR_cena'] <= 10){
                $corr_cena = $_POST['CORR_cena'];
            }else{
                $cecorr = 'Solo se puden insertar de 0-10 uds';
                $error = false;
            }
            if($error == true){
            $sql_hiper = "UPDATE hiper SET glu = ?, hora = ?, corr = ? WHERE idusuario = ? AND fecha = ? AND idcomida = 'cena'";
            $stmt = $conn->prepare($sql_hiper);
            $stmt->bind_param("sssss", $glu_cena, $hora_cena, $corr_cena, $idusuario, $fecha);
            $stmt->execute();
            $stmt->close();
        $conn->close();
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

<h2>Ingresa la fecha del registro que quieras modificar</h2> 
    <label for="fecha">Fecha:</label>
    <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>" required><br><br>
    <button type="submit" name="consultar">Consultar</button> <br>
<?php if(isset($_POST['fecha']) && !isset($mensajefech)) {?>
    <br>
    <label for="mealType">Selecciona el tipo de comida:</label>
    <select name="mealType" id="mealType" onchange="showFields()">
        <option value="desayuno">Desayuno</option>
        <option value="comida">Comida</option>
        <option value="cena">Cena</option>
    </select><br><br>

    
    <fieldset id="desayunoFields" style="display:none;">
        <legend>Desayuno</legend>
        <label for="GLH1">GL/H1:</label>
        <input type="text" id="GLH1" name="desayuno_GLH1" value="<?php echo $gl1h_desayuno; ?>"><?php if(isset($deglh1)){echo "<span><br> *$deglh1</span>";}?><br><br>

        <label for="RAC">RAC:</label>
        <input type="text" id="RAC" name="desayuno_RAC" value="<?php echo $rac_desayuno; ?>"><?php if(isset($derac)){echo "<span><br> *$derac</span>";}?><br><br>

        <label for="INSU">INSU:</label>
        <input type="text" id="INSU" name="desayuno_INSU" value="<?php echo $insu_desayuno; ?>"><?php if(isset($desinsu)){echo "<span><br> *$desinsu</span>";}?><br><br>

        <label for="GLH2">GL/H2:</label>
        <input type="text" id="GLH2" name="desayuno_GLH2" value="<?php echo $glh2_desayuno; ?>"><?php if(isset($deglh2)){echo "<span><br> *$deglh2</span>";}?><br><br>

        
        <div id="hipo_hiper_desayuno" style="display:none;">
            <label>Selecciona una opción para HIPO/HIPÉR:</label><br>
            <input type="radio" id="HIPO_desayuno" name="hipo_hiper_desayuno" value="HIPO" onclick="toggleFields('desayuno')"> HIPO
            <input type="radio" id="HIPÉR_desayuno" name="hipo_hiper_desayuno" value="HIPÉR" onclick="toggleFields('desayuno')"> HIPÉR<br><br>

            
            <div id="hipoFields_desayuno" style="display:none;">
                <label for="GLU_desayuno">GLU:</label>
                <input type="text" id="GLU_desayuno" name="GLU_desayuno" value="<?php echo $glu_desayuno; ?>"><?php if(isset($hipodes)){echo "<span><br> *$hipodes</span>";}?><br><br>

                <label for="HORA_desayuno">HORA:</label>
                <input type="time" id="HORA_desayuno" name="HORA_desayuno" value="<?php echo $hora_desayuno; ?>"><br><br>
            </div>

            <div id="hiperFields_desayuno" style="display:none;">
                <label for="GLU_desayuno">GLU:</label>
                <input type="text" id="GLU2_desayuno" name="GLU2_desayuno" value="<?php echo $glu_desayuno_hiper; ?>"><?php if(isset($hiperdes)){echo "<span><br> *$hiperdes</span>";}?><br><br>

                <label for="HORA_desayuno">HORA:</label>
                <input type="time" id="HORA2_desayuno" name="HORA2_desayuno" value="<?php echo $hora_desayuno_hiper; ?>"><br><br>

                <label for="CORR_desayuno">CORR:</label>
                <input type="text" id="CORR_desayuno" name="CORR_desayuno" value="<?php echo $corr_desayuno; ?>"><?php if(isset($descorr)){echo "<span><br> *$descorr</span>";}?><br><br>
            </div>
        </div>
    </fieldset>

    
    <fieldset id="comidaFields" style="display:none;">
        <legend>Comida</legend>
        <label for="GLH1">GL/H1:</label>
        <input type="text" id="GLH1" name="comida_GLH1" value="<?php echo $gl1h_comida; ?>"><?php if(isset($coglh1)){echo "<span><br> *$coglh1</span>";}?><br><br>

        <label for="RAC">RAC:</label>
        <input type="text" id="RAC" name="comida_RAC" value="<?php echo $rac_comida; ?>"><?php if(isset($corac)){echo "<span><br> *$corac</span>";}?><br><br>

        <label for="INSU">INSU:</label>
        <input type="text" id="INSU" name="comida_INSU" value="<?php echo $insu_comida; ?>"><?php if(isset($coinsu)){echo "<span><br> *$coinsu</span>";}?><br><br>

        <label for="GLH2">GL/H2:</label>
        <input type="text" id="GLH2" name="comida_GLH2" value="<?php echo $glh2_comida; ?>"><?php if(isset($coglh2)){echo "<span><br> *$coglh2</span>";}?><br><br>

        
        <div id="hipo_hiper_comida" style="display:none;">
            <label>Selecciona una opción para HIPO/HIPÉR:</label><br>
            <input type="radio" id="HIPO_comida" name="hipo_hiper_comida" value="HIPO" onclick="toggleFields('comida')"> HIPO
            <input type="radio" id="HIPÉR_comida" name="hipo_hiper_comida" value="HIPÉR" onclick="toggleFields('comida')"> HIPÉR<br><br>

            
            <div id="hipoFields_comida" style="display:none;">
                <label for="GLU_comida">GLU:</label>
                <input type="text" id="GLU_comida" name="GLU_comida" value="<?php echo $glu_comida; ?>"><?php if(isset($hipoco)){echo "<span><br> *$hipoco</span>";}?><br><br>

                <label for="HORA_comida">HORA:</label>
                <input type="time" id="HORA_comida" name="HORA_comida" value="<?php echo $hora_comida; ?>"><br><br>
            </div>

            <div id="hiperFields_comida" style="display:none;">
                <label for="GLU_comida">GLU:</label>
                <input type="text" id="GLU2_comida" name="GLU2_comida" value="<?php echo $glu_comida_hiper; ?>"><?php if(isset($hiperco)){echo "<span><br> *$hiperco</span>";}?><br><br>

                <label for="HORA_comida">HORA:</label>
                <input type="time" id="HORA2_comida" name="HORA2_comida" value="<?php echo $hora_comida_hiper; ?>"><br><br>

                <label for="CORR_comida">CORR:</label>
                <input type="text" id="CORR_comida" name="CORR_comida" value="<?php echo $corr_comida; ?>"><?php if(isset($cocorr)){echo "<span><br> *$cocorr</span>";}?><br><br>
            </div>
        </div>
    </fieldset>

    
    <fieldset id="cenaFields" style="display:none;">
        <legend>Cena</legend>
        <label for="GLH1">GL/H1:</label>
        <input type="text" id="GLH1" name="cena_GLH1" value="<?php echo $gl1h_cena; ?>"><?php if(isset($ceeglh1)){echo "<span><br> *$ceeglh1</span>";}?><br><br>

        <label for="RAC">RAC:</label>
        <input type="text" id="RAC" name="cena_RAC" value="<?php echo $rac_cena; ?>"><?php if(isset($cerac)){echo "<span><br> *$cerac</span>";}?><br><br>

        <label for="INSU">INSU:</label>
        <input type="text" id="INSU" name="cena_INSU" value="<?php echo $insu_cena; ?>"><?php if(isset($ceinsu)){echo "<span><br> *$ceinsu</span>";}?><br><br>

        <label for="GLH2">GL/H2:</label>
        <input type="text" id="GLH2" name="cena_GLH2" value="<?php echo $glh2_cena; ?>"><?php if(isset($ceeglh2)){echo "<span><br> *$ceeglh2</span>";}?><br><br>

        
        <div id="hipo_hiper_cena" style="display:none;">
            <label>Selecciona una opción para HIPO/HIPÉR:</label><br>
            <input type="radio" id="HIPO_cena" name="hipo_hiper_cena" value="HIPO" onclick="toggleFields('cena')"> HIPO
            <input type="radio" id="HIPÉR_cena" name="hipo_hiper_cena" value="HIPÉR" onclick="toggleFields('cena')"> HIPÉR<br><br>

            
            <div id="hipoFields_cena" style="display:none;">
                <label for="GLU_cena">GLU:</label>
                <input type="text" id="GLU_cena" name="GLU_cena" value="<?php echo $glu_cena; ?>"><?php if(isset($hipoce)){echo "<span><br> *$hipoce</span>";}?><br><br>

                <label for="HORA_cena">HORA:</label>
                <input type="time" id="HORA_cena" name="HORA_cena" value="<?php echo $hora_cena; ?>"><br><br>
            </div>

            <div id="hiperFields_cena" style="display:none;">
                <label for="GLU_cena">GLU:</label>
                <input type="text" id="GLU2_cena" name="GLU2_cena" value="<?php echo $glu_cena_hiper; ?>"><?php if(isset($hiperce)){echo "<span><br> *$hiperce</span>";}?><br><br>

                <label for="HORA_cena">HORA:</label>
                <input type="time" id="HORA2_cena" name="HORA2_cena" value="<?php echo $hora_cena_hiper; ?>"><br><br>

                <label for="CORR_cena">CORR:</label>
                <input type="text" id="CORR_cena" name="CORR_cena" value="<?php echo $corr_cena; ?>"><?php if(isset($cecorr)){echo "<span><br> *$cecorr</span>";}?><br><br>
            </div>
        </div>
    </fieldset>

    
    <label for="LENTA">LENTA:</label>
    <input type="text" id="LENTA" name="LENTA" value="<?php echo $lenta; ?>"><?php if(isset($elenta)){echo "<span><br> *$elenta</span>";}?><br><br>

    <label for="DEPORTE">DEPORTE:</label>
    <input type="text" id="DEPORTE" name="DEPORTE" value="<?php echo $deporte; ?>"><?php if(isset($edeporte)){echo "<span><br> *$edeporte</span>";}?><br><br>

    
    <button type="submit" name="actualizar">Actualizar</button>
    <?php

        if(isset($_POST['actualizar']) && $error == true){echo "Datos modificados correctamente";}elseif(isset($_POST['actualizar']) && $error == false){echo "No se han podido modificar los datos";}

?>
    <?php }elseif(isset($mensajefech)){echo $mensajefech;}else{echo '';}?>
   
</form>

</body>
</html>
