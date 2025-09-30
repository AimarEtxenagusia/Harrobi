<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand animate__animated animate__slideInLeft" href="bezeroa.php"><img src="img/harrobi2.png"
            alt="Logo" class="logo" style="height:85px;"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="langilea.php">Langileak</a></li>
            <li class="nav-item"><a class="nav-link" href="bezeroa.php">Bezeroak</a></li>
            <li class="nav-item"><a class="nav-link" href="instalazioak.php">Instalazioak</a></li>
        </ul>
        <a href="perfila.php" style="text-decoration: none;">
            <span class="navbar-text text-white me-3">
                <?= $user['izena'] . ' ' . $user['abizena'] ?>
            </span>
        </a>
        <a href="index.php" class="btn btn-outline-light btn-sm">Saioa Itxi</a>
    </div>
</nav>