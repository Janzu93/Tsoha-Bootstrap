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

    public static function ilmoitus($id)
    {
        $ilmoitus = Ilmoitus::find($id);
        $huudot = Huuto::findWithIlmoitusId($id);
        $huutoCount = Huuto::countIlmoituksenHuudot($id);

        View::make('ilmoitus/ilmoitus.html', array('ilmoitus' => $ilmoitus, 'huudot' => $huudot, 'huutocount' => $huutoCount));
    }

    public static function edit($id)
    {
        $ilmoitus = Ilmoitus::find($id);

        View::make('ilmoitus/edit.html', array('attributes' => $ilmoitus));
    }

    public static function create()
    {
        View::make('ilmoitus/new.html');
    }

    public static function store()
    {
        $params = $_POST;

        $attributes = array(
            'nimi' => $params['nimi'],
            'alkamispaiva' => date('Y-m-d'),
            'paattymispaiva' => $params['paattymispaiva'],
            'lahtohinta' => $params['lahtohinta'],
            'hintanyt' => $params['lahtohinta'],
            'kuvaus' => $params['kuvaus'],
            'kayttaja_id' => $_SESSION['kayttaja']
        );

        $ilmoitus = new Ilmoitus($attributes);
        $errors = $ilmoitus->errors();

        if (count($errors) == 0) {
            $ilmoitus->save();

            Redirect::to('/listaus', array('message' => 'Tuote asetettu myytäväksi!'));
        } else {
            Redirect::to('/new/ilmoitus', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function destroy($id)
    {
        $ilmoitus = Ilmoitus::find($id);

        $ilmoitus->destroy($id);
    }

    public static function update($id)
    {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus']);

        $ilmoitus = new Ilmoitus($attributes);
        $errors = $ilmoitus->validate_nimi();
        $errors = array_merge($errors, $ilmoitus->validate_kuvaus());


        if (count($errors) == 0) {
            $ilmoitus->update($id);

            Redirect::to('/listaus', array('message' => 'Tuote päivitetty!'));
        } else {
            Redirect::to('/ilmoitus/muokkaa/' . $id, array('errors' => $errors, 'attributes' => $attributes));
        }

    }
}