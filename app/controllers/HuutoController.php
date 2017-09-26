<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 26.9.2017
 * Time: 11:17
 */

class HuutoController extends BaseController
{

    public static function store()
    {
        $params = $_POST;

        // todo poista hardcode id:istä
        $huuto = new Huuto(array(
            'ilmoitus_id' => $params['ilmoitus_id'],
            'kayttaja_id' => 1,
            'hinta' => $params['hinta'],
            'paiva' => $params['paiva']
        ));

        $huuto->save();

        Redirect::to('/ilmoitus/1', array('message' => 'Huuto rekisteröity!'));
    }
}