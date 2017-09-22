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

        View::make(ilmoitus . html, array('ilmoitukset' => $ilmoitukset));
    }
}