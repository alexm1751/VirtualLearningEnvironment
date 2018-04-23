<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 05/04/2018
 * Time: 19:42
 */

class adminModel
{
    public function __construct(){}

    public function __destruct(){}

    public  function getDashboard($p_db_handle, $p_sql_queries, $p_wrapper_mysql){

    }

    /*Course Control*/

    public function getCourses($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{
            $query_name = $p_sql_queries->admin_get_courses();
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function setCourses($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$courseName,$courseDescription,$credits,$years,$degree){
        try{
            $query_name = $p_sql_queries->admin_set_courses($courseName,$courseDescription,$credits,$years,$degree);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function updateCourses($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$courseName,$courseDescription,$credits,$years,$degree,$courseID){
        try{
            $query_name = $p_sql_queries->admin_update_courses($courseName,$courseDescription,$credits,$years,$degree,$courseID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function removeCourses($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$courseID){
        try{
            $query_name = $p_sql_queries->admin_remove_courses($courseID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }

    /*Module Control*/

    public function getModules($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{
            $query_name = $p_sql_queries->admin_get_modules();
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }

    public function setModules($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$moduleName,$moduleDescription,$credits,$courseID){
        try{
            $query_name = $p_sql_queries->admin_set_modules($moduleName,$moduleDescription,$credits,$courseID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function updateModules($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$moduleName,$moduleDescription,$credits,$courseID, $moduleID){
        try{
            $query_name = $p_sql_queries->admin_update_modules($moduleName,$moduleDescription,$credits,$courseID, $moduleID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function removeModules($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$moduleID){
        try{
            $query_name = $p_sql_queries->admin_remove_modules($moduleID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }

    /*User Control*/

    public function getUsers($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{
            $query_name = $p_sql_queries->admin_get_users();
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function setUsers($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$password,$email,$name,$address,$number,$rank,$gender){
        try{
            $query_name = $p_sql_queries->admin_set_users($password,$email,$name,$address,$number,$rank,$gender);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
            throw new Exception('$e');
            return false;
        }
    }
    public function updateUsers($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$email,$name,$address,$number,$rank,$gender,$uniqueID){
        try{
            $query_name = $p_sql_queries->admin_update_users($email,$name,$address,$number,$rank,$gender,$uniqueID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function removeUsers($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$uniqueID){
        try{
            $query_name = $p_sql_queries->admin_remove_users($uniqueID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }

    public function getAllocation($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{
            $query_name = $p_sql_queries->admin_get_allocation();
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function check_user_allocation($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $unique_id){
        try{
            $query_name = $p_sql_queries->admin_check_user_allocation($unique_id);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            $rows = $p_wrapper_mysql->count_rows();
            if ($rows <= 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function get_rank_id($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$unique_id){
        try{
            $query_name = $p_sql_queries->check_rank_id($unique_id);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            $rank = $p_wrapper_mysql->safe_fetch_array();
            $rank = $rank['dbRank'];
            return ($rank);
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function setAllocation($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$rank,$user_id,$course_id,$module_id){
        try{
            $query_name = $p_sql_queries->admin_set_allocation($rank,$user_id,$course_id,$module_id);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function removeAllocation($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$user_id,$course_id){
        try{
            $query_name = $p_sql_queries->admin_remove_allocation($user_id,$course_id);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function getCourseModules($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$course_id){
        try{
            $query_name = $p_sql_queries->get_course_modules($course_id);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }

    /*Class Control*/

    public function getClasses($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{
            $query_name = $p_sql_queries->admin_get_classes();
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function setClasses($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$moduleID, $date, $description){
        try{
            $query_name = $p_sql_queries->admin_set_classes($moduleID, $date, $description);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function updateClasses($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$classID,$moduleID,$date,$descAndWeek){
        try{
            $query_name = $p_sql_queries->admin_update_classes($classID,$moduleID,$date,$descAndWeek);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function removeClasses($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$classID){
        try{
            $query_name = $p_sql_queries->admin_remove_classes($classID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }

    /*Timetable Control*/


    public function getTimetables($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{
            $query_name = $p_sql_queries->admin_get_timetables();
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function setTimetables($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$pdf,$courseID){
        try{
            $query_name = $p_sql_queries->admin_set_timetables($pdf,$courseID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function check_timetable($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$course_id)
    {
        try {
            $query_name = $p_sql_queries->check_timetable($course_id);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            $rows = $p_wrapper_mysql->count_rows();
            if ($rows <= 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
                        throwException($e);

            return false;
        }
    }
    public function removeTimetables($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$timetableID){
        try{
            $query_name = $p_sql_queries->admin_remove_timetables($timetableID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }


    /*Admin Control*/

    public function getAdmins($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{
            $query_name = $p_sql_queries->admin_get_admins();
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }
    public function setAdmins($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$password,$email,$name,$address,$number,$rank,$gender){
        try{
            $query_name = $p_sql_queries->admin_set_admins($password,$email,$name,$address,$number,$rank,$gender);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;
        } catch (Exception $e){
                        throwException($e);

            return false;
        }
    }

}