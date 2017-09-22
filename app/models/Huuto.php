<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 22.9.2017
 * Time: 17:35
 */

class Huuto extends BaseModel
{
    public $id, $ilmoitus_id, $kayttaja_id, $hinta, $paiva;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
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
}