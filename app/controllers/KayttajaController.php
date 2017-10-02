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
        $kayttajanMyynnit = Ilmoitus::findWithKayttajaId($id);

        View::make('kayttaja/kayttaja.html',
            array('kayttaja' => $kayttaja, 'huudot' => $kayttajanHuudot, 'myynnit' => $kayttajanMyynnit));
    }

    public static function create()
    {
        View::make('kayttaja/new.html');
    }

    public static function store()
    {
        $params = $_POST;

        $attributes = array(
            'etunimi' => $params['etunimi'],
            'sukunimi' => $params['sukunimi'],
            'kayttajatunnus' => $params['kayttajatunnus'],
            'salasana' => $params['salasana'],
            'syntymapaiva' => $params['syntymapaiva'],
            'osoite' => $params['osoite'],
            'oikeudet' => 1);

        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();

        if (!isset($params['checkbox'])) {
            array_push($errors, 'Sinun pitää sallia tietojen tallentaminen tietokantaan!');
        }
        if (count($errors) == 0) {
            $kayttaja->save();
            RyhmaKayttajaController::store($kayttaja->oikeudet, $kayttaja->id);

            Redirect::to('/', array('message' => 'Käyttäjä rekisteröity'));
        } else {
            Redirect::to('/new/kayttaja', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function edit($id)
    {
        $kayttaja = Kayttaja::find($id);

        View::make('/kayttaja/edit.html', array('kayttaja' => $kayttaja));
    }

    public static function destroy($id)
    {
        $kayttaja = Kayttaja::find($id);

        $kayttaja->destroy($id);
    }

    public static function update($id)
    {
        $params = $_POST;

        $attributes = array(
            'salasana' => $params['salasana'],
            'osoite' => $params['osoite']);

        $kayttaja = new Kayttaja($attributes);

        $errors = $kayttaja->validate_salasana();
        $errors = array_merge($errors, $kayttaja->validate_osoite());

        if (count($errors) == 0) {
            $kayttaja->update($id);

            Redirect::to('/kayttaja/' . $id, array('message' => 'Käyttäjätiedot päivitetty!'));
        } else {
            Redirect::to('/kayttaja/' . $id, array('errors' => $errors), 'attributes => $attributes');
        }

    }

    public static function login()
    {
        View::make('kayttaja/login.html');
    }


    public static function handle_login()
    {
        $params = $_POST;

        $kayttaja = Kayttaja::authenticate($params['kayttajatunnus'], $params['salasana']);

        if (!$kayttaja) {
            View::make('kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'kayttajatunnus' => $params['kayttajatunnus']));
        } else {
            $_SESSION['kayttaja'] = $kayttaja->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $kayttaja->kayttajatunnus . '!'));
        }
    }

    public static function logout()
    {
        $_SESSION['kayttaja'] = null;
        Redirect::to('/', array('message' => 'Olet kirjautunut ulos!'));
    }
}