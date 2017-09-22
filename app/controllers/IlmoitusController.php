<?php

/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 22.9.2017
 * Time: 18:21
 */

class IlmoitusController extends BaseController
{
    public static function index()
    {
        $ilmoitukset = Ilmoitus::all();
        $kayttajat = Kayttaja::all();

        View::make('ilmoitus/list.html', array('ilmoitukset' => $ilmoitukset), array('kayttajat' => $kayttajat));
    }
}