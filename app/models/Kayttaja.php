<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 22.9.2017
 * Time: 17:28
 */

class Kayttaja extends BaseModel
{
    public $id, $etunimi, $sukunimi, $kayttajatunnus, $salasana, $syntymapaiva, $osoite, $oikeudet;

    public function __construct($attributes)
    {
        parent::__construct($attributes);

        $this->validators = array($this->validate_etunimi(),
            $this->validate_sukunimi(),
            $this->validate_kayttajatunnus(),
            $this->validate_osoite(),
            $this->validate_syntymapaiva());
    }

    public static function all()
    {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();

        $rows = $query->fetchAll();
        $kayttajat = array();

        foreach ($rows as $row) {
            $kayttajat[] = new Kayttaja(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana'],
                'syntymapaiva' => $row['syntymapaiva'],
                'osoite' => $row['osoite']
            ));
        }
        return $kayttajat;
    }

    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Kayttaja(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana'],
                'syntymapaiva' => $row['syntymapaiva'],
                'osoite' => $row['osoite']
            ));
        }
        return $kayttaja;
    }

    public function save()
    {
        $query = DB::connection()->prepare(
            'INSERT INTO Kayttaja (etunimi, sukunimi, kayttajatunnus, salasana, syntymapaiva, osoite) 
VALUES (:etunimi, :sukunimi, :kayttajatunnus, :salasana, :syntymapaiva, :osoite) RETURNING id');

        $query->execute(array(
            'etunimi' => $this->etunimi,
            'sukunimi' => $this->sukunimi,
            'kayttajatunnus' => $this->kayttajatunnus,
            'salasana' => $this->salasana,
            'syntymapaiva' => $this->syntymapaiva,
            'osoite' => $this->osoite));

        $row = $query->fetch();
        $this->id = $row['id'];

        // todo Ryhma_Kayttaja tauluun tietojen lisääminen
    }

    public function update($id)
    {
        $query = DB::connection()->prepare('UPDATE Kayttaja SET salasana = :salasana,
         osoite = :osoite WHERE id = :id');

        $query->execute(array(
            'id' => $id,
            'salasana' => $this->salasana,
            'osoite' => $this->osoite));

    }

    public static function authenticate($kayttajatunnus, $salasana)
    {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajatunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1');
        $query->execute(array('kayttajatunnus' => $kayttajatunnus, 'salasana' => $salasana));

        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Kayttaja(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana'],
                'syntymapaiva' => $row['syntymapaiva'],
                'osoite' => $row['osoite']));

            return $kayttaja;
        } else {
            return null;
        }
    }

    public function destroy($id)
    {

        $query = DB::connection()->prepare('DELETE FROM Huuto WHERE kayttaja_id = :id');
        $query->execute(array($id));
        $query = DB::connection()->prepare('DELETE FROM Ilmoitus WHERE kayttaja_id = :id');
        $query->execute(array($id));
        $query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE id = :id');
        $query->execute(array($id));

        Redirect::to('/', array('message' => 'Käyttäjä poistettu!'));
    }

    public function validate_syntymapaiva()
    {
        $date = $this->syntymapaiva;
        $errors = array();

        if ($date == null || $date == '') {
            $errors[] = 'Syötithän syntymäpäiväsi?';
            return $errors;
        }

        list($vuosi, $kuukausi, $paiva) = explode("-", $date);

        if ($vuosi < 1900 || strftime('%Y') < $vuosi || !checkdate($kuukausi, $paiva, $vuosi)) {
            $errors[] = 'Virhe syntymäpäivässä!';
        }
        return $errors;
    }

    public function validate_kayttajatunnus()
    {

        $errors = array();

        if ($this->kayttajatunnus == '' || $this->kayttajatunnus == null) {
            $errors[] = 'Kayttajatunnus ei saa olla tyhjä!';
        }
        if (strlen($this->kayttajatunnus) < 3 || strlen($this->kayttajatunnus) > 10) {
            $errors[] = 'Kayttajatunnuksen tulee olla 3-10 merkkiä pitkä';
        }
        return $errors;
    }

    public function validate_etunimi()
    {
        $errors = array();

        if ($this->etunimi == '' || $this->etunimi == null) {
            $errors[] = 'Etunimi ei saa olla tyhjä';
        }
        if (strlen($this->etunimi) < 3 || strlen($this->etunimi) > 20) {
            $errors[] = 'Etunimen tulee olla 3-20 merkkiä pitkä';
        }
        return $errors;
    }

    public function validate_sukunimi()
    {
        $errors = array();

        if ($this->sukunimi == '' || $this->sukunimi == null) {
            $errors[] = 'Sukunimi ei saa olla tyhjä';
        }
        if (strlen($this->sukunimi) < 3 || strlen($this->sukunimi) > 20) {
            $errors[] = 'Sukunimen tulee olla 3-20 merkkiä pitkä';
        }
        return $errors;
    }

    public function validate_salasana()
    {
        $errors = array();

        if ($this->salasana == '' || $this->salasana == null) {
            $errors[] = 'Salasana ei saa olla tyhjä';
        }
        if (strlen($this->salasana) < 6 || strlen($this->salasana) > 32) {
            $errors[] = 'Salasanan tulee olla 6-32 merkkiä pitkä';
        }
        return $errors;
    }

    public function validate_osoite()
    {
        $errors = array();

        if ($this->osoite == '' || $this->osoite == null) {
            $errors[] = 'Osoite ei saa olla tyhjä';
        }
        if (strlen($this->osoite) < 6 || strlen($this->osoite) > 100) {
            $errors[] = 'Osoitteen tulee olla 6-100 merkkiä pitkä';
        }
        return $errors;
    }
}