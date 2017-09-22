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

    public static function page($id)
    {
        $kayttaja = Kayttaja::find($id);
        $kayttajanHuudot = Huuto::findWithKayttajaId($id);

        View::make('kayttaja/kayttaja.html', array('kayttaja' => $kayttaja), array('kayttajanHuudot' => $kayttajanHuudot));
    }
}