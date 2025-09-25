<?php
require 'konexioa.php';

$stmt = $conn->prepare('DELETE FROM instalazioa WHERE id = ?');

$sql = "DELETE FROM bezeroa WHERE id = ?";

$id = $_GET['id'];

if ($stmt = $conn->prepare($sql)) {


    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: index.php");
        exit;
    } else {
        echo "Errorea: " . $stmt->error;
    }
} else {
    echo "Errorea gertatu da prestatzerako orduan: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ezabatu Bezeroa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6VKHr8z2mbx5l1Z9gqG1skCkP0r5hXQ6tZTt3M1QF0k0" crossorigin="anonymous">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/taulak.css">
    <link rel="stylesheet" href="css/form.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Aquí puedes agregar contenido si lo deseas -->
</body>
</html>