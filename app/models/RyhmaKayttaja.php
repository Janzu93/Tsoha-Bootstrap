<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 2.10.2017
 * Time: 22:14
 */

class RyhmaKayttaja extends BaseModel
{
    public $ryhma_id, $kayttaja_id;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
    }

    public static function all()
    {
        $query = DB::connection()->prepare('SELECT * FROM Ryhma_Kayttaja');
        $query->execute();

        $rows = $query->fetchAll();

        $ryhmaKayttajat = array();

        foreach ($rows as $row) {
            $ryhmaKayttajat[] = new RyhmaKayttaja(array('ryhma_id' => $row['ryhma_id'], 'kayttaja_id' => $row['kayttaja_id']));
        }

        return $ryhmaKayttajat;
    }

    public static function kayttajanRyhmat($kayttajaId)
    {
        $query = DB::connection()->prepare('SELECT * FROM Ryhma_Kayttaja WHERE kayttaja_id = :kayttajaId');
        $query->execute(array($kayttajaId));

        $rows = $query->fetchAll();

        $ryhmaKayttajat = array();
        $ryhma_idt = array();

        foreach ($rows as $row) {
            array_push($ryhma_idt, $row['ryhma_id']);
        }

        $ryhmaKayttajat[] = new RyhmaKayttaja(array('ryhma_id' => $ryhma_idt, 'kayttaja_id' => $row['kayttaja_id']));

        return $ryhmaKayttajat;
    }

    public function save()
    {
        $query = DB::connection()->prepare('INSERT INTO Ryhma_Kayttaja VALUES(:ryhmaId, :kayttajaId)');
        $query->execute(array('ryhmaId' => $this->ryhma_id, 'kayttajaId' => $this->kayttaja_id));
    }
}