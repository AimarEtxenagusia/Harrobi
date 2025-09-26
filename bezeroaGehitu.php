<?php
include "konexioa.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $izena = trim($_POST['bezeroaIzena']);
    $abizena = trim($_POST['bezeroaAbizena']);
    $email = trim($_POST['bezeroaEmail']);
    $pasahitza = trim($_POST['bezeroaPasahitza']);
    $nan = trim($_POST['bezeroaNan']);
    $instalazioa_id = $_POST['bezeroaInstalazioa'];
    $instalazioa_query = "SELECT izena FROM instalazioa WHERE id = '$instalazioa_id'";
    $instalazioa_result = $conn->query($instalazioa_query);
    $instalazioa = "";
    if ($instalazioa_result && $instalazioa_result->num_rows > 0) {
        $instalazioa_row = $instalazioa_result->fetch_assoc();
        $instalazioa = $instalazioa_row['izena'];
    }

    $errores = [];
    if (empty($izena)) {
        $errores[] = "El campo 'Nombre' es obligatorio.";
    }
    if (empty($abizena)) {
        $errores[] = "El campo 'Apellido' es obligatorio.";
    }
    if (empty($email)) {
        $errores[] = "El campo 'Email' es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }
    if (empty($pasahitza)) {
        $errores[] = "El campo 'Contraseña' es obligatorio.";
    }
    if (empty($nan)) {
        $errores[] = "El campo 'DNI' es obligatorio.";
    } elseif (!preg_match('/^[0-9]{8}[A-Za-z]$/', $nan)) {
        $errores[] = "El DNI debe tener 8 números y una letra (ejemplo: 12345678A).";
    }
    if (empty($instalazioa_id)) {
        $errores[] = "Debes seleccionar una instalación.";
    }

    if (count($errores) === 0) {
        $sql = "INSERT INTO bezeroa (izena, abizena, email, pasahitza, nan, instalazioa) VALUES ('$izena', '$abizena', '$email', '$pasahitza','$nan', '$instalazioa')";
        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success mt-3">Bezeroa ondo gehitu da!</div>';
        } else {
            echo '<div class="alert alert-danger mt-3">Errorea: ' . mysqli_error($conn) . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger mt-3"><ul class="mb-0">';
        foreach ($errores as $err) {
            echo '<li>' . $err . '</li>';
        }
        echo '</ul></div>';
    }
} else {
    // Instalazioak lortzeko SQL kontsulta
    $instalazioak_sql = "SELECT * FROM instalazioa";
    $instalazioak_result = $conn->query($instalazioak_sql);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BEZEROA GEHITU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6VKHr8z2mbx5l1Z9gqG1skCkP0r5hXQ6tZTt3M1QF0k0" crossorigin="anonymous">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/taulak.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/btn.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <nav class="navbar">
            <img src="img/harrobi.png" alt="Logo" class="logo">
            <ul>
                <li><a href="bezeroa.php">Bezeroak</a></li>
                <li><a href="instalazioak.php">Instalazioak</a></li>
                <li><a href="index.php">Saioa Itxi</a></li>
            </ul>
        </nav>


    </nav>
    <h1>Bezeroa Gehitu</h1>
    <form action="" method="post" class="needs-validation" novalidate>
        
            <label for="bezeroaIzena" class="form-label">IZENA <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="bezeroaIzena" name="bezeroaIzena" required>
      
        
            <label for="bezeroaAbizena" class="form-label">ABIZENA <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="bezeroaAbizena" name="bezeroaAbizena" required>
           
        
            <label for="bezeroaEmail" class="form-label">EMAIL-A <span style="color:red">*</span></label>
            <input type="email" class="form-control" id="bezeroaEmail" name="bezeroaEmail" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Idatzi email formatu zuzena (adibidez: uni@uni.eus)">
            
       
            <label for="bezeroaPasahitza" class="form-label">PASAHITZA <span style="color:red">*</span></label>
            <input type="password" class="form-control" id="bezeroaPasahitza" name="bezeroaPasahitza" required>
   
            <label for="bezeroaNan" class="form-label">NAN-A <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="bezeroaNan" name="bezeroaNan" required pattern="^[0-9]{8}[A-Za-z]$" title="Idatzi 8 zenbaki eta letra bat (adibidez: 12345678F)">
           
        
        
            <label for="bezeroaInstalazioa" class="form-label">INSTALAZIOAREN IZENA <span style="color:red">*</span></label>
            <select class="form-select" id="bezeroaInstalazioa" name="bezeroaInstalazioa" required>
                <option value="">Aukeratu instalazioa</option>
                <?php
                if (!isset($instalazioak_result) || !$instalazioak_result) {
                    $instalazioak_sql = "SELECT * FROM instalazioa";
                    $instalazioak_result = $conn->query($instalazioak_sql);
                }
                if ($instalazioak_result && $instalazioak_result->num_rows > 0) {
                    foreach ($instalazioak_result as $instalazioa) {
                        echo "<option value='" . $instalazioa['id'] . "'>" . $instalazioa['izena'] . "</option>";
                    }
                }
                ?>
            </select>
            
        
            
        
        
            <br><br>
        <div class="d-flex gap-2">
            <button type="submit" id="gehitu" class="btn btn-primary  w-100">GEHITU</button>
            <br><br>
            <button id="btn-cancel" class="btn btn-primary w-100" href="index.php">ITZULI</button> 
        </div>
       
    </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>


</body>

</html>