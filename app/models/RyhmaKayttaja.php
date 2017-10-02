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

    public function save()
    {
        $query = DB::connection()->prepare('INSERT INTO Ryhma_Kayttaja VALUES(:ryhmaId, :kayttajaId)');
        $query->execute(array('ryhmaId' => $this->ryhma_id, 'kayttajaId' => $this->kayttaja_id));
    }
}