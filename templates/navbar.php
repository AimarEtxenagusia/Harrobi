<?php
// Gaurko erabiltzailearen datuak hartu
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT izena, abizena, rol FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!-- Nagusiko navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <!-- Logo animatua -->
    <a class="navbar-brand animate__animated animate__slideInLeft" href="../bezeroa/bezeroa.php">
        <img src="../img/harrobi2.png" alt="Logo" class="logo" style="height:85px;">
    </a>
    
    <!-- Toggler botoia mobilerako -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menua -->
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <!-- Langileak esteka, rola kontuan hartuta -->
            <li class="nav-item">
                <a class="nav-link" 
                    <?php if($user["rol"] == "admin"){ echo 'href="../langilea/langileaAdmin.php"'; } else { echo 'href="../langilea/langilea.php"'; } ?> >
                    Langileak
                </a>
            </li>
            <!-- Beste estekak -->
            <li class="nav-item"><a class="nav-link" href="../bezeroa/bezeroa.php">Bezeroak</a></li>
            <li class="nav-item"><a class="nav-link" href="../instalazioa/instalazioak.php">Instalazioak</a></li>
        </ul>

        <!-- Erabiltzailearen izena eta rola -->
        <a href="../perfila/perfila.php" style="text-decoration: none;">
            <span class="navbar-text text-white me-3" style="opacity: 0.7; color: black;">
                <?= $user['izena'] . ' ' . $user['abizena'] ?><?php if($user["rol"] == "admin"){ echo ' - Administraria'; } else { echo ' - Langilea'; } ?>
            </span>
        </a>

        <!-- Logout botoia animatua -->
        <a href="../session/logout.php" class="btn btn-outline-light btn-sm animate__animated animate__flash">Saioa Itxi</a>
    </div>
</nav>
