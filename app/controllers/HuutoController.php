<?php
/**
 * Created by PhpStorm.
 * User: janzu
 * Date: 26.9.2017
 * Time: 11:17
 */

class HuutoController extends BaseController
{

    public static function store($ilmoitusId)
    {
        $params = $_POST;

        $attributes = array(
            'ilmoitus_id' => $ilmoitusId,
            'kayttaja_id' => $_SESSION['kayttaja'],
            'hinta' => $params['hinta'],
            'paiva' => date("Y-m-d")
        );

        $huuto = new Huuto($attributes);

        $errors = $huuto->errors();
        if (count($errors) == 0) {
            $huuto->save();

            Redirect::to('/ilmoitus/' . $ilmoitusId, array('message' => 'Huuto rekisteröity!'));
        } else {
            Redirect::to('/ilmoitus/' . $ilmoitusId, array('errors' => $errors, 'attributes' => $attributes));
        }
    }
}