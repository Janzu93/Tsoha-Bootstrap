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
    }

}