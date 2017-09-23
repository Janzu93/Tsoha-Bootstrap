<?php

class AuctionatorController extends BaseController
{

    public static function index()
    {
        View::make('home.html');
    }


    public static function kayttajaMuokkaus()
    {
        View::make('edit.html');
    }

    public static function login()
    {
        View::make('login.html');
    }
    public static function admin()
    {
        View::make('admin.html');
    }

    // todo Poista lopuksi
    public static function sandbox()
    {
        // Testaa koodiasi täällä
        $kayttaja = Kayttaja::find(1);
        $kayttajat = Kayttaja::all();
        $ilmoitus = Ilmoitus::find(1);
        $ilmoitukset = Ilmoitus::all();
        $huuto = Huuto::find(1);
        $huudot = Huuto::all();
        $id = 1;
        $testHuudot = Huuto::findWithKayttajaId($id);

        Kint::dump($kayttaja);
        Kint::dump($kayttajat);
        Kint::dump($ilmoitus);
        Kint::dump($ilmoitukset);
        Kint::dump($huuto);
        Kint::dump($huudot);
        Kint::dump($testHuudot);
    }

}