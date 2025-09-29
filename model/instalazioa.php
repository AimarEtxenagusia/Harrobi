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
}
?>