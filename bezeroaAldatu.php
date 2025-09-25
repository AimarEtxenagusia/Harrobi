<?php
require "konexioa.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $izena = $_POST['bezeroaIzena'];
    $abizena = $_POST['bezeroaAbizena'];
    $email = $_POST['bezeroaEmail'];
    $pasahitza = $_POST['bezeroaPasahitza'];
    $nan = $_POST['bezeroaNan'];
    $instalazioa = $_POST['bezeroaInstalazioa'];

    // Validaciones solo visuales con Bootstrap, no mostrar mensajes PHP
    $stmt = $conn->prepare("UPDATE bezeroa SET izena = ?, abizena = ?, email = ?, pasahitza = ?, nan = ?, instalazioa = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $izena, $abizena, $email, $pasahitza, $nan, $instalazioa, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Errorea: " . $stmt->error;
    }
} else {
    $id = $_GET['id'];

    $sql = "SELECT izena, abizena, email, pasahitza, nan, instalazioa FROM bezeroa WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        die("Ez da bezerorik aurkitu");
    }

    $instalazioak_sql = "SELECT id, izena FROM instalazioa";
    $instalazioak_result = $conn->query($instalazioak_sql);

}


?>

<!DOCTYPE html>

<head>
</head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasiera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6VKHr8z2mbx5l1Z9gqG1skCkP0r5hXQ6tZTt3M1QF0k0" crossorigin="anonymous">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/taulak.css">
    <link rel="stylesheet" href="css/form.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>
    <nav>
        <nav class="navbar">
            <img src="img/harrobi.png" alt="Logo" class="logo">
            <ul>
                <li><a href="index.php">Bezeroak</a></li>
                <li><a href="instalazioak.php">Instalazioak</a></li>
            </ul>
        </nav>


    </nav>
    <h1>BEZEROA ALDATU</h1>
    <form action="bezeroaAldatu.php" method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="bezeroaIzena" class="form-label">IZENA</label>
            <input type="text" class="form-control" id="bezeroaIzena" name="bezeroaIzena" value="<?php echo $row['izena'] ?>" required>
            <div class="invalid-feedback alert alert-danger p-2 mt-2 d-none">Sartu izen bat!</div>
        </div>
        <div class="mb-3">
            <label for="bezeroaAbizena" class="form-label">ABIZENA</label>
            <input type="text" class="form-control" id="bezeroaAbizena" name="bezeroaAbizena" value="<?php echo $row['abizena'] ?>" required>
            <div class="invalid-feedback alert alert-danger p-2 mt-2 d-none">Sartu abizen bat!</div>
        </div>
        <div class="mb-3">
            <label for="bezeroaEmail" class="form-label">EMAIL-A</label>
            <input type="email" class="form-control" id="bezeroaEmail" name="bezeroaEmail" value="<?php echo $row['email'] ?>" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Idatzi email formatu zuzena (adibidez: uni@uni.eus)">
            <div class="invalid-feedback alert alert-danger p-2 mt-2 d-none">Idatzi email formatu zuzena (adibidez: uni@uni.eus)</div>
        </div>
        <div class="mb-3">
            <label for="bezeroaPasahitza" class="form-label">PASAHITZA</label>
            <input type="password" class="form-control" id="bezeroaPasahitza" name="bezeroaPasahitza" value="<?php echo $row['pasahitza'] ?>" required>
            <div class="invalid-feedback alert alert-danger p-2 mt-2 d-none">Sartu pasahitza!</div>
        </div>
        <div class="mb-3">
            <label for="bezeroaNan" class="form-label">NAN-A</label>
            <input type="text" class="form-control" id="bezeroaNan" name="bezeroaNan" value="<?php echo $row['nan'] ?>" required pattern="^[0-9]{8}[A-Za-z]$" title="Idatzi 8 zenbaki eta letra bat (adibidez: 12345678F)">
            <div class="invalid-feedback alert alert-danger p-2 mt-2 d-none">NAN formatu okerra! Idatzi 8 zenbaki eta letra bat (adibidez: 12345678F)</div>
        </div>
        <div class="mb-3">
            <label for="bezeroaInstalazioa" class="form-label">INSTALAZIOAREN IZENA</label>
            <select class="form-select" id="bezeroaInstalazioa" name="bezeroaInstalazioa" required>
                <option value="">Aukeratu instalazioa</option>
                <?php
                while ($instalazioa = $instalazioak_result->fetch_assoc()) {
                    $selected = ($instalazioa['id'] == $row['instalazioa']) ? "selected" : "";
                    echo "<option value='" . $instalazioa['id'] . "' $selected>" . $instalazioa['izena'] . "</option>";
                }
                ?>
            </select>
            <div class="invalid-feedback alert alert-danger p-2 mt-2 d-none">Aukeratu instalazio bat!</div>
        </div>
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <button type="submit" class="btn btn-primary">ALDATU</button>
        <a class="btn btn-secondary ms-2"id="btn-cancel" href="index.php">ITZULI</a>
    </form>
    <script>
        // Bootstrap validation con alertas visibles solo si el campo es inválido
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                        // Mostrar las alertas solo en los campos inválidos
                        const invalids = form.querySelectorAll(':invalid');
                        invalids.forEach(input => {
                            const feedback = input.parentElement.querySelector('.invalid-feedback');
                            if (feedback) {
                                feedback.classList.remove('d-none');
                            }
                        });
                    }
                    form.classList.add('was-validated');
                }, false);
                // Ocultar alertas al corregir el campo
                form.querySelectorAll('input, select').forEach(input => {
                    input.addEventListener('input', () => {
                        if (input.checkValidity()) {
                            const feedback = input.parentElement.querySelector('.invalid-feedback');
                            if (feedback) {
                                feedback.classList.add('d-none');
                            }
                        }
                    });
                });
            });
        })();
    </script>
</body>

</html>