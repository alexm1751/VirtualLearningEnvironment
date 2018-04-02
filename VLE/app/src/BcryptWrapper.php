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
    public function create_hashed_string()
    {

        $string_to_hash = bin2hex(random_bytes(10));
        $bcrypt_hashed_string = '';
        if (!empty($string_to_hash))
        {
            $arr_options = array('cost' => BCRYPT_COST);
            $bcrypt_hashed_string = password_hash($string_to_hash, BCRYPT_ALGO, $arr_options);
        }
        return $bcrypt_hashed_string;
    }

    /**Verifies a given hashed password against a clean string password to check for equality
     * @param $p_string_to_check clean string password
     * @param $p_stored_user_password_hash hashed password to check against
     * @return bool true if the hashed password and clean string are equal
     */
    public function authenticate_password($p_string_to_check, $p_stored_user_password_hash)
    {
        $user_authenticated = false;
        $current_user_password = $p_string_to_check;
        $stored_user_password_hash = $p_stored_user_password_hash;
        if (!empty($current_user_password) && !empty($stored_user_password_hash))
        {
            if (password_verify($current_user_password, $stored_user_password_hash))
            {
                $user_authenticated = true;
            }
        }
        return $user_authenticated;
    }
}