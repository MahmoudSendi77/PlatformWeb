<?php

/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 30-Nov-19
 * Time: 14:45
 */

class UtilService
{
    public function generateCode(){

        $char ="abcdefghijklmnopqrstvwxyz0123456789";
        $chaineAleatoire =str_shuffle($char);

        return substr($chaineAleatoire,1,10);
    }

    /**
     * @param $id
     * @return string
     */
    public function statEvent($id){

        $char ="abcdefghijklmnopqrstvwxyz0123456789";
        $chaineAleatoire =str_shuffle($char);

        return substr($chaineAleatoire,1,10);
    }


}