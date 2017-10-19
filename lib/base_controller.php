<?php

class BaseController
{

    public static function get_user_logged_in()
    {
        if (isset($_SESSION['kayttaja'])) {
            $kayttaja_id = $_SESSION['kayttaja'];

            $kayttaja = Kayttaja::find($kayttaja_id);

            return $kayttaja;
        }
        return null;
    }

    public static function check_logged_in()
    {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).

        if (!isset($_SESSION['kayttaja'])) {
            Redirect::to('/login', array('errors' => array('Et ole kirjautunut sisään')));
        }
    }

    public static function check_oikeudet($id)
    {
        self::check_logged_in();
        $kayttaja = self::get_user_logged_in();

        if ($kayttaja->id != $id &&
            !in_array(3, RyhmaKayttaja::kayttajanRyhmat($_SESSION['kayttaja'])[0]->ryhma_id) &&
            !in_array(2, RyhmaKayttaja::kayttajanRyhmat($_SESSION['kayttaja'])[0]->ryhma_id)) {
            Redirect::to('/', array('errors' => array('Sinulla ei ole oikeuksia pyytämääsi sisältöön')));
        }
    }
}