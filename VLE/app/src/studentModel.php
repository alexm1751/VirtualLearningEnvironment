<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 05/04/2018
 * Time: 19:42
 */

class studentModel
{
    public function __construct(){}

    public function __destruct(){}

    public function getModules($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $email)
    {

        try {
        $modules = array();
        $query_name = $p_sql_queries->get_modules($email);
        $p_wrapper_mysql->set_db_handle($p_db_handle);
        $p_wrapper_mysql->safe_query($query_name);
/*        $modules = $p_wrapper_mysql->safe_fetch_array();*/
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $json[] = $row;
            }

        return ($json);
         }catch(Exception $e){
            throw new Exception('Password Reset Denied. Please attempt again or contact admin.');
            return false;
        }
    }
}