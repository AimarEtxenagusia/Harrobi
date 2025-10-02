<?php
// Saioa hasi
session_start();

// Kontrola: erabiltzailearen datuak dauden egiaztatu
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']) || !isset($_SESSION['user_abizena'])) {
    // Ez badaude, saioa itxi eta loginera bidali
    session_destroy();
    header('Location: /Ariketak%20vsCode/Harrobi/index.php');
    exit;
}
?>
