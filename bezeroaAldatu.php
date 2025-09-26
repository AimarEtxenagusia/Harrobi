<?php
require "konexioa.php";
require 'session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $izena = $_POST['bezeroaIzena'];
    $abizena = $_POST['bezeroaAbizena'];
    $email = $_POST['bezeroaEmail'];
    $pasahitza = $_POST['bezeroaPasahitza'];
    $nan = $_POST['bezeroaNan'];
    $instalazioa = $_POST['bezeroaInstalazioa'];

    $stmt = $conn->prepare("UPDATE bezeroa SET izena = ?, abizena = ?, email = ?, pasahitza = ?, nan = ?, instalazioa = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $izena, $abizena, $email, $pasahitza, $nan, $instalazioa, $id);

    if ($stmt->execute()) {
        header("Location: bezeroa.php");
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

    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}


?>

<!DOCTYPE html>

<head>
</head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hasiera</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/taulak.css">
<link rel="stylesheet" href="css/form.css">
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="bezeroa.php"><img src="img/harrobi2.png" alt="Logo" class="logo"
                style="height: 85px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="langilea.php">Langileak</a></li>
                <li class="nav-item"><a class="nav-link active" href="bezeroa.php">Bezeroak</a></li>
                <li class="nav-item"><a class="nav-link" href="instalazioak.php">Instalazioak</a></li>
            </ul>
            <a href="perfila.php" style="text-decoration: none;">
                <span class="navbar-text text-white me-3">
                    <?= htmlspecialchars($user['izena']) . ' ' . htmlspecialchars($user['abizena']) ?>
                </span>
            </a>
            <a href="index.php" class="btn btn-outline-light btn-sm">Saioa Itxi</a>
        </div>
    </nav>
    <h1>BEZEROA ALDATU</h1>
    <form action="bezeroaAldatu.php" method="post">

        <label for="name">IZENA</label>
        <input type="text" name="bezeroaIzena" value="<?php echo $row['izena'] ?>" required>
        <label for="name">ABIZENA</label>
        <input type="text" name="bezeroaAbizena" value="<?php echo $row['abizena'] ?>" required>
        <label for="name">EMAIL-A</label>
        <input type="text" name="bezeroaEmail" value="<?php echo $row['email'] ?>" required>
        <label for="name">PASAHITZA</label>
        <input type="text" name="bezeroaPasahitza" value="<?php echo $row['pasahitza'] ?>" required>
        <label for="name">NAN-A</label>
        <input type="text" name="bezeroaNan" value="<?php echo $row['nan'] ?>" required>
        <label for="name">INSTALAZIOAREN IZENA</label>
        <select name="bezeroaInstalazioa" required>
            <?php
            while ($instalazioa = $instalazioak_result->fetch_assoc()) {
                $selected = ($instalazioa['izena'] == $row['instalazioa']) ? "selected" : "";
                echo "<option value='" . $instalazioa['izena'] . "' $selected>" . $instalazioa['izena'] . "</option>";
            }
            ?>
        </select>
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <input type="submit" value="ALDATU">
        <a class="btn-cancel" href="bezeroa.php">ITZULI</a>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>