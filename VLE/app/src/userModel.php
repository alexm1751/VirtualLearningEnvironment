<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 30/03/2018
 * Time: 13:27
 */

class userModel{
    public function __construct(){}

    public function __destruct(){}


    /**Safely checks if a user with the given details exists in the database
     * @param $p_db_handle Database handle
     * @param $p_sql_queries SQL query as a string
     * @param $p_wrapper_mysql Instance of MySQLWrapper
     * @param $arr_clean_auth Array of validated and sanitised user details
     * @return bool true if the user exists in the database
     * @throws Exception
     */
    public function check_db_login($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $arr_clean_auth)
    {

        $email = $arr_clean_auth['email'];
        $hashed_pass = $arr_clean_auth['hashed_password'];

        $query_name = $p_sql_queries->check_password($email);

        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_name);
        $stored_hash = $p_wrapper_mysql->safe_fetch_array();
        $password = $stored_hash['password'];
        $name_entered = $p_wrapper_mysql->count_rows();
        if ($name_entered <= 0) {
            throw new Exception('Issue with Email or Password');
            return false;
        }
        if (password_verify($hashed_pass, $password) != true){
            throw new Exception('Issue with Email or Password');
            return false;
        }
        else {
            return true;
        }


    }
}