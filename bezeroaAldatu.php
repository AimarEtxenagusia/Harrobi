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

    if (empty($izena) || empty($abizena) || empty($email) || empty($pasahitza) || empty($nan)) {
        echo "Bete hutsune guztiak!";
    } else {
        $stmt = $conn->prepare("UPDATE bezeroa SET izena = ?, abizena = ?, email = ?, pasahitza = ?, nan = ?, instalazioa = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $izena, $abizena, $email, $pasahitza, $nan, $instalazioa, $id);

        if ($stmt->execute()) {
            header("Location: bezeroa.php");
            exit;
        } else {
            echo "Errorea: " . $stmt->error;
        }
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasiera</title>
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
                <li><a href="bezeroa.php">Bezeroak</a></li>
                <li><a href="instalazioak.php">Instalazioak</a></li>
                <li><a href="index.php">Saioa Itxi</a></li>
            </ul>
        </nav>


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
</body>

</html>