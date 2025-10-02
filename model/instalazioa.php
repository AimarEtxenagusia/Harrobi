<?php
// Instalazioa klasea: instalazio bakoitzeko datuak eta DB-rekin CRUD operazioak
class Instalazioa
{
    public $id;
    public $izena;

    // Objektua sortzerakoan datuak ezartzeko
    public function __construct($id, $izena)
    {
        $this->id = $id;
        $this->izena = $izena;
    }

    // ID lortu eta ezarri
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    // Izena lortu eta ezarri
    public function getIzena()
    {
        return $this->izena;
    }
    public function setIzena($izena)
    {
        $this->izena = $izena;
    }

    // DB-tik instalazio guztiak ekarri
    public static function ikusiInstalazioa($conn)
    {
        $instalazioak = []; // hemen gordeko ditugu objektuak
        $sql = "SELECT * FROM instalazioa";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $instalazioa = new Instalazioa(
                    $row["id"],
                    $row["izena"]
                );
                $instalazioak[] = $instalazioa; // gehitu array-ra
            }
        }
        return $instalazioak; // array osoa itzuli
    }

    // Instalazio berria gehitu DB-ra
    public static function gehituInstalazioa($conn, $izena)
    {
        $stmt = $conn->prepare("INSERT INTO instalazioa (izena) VALUES (?)");
        $stmt->bind_param("s", $izena);
        if ($stmt->execute()) {
            header("Location: ../instalazioa/instalazioak.php"); // joan listara
        } else {
            echo '<div class="alert alert-danger mt-3">Errorea: ' . $stmt->error . '</div>';
        }
    }

    // Instalazioa aldatu
    public static function aldatuInstalazioa($conn, $izena, $id)
    {
        $stmt = $conn->prepare("UPDATE instalazioa SET izena = ? WHERE id = ?");
        $stmt->bind_param("si", $izena, $id);

        if ($stmt->execute()) {
            header("Location: ../instalazioa/instalazioak.php"); // bueltatu listara
        } else {
            $textuaInstalazioa = "Errorea: " . $stmt->error;
        }
    }

    // Instalazioa ezabatu
    public static function ezabatuInstalazioa($conn, $id)
    {
        $sql = "DELETE FROM instalazioa WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header("Location: ../instalazioa/instalazioak.php"); // bueltatu listara
            } else {
                echo "Errorea: " . $stmt->error;
            }
        } else {
            echo "Errorea prestatzean: " . $conn->error;
        }
    }
}
?>