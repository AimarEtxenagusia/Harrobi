<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']) || !isset($_SESSION['user_abizena'])) {
    header('Location: index.php');
    exit;
}
?>  