<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 22.9.2017
 * Time: 16:38
 */

class Ilmoitus extends BaseModel
{
    public $id, $nimi, $alkamispaiva, $paattymispaiva, $lahtohinta, $hintanyt, $kuvaus, $kayttaja_id, $kayttajatunnus, $huutomaara;

    public function __construct($attributes)
    {
        parent::__construct($attributes);

        $this->validators = array($this->validate_nimi(),
            $this->validate_paattymispaiva(),
            $this->validate_lahtohinta(),
            $this->validate_kuvaus());
    }

    public static function all()
    {
        $query = DB::connection()->prepare('SELECT Ilmoitus.*, huuto.count, Kayttaja.kayttajatunnus FROM Ilmoitus 
LEFT JOIN Kayttaja ON (Ilmoitus.kayttaja_id = Kayttaja.id) 
LEFT JOIN (SELECT COUNT(Huuto.id), Huuto.ilmoitus_id FROM Huuto GROUP BY(Huuto.ilmoitus_id)) AS huuto ON (Ilmoitus.id = huuto.ilmoitus_id)');
        $query->execute();

        $rows = $query->fetchAll();
        $ilmoitukset = array();

        foreach ($rows as $row) {
            $ilmoitukset[] = new Ilmoitus(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'alkamispaiva' => $row['alkamispaiva'],
                'paattymispaiva' => $row['paattymispaiva'],
                'lahtohinta' => $row['lahtohinta'],
                'hintanyt' => $row['hintanyt'],
                'kuvaus' => $row['kuvaus'],
                'kayttaja_id' => $row['kayttaja_id'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'huutomaara' => $row['count']
            ));
        }
        return $ilmoitukset;
    }

    public static function findWithKayttajaId($kayttajaId)
    {
        $query = DB::connection()->prepare('SELECT * FROM Ilmoitus WHERE kayttaja_id = :kayttajaId');
        $query->execute(array($kayttajaId));

        $rows = $query->fetchAll();
        $ilmoitukset = array();

        foreach ($rows as $row) {
            $ilmoitukset[] = new Ilmoitus(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'alkamispaiva' => $row['alkamispaiva'],
                'paattymispaiva' => $row['paattymispaiva'],
                'lahtohinta' => $row['lahtohinta'],
                'hintanyt' => $row['hintanyt'],
                'kuvaus' => $row['kuvaus'],
                'kayttaja_id' => $row['kayttaja_id']
            ));
        }
        return $ilmoitukset;
    }

    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT Ilmoitus.*, Kayttaja.kayttajatunnus FROM Ilmoitus 
LEFT JOIN Kayttaja ON (Ilmoitus.kayttaja_id = Kayttaja.id) WHERE ilmoitus.id = :id LIMIT 1');

        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $ilmoitus = new Ilmoitus(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'alkamispaiva' => $row['alkamispaiva'],
                'paattymispaiva' => $row['paattymispaiva'],
                'lahtohinta' => $row['lahtohinta'],
                'hintanyt' => $row['hintanyt'],
                'kuvaus' => $row['kuvaus'],
                'kayttaja_id' => $row['kayttaja_id'],
                'kayttajatunnus' => $row['kayttajatunnus']
            ));
        }
        return $ilmoitus;
    }

    public function save()
    {
        $query = DB::connection()->prepare(
            'INSERT INTO Ilmoitus (nimi, alkamispaiva, paattymispaiva, lahtohinta, hintanyt, kuvaus, kayttaja_id) 
VALUES (:nimi, :alkamispaiva, :paattymispaiva, :lahtohinta, :hintanyt, :kuvaus, :kayttaja_id) RETURNING id');

        $query->execute(array(
            'nimi' => $this->nimi,
            'alkamispaiva' => $this->alkamispaiva,
            'paattymispaiva' => $this->paattymispaiva,
            'lahtohinta' => $this->lahtohinta,
            'hintanyt' => $this->hintanyt,
            'kuvaus' => $this->kuvaus,
            'kayttaja_id' => $this->kayttaja_id));

        $row = $query->fetch();
        $this->id = $row['id'];

    }

    public function validate_nimi()
    {
        $errors = array();

        if ($this->nimi == null || strlen($this->nimi) == 0) {
            $errors[] = 'Ilmoituksen nimi ei saa olla tyhjä';
            return $errors;
        }
        if (strlen($this->nimi) < 3 || strlen($this->nimi) > 200) {
            $errors[] = 'Ilmoituksen nimen tulee olla 3-200 merkkiä';
        }

        return $errors;
    }

    public function validate_paattymispaiva()
    {
        $date = $this->paattymispaiva;
        $paivaero = date_diff(date_create(date('Y-m-d')), date_create($date))->format('%r%d');
        $errors = array();

        if ($date == null || $date == '') {
            $errors[] = 'Ilmoituksen päättymispäivä ei voi olla tyhjä';
            return $errors;
        }

        list($vuosi, $kuukausi, $paiva) = explode("-", $date);

        if (!checkdate($kuukausi, $paiva, $vuosi)) {
            $errors[] = 'Virhe päättymispäivässä!';
        }

        if ($paivaero < 0) {
            $errors[] = 'Päättymispäivä ei voi olla menneisyydessä!';
        } else if ($paivaero == 0) {
            $errors[] = 'Päättymispäivä ei voi olla tänään!';
        } else if ($paivaero > 7) {
            $errors[] = 'Ilmoitus voi olla voimassa korkeintaan viikon!';
        }

        return $errors;
    }

    public function validate_lahtohinta()
    {
        $errors = array();

        if ($this->lahtohinta == null || $this->lahtohinta == 0) {
            $errors[] = 'Lähtöhinta ei voi olla 0!';
        }
        if ($this->lahtohinta < 0) {
            $errors[] = 'Lähtöhinta ei voi olla negatiivinen!';
        }
        if ($this->lahtohinta > 999999) {
            $errors[] = 'Lähtöhinta on liian suuri';
        }

        return $errors;
    }

    public function validate_kuvaus()
    {
        $errors = array();

        if ($this->kuvaus == null || strlen($this->kuvaus) == 0) {
            $errors[] = 'Ilmoituksen kuvaus ei saa olla tyhjä';
            return $errors;
        }
        if (strlen($this->kuvaus) < 3) {
            $errors[] = 'Ilmoituksen kuvauksen olla vähintään 3 merkkiä pitkä';
        }
        if (strlen($this->kuvaus) > 1000) {
            $errors[] = 'Ilmoituksen kuvaus on liian pitkä (max 1000)';
        }

        return $errors;
    }

    public static function check_paattynyt($paiva)
    {

        $paivaero = date_diff(date_create(date('Y-m-d')), date_create($paiva))->format('%r%d');


        if ($paivaero < 0) {
            return false;
        }
        return true;

    }

    public function update($id)
    {
        $query = DB::connection()->prepare('UPDATE Ilmoitus SET nimi = :nimi,
         kuvaus = :kuvaus WHERE id = :id');

        $query->execute(array(
            'id' => $id,
            'nimi' => $this->nimi,
            'kuvaus' => $this->kuvaus));

    }

    public function destroy($id)
    {
        $query = DB::connection()->prepare('DELETE FROM Huuto WHERE ilmoitus_id = :id');
        $query->execute(array($id));

        $query = DB::connection()->prepare('DELETE FROM Ilmoitus WHERE Ilmoitus.id = :id');
        $query->execute(array($id));

        Redirect::to('/', array('message' => 'Ilmoitus poistettu!'));
    }
}