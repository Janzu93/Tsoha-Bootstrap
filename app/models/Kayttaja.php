<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 22.9.2017
 * Time: 17:28
 */

class Kayttaja extends BaseModel
{
    public $id, $etunimi, $sukunimi, $kayttajatunnus, $syntymapaiva, $osoite, $oikeudet;

    public function __construct($attributes = null)
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
            $Kayttaja = new Kayttaja(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'syntymapaiva' => $row['syntymapaiva'],
                'osoite' => $row['osoite'],
                'oikeudet' => $row['oikeudet']
            ));
        }
        return $Kayttaja;
    }

    public function save()
    {
        $query = DB::connection()->prepare(
            'INSERT INTO Kayttaja (etunimi, sukunimi, kayttajatunnus, syntymapaiva, osoite, oikeudet) 
VALUES (:etunimi, :sukunimi, :kayttajatunnus, :syntymapaiva, :osoite, :oikeudet) RETURNING id');

        $query->execute(array(
            'nimi' => $this->nimi,
            'alkamispaiva' => $this->alkamispaiva,
            'paattymispaiva' => $this->paattymispaiva,
            'lahtohinta' => $this->lahtohinta,
            'hintanyt' => $this->hintanyt,
            'kuvaus' => $this->kuvaus,
            'kayttaja_id' => $this->kayttaja_id));

        $row = $query->fetch();
        $this->id = $row['id'];
    }
}