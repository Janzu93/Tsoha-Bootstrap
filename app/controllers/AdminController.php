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

        View::make('admin/ilmoitus_list.html', array('ilmoitukset' => $ilmoitukset));
    }
}