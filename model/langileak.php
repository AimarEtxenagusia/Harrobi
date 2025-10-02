<?php
// Langileak klasea: langile bakoitzeko datuak eta DB operazioak (CRUD)
class Langileak
{
    public $id;
    public $izena;
    public $abizena;
    public $email;
    public $pasahitza;
    public $nan;

    // Objektua sortzerakoan datuak ezartzeko
    public function __construct($id = null, $izena = null, $abizena = null, $email = null, $pasahitza = null, $nan = null)
    {
        $this->id = $id;
        $this->izena = $izena;
        $this->abizena = $abizena;
        $this->email = $email;
        $this->pasahitza = $pasahitza;
        $this->nan = $nan;
    }

    // ID lortu / ezarri
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    // Izena lortu / ezarri
    public function getIzena() { return $this->izena; }
    public function setIzena($izena) { $this->izena = $izena; }

    // Abizena lortu / ezarri
    public function getAbizena() { return $this->abizena; }
    public function setAbizena($abizena) { $this->abizena = $abizena; }

    // Email lortu / ezarri
    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    // Pasahitza lortu / ezarri
    public function getPasahitza() { return $this->pasahitza; }
    public function setPasahitza($pasahitza) { $this->pasahitza = $pasahitza; }

    // NAN lortu / ezarri
    public function getNan() { return $this->nan; }
    public function setNan($nan) { $this->nan = $nan; }

    // Langile berria gehitu
    public static function gehituLangilea($conn, $izena, $abizena, $email, $pasahitza, $nan)
    {
        $stmt = $conn->prepare("INSERT INTO langilea (izena, abizena, email, pasahitza, nan, rol) VALUES (?, ?, ?, ?, ?, 'user')");
        $stmt->bind_param("sssss", $izena, $abizena, $email, $pasahitza, $nan);
        if ($stmt->execute()) {
            header("Location: ../langilea/langileaAdmin.php");
        } else {
            echo '<div class="alert alert-danger mt-3">Errorea: ' . $stmt->error . '</div>';
        }
    }

    // Langile guztiak ekarri (user rolak bakarrik)
    public static function ikusiLangileak($conn)
    {
        $sql = "SELECT * FROM langilea";
        $result = $conn->query($sql);
        $langileak = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["rol"] == "user") {
                    $langile = new Langileak(
                        $row["id"],
                        $row["izena"],
                        $row["abizena"],
                        $row["email"],
                        $row["pasahitza"],
                        $row["nan"]
                    );
                    $langileak[] = $langile; // array-ra gehitu
                }
            }
        }
        return $langileak;
    }

    // Login egiteko
    public static function login($conn, $email, $pasahitza)
    {
        $stmt = $conn->prepare("SELECT id, izena, abizena, email, pasahitza FROM langilea WHERE email = ? AND pasahitza = ?");
        $stmt->bind_param("ss", $email, $pasahitza);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user'] = $row['izena'];
            $_SESSION['user_abizena'] = $row['abizena'];
            header("Location: bezeroa/bezeroa.php");
            exit;
        } else {
            $error_msg = "Datuak ez dira zuzenak";
        }
        return $error_msg;
    }

    // Perfila aldatu (egungo erabiltzailea)
    public static function aldatuPerfila($conn, $izena, $abizena, $email, $pasahitza, $nan, $id)
    {
        $stmt = $conn->prepare("UPDATE langilea SET izena = ?, abizena = ?, email = ?, pasahitza = ?, nan = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $izena, $abizena, $email, $pasahitza, $nan, $id);

        if ($stmt->execute()) {
            header("Location: ../index.php");
            exit;
        } else {
            echo "Errorea: " . $stmt->error;
        }
    }

    // Langilea aldatu (admin-ekin)
    public static function aldatuLangilea($conn, $izena, $abizena, $email, $pasahitza, $nan, $id)
    {
        $stmt = $conn->prepare("UPDATE langilea SET izena = ?, abizena = ?, email = ?, pasahitza = ?, nan = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $izena, $abizena, $email, $pasahitza, $nan, $id);
        if ($stmt->execute()) {
            header("Location: ../langilea/langileaAdmin.php");
        } else {
            echo '<div class="alert alert-danger mt-3">Errorea: ' . $stmt->error . '</div>';
        }
    }

    // Langilea ezabatu
    public static function ezabatuLangilea($conn, $id)
    {
        $stmt = $conn->prepare("DELETE FROM langilea WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: ../langilea/langileaAdmin.php");
            exit;
        } else {
            echo "Errorea: " . $stmt->error;
        }
    }

    // Langilea aurkitu ID bidez
    public static function aurkituLangilea($conn, $id)
    {
        $stmt = $conn->prepare("SELECT izena, abizena, email, pasahitza, nan FROM langilea WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
