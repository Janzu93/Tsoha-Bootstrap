<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 22.9.2017
 * Time: 17:28
 */

class Kayttaja extends BaseModel
{
    public $id, $etunimi, $sukunimi, $kayttajatunnus, $salasana, $syntymapaiva, $osoite, $oikeudet;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
    }

    public static function all()
    {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();

        $rows = $query->fetchAll();
        $kayttajat = array();

        foreach ($rows as $row) {
            $kayttajat[] = new Kayttaja(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana'],
                'syntymapaiva' => $row['syntymapaiva'],
                'osoite' => $row['osoite'],
                'oikeudet' => $row['oikeudet']
            ));
        }
        return $kayttajat;
    }

    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Kayttaja(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana'],
                'syntymapaiva' => $row['syntymapaiva'],
                'osoite' => $row['osoite'],
                'oikeudet' => $row['oikeudet']
            ));
        }
        return $kayttaja;
    }

    public function save()
    {
        $query = DB::connection()->prepare(
            'INSERT INTO Kayttaja (etunimi, sukunimi, kayttajatunnus, salasana, syntymapaiva, osoite, oikeudet) 
VALUES (:etunimi, :sukunimi, :kayttajatunnus, :salasana, :syntymapaiva, :osoite, :oikeudet) RETURNING id');

        $query->execute(array(
            'etunimi' => $this->etunimi,
            'sukunimi' => $this->sukunimi,
            'kayttajatunnus' => $this->kayttajatunnus,
            'salasana' => $this->salasana,
            'syntymapaiva' => $this->syntymapaiva,
            'osoite' => $this->osoite,
            'oikeudet' => $this->oikeudet));

        $row = $query->fetch();
        $this->id = $row['id'];
    }
}