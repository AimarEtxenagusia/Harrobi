<?php

$servername = "localhost"; // zerbitzariaren izena
$username = "root"; // DB erabiltzailea
$password = ""; // DB pasahitza
$dbname = "harrobi"; // DB izena

$conn = new mysqli($servername, $username, $password, $dbname); // konexioa sortu

if ($conn->connect_error) {
    die("Errorea konexioa gauzatzean" . $conn->connect_error); // errorea egonez gero, gelditu
}

?>