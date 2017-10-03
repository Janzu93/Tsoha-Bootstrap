<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 23.9.2017
 * Time: 1:37
 */

class AdminController extends BaseController
{
    public static function ilmoitusList()
    {
        $ilmoitukset = Ilmoitus::all();


        if (!$_SESSION['kayttaja'] == null && in_array(3, RyhmaKayttaja::kayttajanRyhmat($_SESSION['kayttaja'])[0]->ryhma_id)) {
            View::make('admin/ilmoitus_list.html', array('ilmoitukset' => $ilmoitukset));
        } else {
            View::make('/home.html', array('errors' => array('Sinulla ei ole oikeuksia tälle sivulle!')));
        }
    }

    public static function kayttajaList()
    {
        $kayttajat = Kayttaja::all();

        if ((!$_SESSION['kayttaja'] == null && in_array(2, RyhmaKayttaja::kayttajanRyhmat($_SESSION['kayttaja'])[0]->ryhma_id))) {
            View::make('kayttaja/list.html', array('kayttajat' => $kayttajat));
        } else {
            View::make('/home.html', array('errors' => array('Sinulla ei ole oikeuksia tälle sivulle!')));
        }
    }
}