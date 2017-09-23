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

        View::make('ilmoitus/list.html', array('ilmoitukset' => $ilmoitukset));
    }

    public static function edit($id)
    {
        $ilmoitus = Ilmoitus::find($id);

        View::make('ilmoitus/edit.html', array('ilmoitus' => $ilmoitus));
    }

    public static function create()
    {
        View::make('ilmoitus/new.html');
    }

    public static function store()
    {
        $params = $_POST;

        $ilmoitus = new Ilmoitus(array(
            'nimi' => $params['nimi'],
            'alkamispaiva' => date('Y-m-d'),
            'paattymispaiva' => $params['paattymispaiva'],
            'lahtohinta' => $params['lahtohinta'],
            'hintanyt' => $params['lahtohinta'],
            'kuvaus' => $params['kuvaus'],
            'kayttaja_id' => 1
        ));

        $ilmoitus->save();

        Redirect::to('/listaus/' . $ilmoitus->id, array('message' => 'Tuote asetettu myytäväksi!'));
    }

    public static function update($id)
    {
        $params = $_POST;

        $ilmoitus = new Ilmoitus(array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus']));

        $ilmoitus->update($id);

        Redirect::to('/listaus' . $ilmoitus->id, array('message' => 'Tuote päivitetty!'));

    }
}