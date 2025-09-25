<?php
require "konexioa.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $izenaInstalazioa = $_POST['instalazioIzena'];

    if (empty($izenaInstalazioa)) {
        echo "Sartu izen bat!";
    } else {
        $stmt = $conn->prepare("UPDATE instalazioa SET izena = ? WHERE id = ?");
        $stmt->bind_param("si", $izenaInstalazioa, $id);

        if ($stmt->execute()) {
            header("Location: instalazioak.php");
            exit;
        } else {
            echo "Errorea: " . $stmt->error;
        }
    }
} else {
    $id = $_GET['id'];

    $sql = "SELECT izena FROM instalazioa WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        die("Ez da instalaziorik aurkitu");
    }
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
            </ul>
        </nav>


    </nav>
    <h1>INSTALAZIO BERRIA</h1>
    <form action="instalazioaAldatu.php" method="post">

        <label for="name">INSTALAZIOAREN IZENA</label>
        <input type="text" name="instalazioIzena" value="<?php echo $row['izena'] ?>" required>
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <input type="submit" value="ALDATU">
        <a class="btn-cancel" href="instalazioak.php">ITZULI</a>
    </form>
</body>

</html>