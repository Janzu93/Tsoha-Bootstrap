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
        try {
            $kayttaja = new Kayttaja(array(
                'etunimi' => $params['etunimi'],
                'sukunimi' => $params['sukunimi'],
                'kayttajatunnus' => $params['kayttajatunnus'],
                'salasana' => $params['salasana'],
                'syntymapaiva' => $params['syntymapaiva'],
                'osoite' => $params['osoite'],
                'oikeudet' => 0,
                'checkbox' => $params['checkbox']
            ));
            if ($params['checkbox']) {
                $kayttaja->save();

                Redirect::to('/', array('message' => 'Käyttäjä rekisteröity'));
            }
        } catch (ErrorException $e) {
            Redirect::to('/new/kayttaja', array('message' => 'Sinun pitää sallia tietojen tallentaminen'));
        }
    }

    public static function edit($id)
    {
        $kayttaja = Kayttaja::find($id);

        View::make('/kayttaja/edit.html', array('kayttaja' => $kayttaja));
    }

    public static function update($id)
    {
        $params = $_POST;

        $kayttaja = new Kayttaja(array(
            'salasana' => $params['salasana'],
            'osoite' => $params['osoite']));

        $kayttaja->update($id);

        Redirect::to('/kayttaja/' . $id, array('message' => 'Käyttäjätiedot päivitetty!'));

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
}