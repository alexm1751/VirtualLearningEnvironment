<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 30/03/2018
 * Time: 13:12
 */

class BcryptWrapper
{
    public function __construct(){}

    public function __destruct(){}

    /**Generates and returns a hashed string
     * @param $p_string_to_hash String that needs to be hashed
     * @return bool|string hashed string
     */
    public function create_hashed_string($string_to_hash)
    {


        $bcrypt_hashed_string = '';
        if (!empty($string_to_hash))
        {
            $arr_options = array('cost' => BCRYPT_COST);
            $bcrypt_hashed_string = password_hash($string_to_hash, BCRYPT_ALGO, $arr_options);
        }
        return $bcrypt_hashed_string;
    }


}