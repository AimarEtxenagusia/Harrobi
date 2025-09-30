<?php

class Bezeroak
{
    public $id;
    public $izena;
    public $abizena;
    public $email;
    public $pasahitza;
    public $nan;
    public $instalazioa;

    public function __construct($id = null, $izena = null, $abizena = null, $email = null, $pasahitza = null, $nan = null, $instalazioa = null)
    {
        $this->id = $id;
        $this->izena = $izena;
        $this->abizena = $abizena;
        $this->email = $email;
        $this->pasahitza = $pasahitza;
        $this->nan = $nan;
        $this->instalazioa = $instalazioa;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIzena()
    {
        return $this->izena;
    }
    public function setIzena($izena)
    {
        $this->izena = $izena;
    }

    public function getAbizena()
    {
        return $this->abizena;
    }
    public function setAbizena($abizena)
    {
        $this->abizena = $abizena;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPasahitza()
    {
        return $this->pasahitza;
    }
    public function setPasahitza($pasahitza)
    {
        $this->pasahitza = $pasahitza;
    }

    public function getNan()
    {
        return $this->nan;
    }
    public function setNan($nan)
    {
        $this->nan = $nan;
    }

    public function getInstalazioa()
    {
        return $this->instalazioa;
    }
    public function setInstalazioa($instalazioa)
    {
        $this->instalazioa = $instalazioa;
    }

    public static function ikusiBezeroak($conn)
    {
        $bezeroak = [];
        $sql = "SELECT * FROM bezeroa";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bezero = new Bezeroak(
                    $row['id'],
                    $row['izena'],
                    $row['abizena'],
                    $row['email'],
                    $row['pasahitza'],
                    $row['nan'],
                    $row['instalazioa']
                );
                $bezeroak[] = $bezero;
            }
        }
        return $bezeroak;
    }

    public static function gehituBezeroa($conn, $izena, $abizena, $email, $pasahitza, $nan, $instalazioa)
    {
        $stmt = $conn->prepare("INSERT INTO bezeroa (izena, abizena, email, pasahitza, nan, instalazioa) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $izena, $abizena, $email, $pasahitza, $nan, $instalazioa);
        if ($stmt->execute()) {
            header("Location: ../bezeroa/bezeroa.php");
        } else {
            echo '<div class="alert alert-danger mt-3">Errorea: ' . $stmt->error . '</div>';
        }
    }

    public static function aldatuBezeroa($conn, $izena, $abizena, $email, $pasahitza, $nan, $instalazioa, $id)
    {
        $stmt = $conn->prepare("UPDATE bezeroa SET izena = ?, abizena = ?, email = ?, pasahitza = ?, nan = ?, instalazioa = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $izena, $abizena, $email, $pasahitza, $nan, $instalazioa, $id);
        if ($stmt->execute()) {
            header("Location: ../bezeroa/bezeroa.php");
        } else {
            echo '<div class="alert alert-danger mt-3">Errorea: ' . $stmt->error . '</div>';
        }
    }

    public static function ezabatuBezeroa($conn, $id)
    {
        $stmt = $conn->prepare('DELETE FROM instalazioa WHERE id = ?');
        $sql = "DELETE FROM bezeroa WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header("Location: ../bezeroa/bezeroa.php");
            } else {
                echo "Errorea: " . $stmt->error;
            }
        } else {
            echo "Errorea gertatu da prestatzerako orduan: " . $conn->error;
        }
    }

    public static function aurkituBezeroa($conn, $id)
    {
        $stmt = $conn->prepare("SELECT izena, abizena, email, pasahitza, nan, instalazioa FROM bezeroa WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

}
?>