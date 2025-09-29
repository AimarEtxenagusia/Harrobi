<?php
class Instalazioa
{
    public $id;
    public $izena;

    public function __construct($id, $izena)
    {
        $this->id = $id;
        $this->izena = $izena;
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

    public static function ikusiInstalazioa($conn)
    {
        $sql = "SELECT * FROM instalazioa";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $instalazioa = new Instalazioa(
                    $row["id"],
                    $row["izena"]
                );
                $instalazioak[] = $instalazioa;
            }
        }
        return $instalazioak;
    }

    public static function gehituInstalazioa($conn, $izena)
    {
        $stmt = $conn->prepare("INSERT INTO instalazioa (izena) VALUES (?)");
        $stmt->bind_param("s", $izena);
        if ($stmt->execute()) {
            header("Location: instalazioak.php");
        } else {
            echo '<div class="alert alert-danger mt-3">Errorea: ' . $stmt->error . '</div>';
        }
    }

    public static function aldatuInstalazioa($conn, $izena, $id)
    {
        $stmt = $conn->prepare("UPDATE instalazioa SET izena = ? WHERE id = ?");
        $stmt->bind_param("si", $izena, $id);

        if ($stmt->execute()) {
            header("Location: instalazioak.php");
        } else {
            $textuaInstalazioa = "Errorea: " . $stmt->error;
        }
    }

    public static function ezabatuInstalazioa($conn, $id)
    {
        $stmt = $conn->prepare('DELETE FROM instalazioa WHERE id = ?');

        $sql = "DELETE FROM instalazioa WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
            header("Location: instalazioak.php");
            } else {
                echo "Errorea: " . $stmt->error;
            }
        } else {
            echo "Errorea gertatu da prestatzerako orduan: " . $conn->error;
        }
    }
}
?>