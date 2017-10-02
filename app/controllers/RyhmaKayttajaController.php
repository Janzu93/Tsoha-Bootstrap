<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 2.10.2017
 * Time: 22:19
 */

class RyhmaKayttajaController extends BaseController
{

    public static function store($ryhmaId, $kayttajaId)
    {
        $attributes = array('ryhma_id' => $ryhmaId, 'kayttaja_id' => $kayttajaId);

        $ryhmaKayttaja = new RyhmaKayttaja($attributes);

        $ryhmaKayttaja->save();
    }
}