<?php
    session_start();
    session_unset();
    session_destroy();

    header("Location: /Ariketak%20vsCode/Harrobi/index.php");
    exit();
?>