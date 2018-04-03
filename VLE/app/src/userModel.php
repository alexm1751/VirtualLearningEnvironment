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
    public function check_db_login($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $email, $password)
    {
      // var_dump($email . $password);
        $emailToCheck = $email;
        $passToCheck = $password;

        $query_name = $p_sql_queries->check_password($emailToCheck);
        $query_rank = $p_sql_queries->check_rank($emailToCheck);
        //var_dump($query_name);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_name);
        $stored_hash = $p_wrapper_mysql->safe_fetch_array();
        $p_wrapper_mysql->safe_query($query_rank);
        $rankQuery = $p_wrapper_mysql->safe_fetch_array();
        $rank = $rankQuery['dbRank'];
        var_dump($rank);
        $stored_password = $stored_hash['dbpass'];
        $name_entered = $p_wrapper_mysql->count_rows();
        if ($name_entered <= 0) {
            throw new Exception('Issue with Email or Password');
           return false;
        }
        if (password_verify($password, $stored_password) != true){
            throw new Exception('Issue with Email or Password');
            return false;
        }
        else {
            $_SESSION['user'] = $email;
            $_SESSION['rank'] = $rank;
            $_SESSION['logged_in']= true;

            return true;
        }


    }
    public function update_Recover_Hash($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$p_bcryptwrapper, $email, $string_to_hash){
        $hash = $p_bcryptwrapper->create_hashed_string($string_to_hash);
        $query_name = $p_sql_queries->update_user_hash($email,$hash);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        try{
            $p_wrapper_mysql->safe_query($query_name);
        } catch(Exception $e){
            throw new Exception('Password Reset Denied. Please attempt again or contact admin.');
            return false;
        }
        return true;


    }
    public function check_db_user($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $email){

        $emailToCheck = $email;
        $query_name = $p_sql_queries->check_user_exists($emailToCheck);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_name);
        $stored_email = $p_wrapper_mysql->safe_fetch_array();
        $name_entered = $p_wrapper_mysql->count_rows();
        if ($name_entered <= 0) {
            throw new Exception('Password Reset Denied. Please attempt again or contact admin.');
            return false;
        }
        else{
            //SetRESETHASH
            //Email
            return true;
        }

    }
    public function check_Recover_Hash($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $emailToCheck, $string_to_check){

       // $userExists = $this->check_db_user($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $emailToCheck);
        $query_hash = $p_sql_queries->check_hash($emailToCheck);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_hash);
        $stored_hash = $p_wrapper_mysql->safe_fetch_array();
        $hashToVerify = $stored_hash['dbRecover_Hash'];
       // return $hashToVerify;
   //     if(password_verify($string_to_check, $hashToVerify) == true){

            return (password_verify($string_to_check, $hashToVerify));
      //  }
//        else{
//            throw new Exception('Hash Not Working');
//            return false;
//        }
    }
    public function update_pass($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$p_bcryptwrapper, $email, $string_to_hash){
        $hash = $p_bcryptwrapper->create_hashed_string($string_to_hash);
        $query_name = $p_sql_queries->update_pass($email,$hash);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        try{
            $p_wrapper_mysql->safe_query($query_name);
        } catch(Exception $e){
            throw new Exception('Password Reset Denied. Please attempt again or contact admin.');
            return false;
        }
        return true;


    }

}