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

}
?>