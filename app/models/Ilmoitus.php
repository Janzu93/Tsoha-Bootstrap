<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 22.9.2017
 * Time: 16:38
 */

class Ilmoitus extends BaseModel
{
    public $id, $nimi, $alkamispaiva, $paattymispaiva, $lahtohinta, $hintanyt, $kuvaus, $kayttaja_id;

    public function __construct($attributes = null)
    {
        parent::__construct($attributes);
    }

    public static function all()
    {
        $query = DB::connection()->prepare('SELECT * FROM Ilmoitus');
        $query->execute();

        $rows = $query->fetchAll();
        $ilmoitukset = array();

        foreach ($rows as $row) {
            $ilmoitukset[] = new Ilmoitus(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'alkamispaiva' => $row['alkamispaiva'],
                'paattymispaiva' => $row['paattymispaiva'],
                'lahtohinta' => $row['lahtohinta'],
                'hintanyt' => $row['hintanyt'],
                'kuvaus' => $row['kuvaus'],
                'kayttaja_id' => $row['kayttaja_id']
            ));
        }
        return $ilmoitukset;
    }

    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM Ilmoitus WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $ilmoitus = new Ilmoitus(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'alkamispaiva' => $row['alkamispaiva'],
                'paattymispaiva' => $row['paattymispaiva'],
                'lahtohinta' => $row['lahtohinta'],
                'hintanyt' => $row['hintanyt'],
                'kuvaus' => $row['kuvaus'],
                'kayttaja_id' => $row['kayttaja_id']
            ));
        }
        return $ilmoitus;
    }

    public function save()
    {
        $query = DB::connection()->prepare(
            'INSERT INTO Ilmoitus (nimi, alkamispaiva, paattymispaiva, lahtohinta, hintanyt, kuvaus, kayttaja_id) 
VALUES (:nimi, :alkamispaiva, :paattymispaiva, :lahtohinta, :hintanyt, :kuvaus, :kayttaja_id) RETURNING id');

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