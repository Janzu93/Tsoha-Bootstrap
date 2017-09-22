<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 22.9.2017
 * Time: 22:21
 */

class KayttajaController extends BaseController
{
    public static function index()
    {
        $kayttajat = Kayttaja::all();

        View::make('kayttaja/list.html', array('kayttajat' => $kayttajat));
    }
}