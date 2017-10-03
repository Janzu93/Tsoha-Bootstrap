<?php

class AuctionatorController extends BaseController
{

    public static function index()
    {
        View::make('home.html');
    }


    // todo Poista lopuksi
    public static function sandbox()
    {
        // Testaa koodiasi täällä

    }

}