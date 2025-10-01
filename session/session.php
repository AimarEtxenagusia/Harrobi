<?php
    session_start();

    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']) || !isset($_SESSION['user_abizena'])) {
        session_destroy();
        header('Location: /Ariketak%20vsCode/Harrobi/index.php');
        exit;
    }
?>  