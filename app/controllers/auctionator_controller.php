<?php

class AuctionatorController extends BaseController
{

    public static function index()
    {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
    }

    public static function listaus()
    {
        View::make('ilmoitus_list.html');
    }

    public static function ilmoitus()
    {
        View::make('ilmoitus.html');
    }

    public static function muokkaus()
    {
        View::make('ilmoitus_edit.html');
    }

    public static function login()
    {
        View::make('login.html');
    }

    public static function sandbox()
    {
        // Testaa koodiasi täällä
        View::make('helloworld.html');
    }


}
