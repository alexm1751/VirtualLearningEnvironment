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
                $array[] = $row;
            }

        return ($array);
         }catch(Exception $e){
            throw new Exception('Password Reset Denied. Please attempt again or contact admin.');
            return false;
        }
    }



    public function getAttendance($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$email){
        try{
            $query_name = $p_sql_queries->get_attendance($email);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }

    }
    public function getPercent($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$email){
        try{
            $query_name = $p_sql_queries->get_percent($email);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }

    }
    public function getTimetable($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$email){

        try{
            $query_name = $p_sql_queries->get_timetable($email);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }

    }

    public function getModuleAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$module){
        try{
            $query_name = $p_sql_queries->get_module_announcements($module);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }

    }
    public function getCourse($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$email){
        try{
            $query_name = $p_sql_queries->getCourse($email);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }


    }

    public function getCourseAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$email){
        try{
            $query_name = $p_sql_queries->get_course_announcements($email);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }

    }

    public function getDeadlines($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$email,$module){
        try{
            $query_name = $p_sql_queries->get_deadlines($email, $module);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }


    }

    public function getStaffInfo($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$module){
        try{
            $query_name = $p_sql_queries->get_staff_info($module);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }


    }

    public function getLearningPractical($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$module,$email){
        try{
            $query_name = $p_sql_queries->get_practical_content($email,$module);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }



    }
    public function getLearningTheory($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$module,$email){
        try{
            $query_name = $p_sql_queries->get_theory_content($email,$module);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }




    }

    public function getAssessments($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$module,$email){
        try{
            $query_name = $p_sql_queries->get_assessments($email,$module);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }


    }
    public function submitAssessments($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$courseworkID,$uniqueID){
        try{
            $query_name = $p_sql_queries->submit_assessments($courseworkID,$uniqueID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            return true;
        } catch (Exception $e){
            var_dump($e);
            return false;
        }


    }



    public function getFeedback($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$module,$email){
        try{
            $query_name = $p_sql_queries->get_feedback($email,$module);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);
            while($row = $p_wrapper_mysql->safe_fetch_array()){
                $array[] = $row;
            }

            return ($array);
        } catch (Exception $e){
            var_dump($e);
            return false;
        }


    }

}