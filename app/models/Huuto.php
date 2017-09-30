<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 22.9.2017
 * Time: 17:35
 */

class Huuto extends BaseModel
{
    public $id, $ilmoitus_id, $kayttaja_id, $hinta, $paiva, $nimi, $kayttajatunnus;

    public function __construct($attributes)
    {
        parent::__construct($attributes);

        $this->validators = array($this->validate_hinta());
    }

    public static function all()
    {
        $query = DB::connection()->prepare('SELECT * FROM Huuto');
        $query->execute();

        $rows = $query->fetchAll();
        $huudot = array();

        foreach ($rows as $row) {
            $huudot[] = new Huuto(array(
                'id' => $row['id'],
                'ilmoitus_id' => $row['ilmoitus_id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'hinta' => $row['hinta'],
                'paiva' => $row['paiva']
            ));
        }
        return $huudot;
    }

    public static function countIlmoituksenHuudot($ilmoitusId)
    {
        $query = DB::connection()->prepare('SELECT COUNT(Huuto.id) FROM Huuto LEFT JOIN Ilmoitus ON (ilmoitus_id = Ilmoitus.id) WHERE Ilmoitus.id = :ilmoitusId');
        $query->execute(array($ilmoitusId));

        $row = $query->fetch();

        return $row['count'];
    }

    public static function findWithKayttajaId($kayttajaId)
    {
        $query = DB::connection()->prepare('SELECT Huuto.*, Ilmoitus.id, Ilmoitus.nimi FROM Huuto LEFT JOIN Ilmoitus ON (Huuto.ilmoitus_id = Ilmoitus.id) WHERE Huuto.kayttaja_id = :kayttajaId');
        $query->execute(array($kayttajaId));

        $rows = $query->fetchAll();
        $huudot = array();

        foreach ($rows as $row) {
            $huudot[] = new Huuto(array(
                'id' => $row['id'],
                'ilmoitus_id' => $row['ilmoitus_id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'hinta' => $row['hinta'],
                'paiva' => $row['paiva'],
                'nimi' => $row['nimi']
            ));
        }
        return $huudot;

    }

    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM Huuto WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $huuto = new Huuto(array(
                'id' => $row['id'],
                'ilmoitus_id' => $row['ilmoitus_id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'hinta' => $row['hinta'],
                'paiva' => $row['paiva']
            ));
        }
        return $huuto;
    }

    // todo Korjaa tämä niin että tulee loputkin huudot
    public static function findWithIlmoitusId($ilmoitusId)
    {
        $query = DB::connection()->prepare('SELECT Huuto.*, Kayttaja.kayttajatunnus 
FROM Huuto LEFT JOIN Kayttaja ON (kayttaja_id = Kayttaja.id)
LEFT JOIN Ilmoitus ON (Ilmoitus.id = Huuto.ilmoitus_id) WHERE ilmoitus_id = :ilmoitusId ORDER BY hinta DESC
');
        $query->execute(array($ilmoitusId));

        $rows = $query->fetchAll();
        $huudot = array();

        foreach ($rows as $row) {
            $huudot[] = new Huuto(array(
                'id' => $row['id'],
                'ilmoitus_id' => $row['ilmoitus_id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'hinta' => $row['hinta'],
                'paiva' => $row['paiva'],
                'kayttajatunnus' => $row['kayttajatunnus']
            ));

            return $huudot;
        }
    }

    public function destroy($id)
    {
        $query = DB::connection()->prepare('DELETE FROM Huuto WHERE Huuto.id = :id');
        $query->execute(array($id));
    }

    public function save()
    {
        $query = DB::connection()->prepare(
            'INSERT INTO Huuto (ilmoitus_id, kayttaja_id, hinta, paiva) 
VALUES (:ilmoitus_id, :kayttaja_id, :hinta, :paiva) RETURNING id');

        $query->execute(array(
            'ilmoitus_id' => $this->ilmoitus_id,
            'kayttaja_id' => $this->kayttaja_id,
            'hinta' => $this->hinta,
            'paiva' => $this->paiva));

        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function validate_hinta()
    {
        $errors = array();

        if ($this->hinta <= 0 || $this->hinta == null) {
            $errors[] = 'Määritithän huutosi hinnan?';
        }
        if ($this->hinta > 999999) {
            $errors[] = 'Määrittämäsi hinta on liian suuri';
        }
        return $errors;
    }
}