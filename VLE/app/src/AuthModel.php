<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 30/03/2018
 * Time: 13:27
 */

class authModel{
    public function __construct(){}

    public function __destruct(){}


    /*
     * This class lists all methods called by users attempting to use authentication tools or validate users for specific tasks
     * This will deal with guest and other attempts to access the site.
     * Will also pull in certain information about the user upon login such as name and other details.
     *
     * */

    public function check_db_login($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $email, $password)
    {

        $emailToCheck = $email;


        $query_name = $p_sql_queries->check_password($emailToCheck);
        $query_rank = $p_sql_queries->check_rank($emailToCheck);
        $query_hash = $p_sql_queries->check_hash($emailToCheck);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_name);
        $stored_hash = $p_wrapper_mysql->safe_fetch_array();
        $p_wrapper_mysql->safe_query($query_rank);
        $rankQuery = $p_wrapper_mysql->safe_fetch_array();
        $p_wrapper_mysql->safe_query($query_hash);
        $hashQuery = $p_wrapper_mysql->safe_fetch_array();
        $hash = $hashQuery['dbRecover_Hash'];
        $rank = $rankQuery['dbRank'];

        $stored_password = $stored_hash['dbpass'];
        $name_entered = $p_wrapper_mysql->count_rows();
        if ($name_entered <= 0) {
            throw new Exception('Issue with Email or Password');
           return false;
        }
        elseif(password_verify($password, $stored_password) != true){
            throw new Exception('Issue with Email or Password');
            return false;
        }
        elseif ($hash){
                //User has requested password change ineligible for login
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
    public function check_pass($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $email, $pass){

        $query_name = $p_sql_queries->check_password($email);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_name);
        $stored_pass = $p_wrapper_mysql->safe_fetch_array();
        $stored_pass = $stored_pass['dbpass'];
        if(password_verify($pass, $stored_pass) != true){

            return false;

        }
        else{
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
            throwException($e);
            return false;
        }
        return true;


    }
    public function check_db_user($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $email){

        $emailToCheck = $email;
        $query_name = $p_sql_queries->check_user_exists($emailToCheck);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_name);
        $name_entered = $p_wrapper_mysql->count_rows();
        if ($name_entered <= 0) {
            return false;
        }
        else{

            return true;
        }

    }
    public function check_Recover_Hash($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $emailToCheck, $string_to_check){


        $query_hash = $p_sql_queries->check_hash($emailToCheck);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_hash);
        $stored_hash = $p_wrapper_mysql->safe_fetch_array();
        $hashToVerify = $stored_hash['dbRecover_Hash'];
        if(password_verify($string_to_check, $hashToVerify) == true){

            return true;
        }
        else{


            return false;
        }
    }
    public function check_reset_initiated($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $emailToCheck){


        $query_hash = $p_sql_queries->check_hash($emailToCheck);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_hash);
        $stored_hash = $p_wrapper_mysql->safe_fetch_array();
        $hashToVerify = $stored_hash['dbRecover_Hash'];
        if($hashToVerify != "NULL"){
            return false;
        }
        else{
            return true;
        }
    }

    public function update_pass($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$p_bcryptwrapper, $email, $string_to_hash){

        try{
        $recoverHashReset = '';
        $hash = $p_bcryptwrapper->create_hashed_string($string_to_hash);
        $query_pass = $p_sql_queries->update_pass($email,$hash);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_pass);

            $query_hash = $p_sql_queries->update_user_hash($email,$recoverHashReset);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_hash);

        } catch(Exception $e){
            throwException($e);
            return false;
        }
        return true;


    }

    public function getUserName($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $email){
        $default = 'User!';


        $query_name = $p_sql_queries->get_name($email);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_name);
        $name = $p_wrapper_mysql->safe_fetch_array();
        $usersName = $name['dbFullName'];
        if (!$usersName){
            return $default;
        }
        else{

            return $_SESSION['name']= $usersName ;
        }
    }
    public function get_profile_details($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $email)
    {

        try {
            $modules = array();
            $query_name = $p_sql_queries->get_profileDetails($email);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            /*        $modules = $p_wrapper_mysql->safe_fetch_array();*/
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        }catch(Exception $e){
            throwException($e);
            return false;
        }
    }
    public function update_profile_details($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $name,$address,$number, $email)
    {

        try {

            $query_name = $p_sql_queries->update_profileDetails($name,$address,$number, $email);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);


            return true;

        }catch(Exception $e){
            throwException($e);
            return false;
        }
    }

}