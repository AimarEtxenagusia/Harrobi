<?php
require 'konexioa.php';

$stmt = $conn->prepare('DELETE FROM instalazioa WHERE id = ?');

$sql = "DELETE FROM bezeroa WHERE id = ?";

$id = $_GET['id'];

if ($stmt = $conn->prepare($sql)) {


    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: bezeroa.php");
        exit;
    } else {
        echo "Errorea: " . $stmt->error;
    }
} else {
    echo "Errorea gertatu da prestatzerako orduan: " . $conn->error;
}
?>