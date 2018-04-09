<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 05/04/2018
 * Time: 19:42
 */

class teacherModel
{
    public function __construct(){}

    public function __destruct(){}

    public function getTeacherModules($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $email)
    {

        try {

            $query_name = $p_sql_queries->get_modules($email);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            /*        $modules = $p_wrapper_mysql->safe_fetch_array();*/
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $json[] = $row;
            }

            return ($json);

        }catch(Exception $e){
            throw new Exception('Error Collecting Modules');
            return false;
        }
    }
    public function getTeacherCourses($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $email)
    {

        try {

            $query_name = $p_sql_queries->get_courses($email);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            /*        $modules = $p_wrapper_mysql->safe_fetch_array();*/
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $json[] = $row;
            }

            return ($json);

        }catch(Exception $e){
            throw new Exception('Error Collecting Modules');
            return false;
        }
    }
}