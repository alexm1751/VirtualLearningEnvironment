<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 05/04/2018
 * Time: 19:42
 */

/*
 * This class lists all methods called by Teachers for Teacher specific tasks
 * Other users such as admins and students should not be using this class where possible
 * All course related requests and dashboard items to show the Lecturer their Courses and content.
 * */

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
            throwException($e);
            return false;
        }
    }
    public function getModuleID($p_db_handle, $p_sql_queries, $p_wrapper_mysql, $module_name)
    {

        try {

            $query_name = $p_sql_queries->get_modules_id($module_name);
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
            throwException($e);
            return false;
        }
    }
    /*Course Announcements*/
    public function getCourseAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$email,$course_name){
        try{
            $query_name = $p_sql_queries->get_course_announcements($email,$course_name);
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
    public function setAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$name,$courseID,$moduleID,$description){
        try{
            $query_name = $p_sql_queries->set_announcement($name,$courseID,$moduleID,$description);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;

        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }
    public function removeCourseAnnouncement($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$annID){
        try{
            $query_name = $p_sql_queries->remove_announcement($annID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;


        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }
    public function updateAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$title,$description,$annID){
        try{
            $query_name = $p_sql_queries->update_announcement($title,$description,$annID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;


        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }

    /*Module Announcements*/
    public function getModuleAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$name, $email){
        try{
            $query_name = $p_sql_queries->get_module_announcement($name, $email);
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


    /*Attendance Control*/
    public function getClasses($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$email){
        try{
            $query_name = $p_sql_queries->get_classes($email);
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
    public function getAttendance($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$classID){
        try{
            $query_name = $p_sql_queries->get_student_attendance($classID);
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

    public function check_attendance($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$classID)
    {
        try {
            $query_name = $p_sql_queries->check_student_attendance($classID);
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

    public function setAttendance($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$classID,$uniqueID,$bool){
        try{
            $query_name = $p_sql_queries->set_student_attendance($classID,$uniqueID,$bool);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;


        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }
    public function deleteAttendance($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$classID){
        try{
            $query_name = $p_sql_queries->delete_student_attendance($classID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;


        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }

    /*Coursework Control*/

    public function getCoursework($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$module){
        try{
            $query_name = $p_sql_queries->get_coursework($module);
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
    public function setCoursework($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$moduleID,$description,$date,$location){
        try{
            $query_name = $p_sql_queries->set_coursework($moduleID,$description,$date,$location);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;


        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }

    public function removeCoursework($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$courseworkID){
        try{
            $query_name = $p_sql_queries->remove_coursework($courseworkID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;


        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }

    public function updateCoursework($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$courseworkID,$description,$date,$brief){
        try{
            $query_name = $p_sql_queries->update_coursework($courseworkID,$description,$date,$brief);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;


        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }

    /*Course Content Control*/

    public function getPractical($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$module){
        try{
            $query_name = $p_sql_queries->get_practical($module);
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
    public function setPractical($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$moduleID,$title,$description,$pdf){
        try{
            $query_name = $p_sql_queries->set_practical($moduleID,$title,$description,$pdf);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;


        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }
    public function updateLearning($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$moduleID,$title,$description,$pdf,$resID){
        try{
            $query_name = $p_sql_queries->update_learning($moduleID,$title,$description,$pdf,$resID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;


        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }
    public function removeLearning($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$resID){
        try{
            $query_name = $p_sql_queries->remove_learning($resID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;


        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }

    public function getTheory($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$module){
        try{
            $query_name = $p_sql_queries->get_theory($module);
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
    public function setTheory($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$moduleID,$title,$description,$pdf){
        try{
            $query_name = $p_sql_queries->set_theory($moduleID,$title,$description,$pdf);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;

        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }



    /*Assignment Marking*/

    public function getSubmissions($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$module){
        try{
            $query_name = $p_sql_queries->get_submissions($module);
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
    public function getMarkedSubmissions($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$module){
        try{
            $query_name = $p_sql_queries->get_marked_submissions($module);
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

    public function updateSubmissions($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$feedback,$value){
        try{
            $query_name = $p_sql_queries->update_submissions($feedback,$value);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;

        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }
    public function removeSubmissions($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$subID){
        try{
            $query_name = $p_sql_queries->remove_submissions($subID);
            $p_wrapper_mysql->set_db_handle($p_db_handle);
            $p_wrapper_mysql->safe_query($query_name);

            return true;

        } catch (Exception $e){
            throwException($e);
            return false;
        }
    }

    public function getAssignmentNumber($p_db_handle, $p_sql_queries, $p_wrapper_mysql,$email){
        try{
            $query_name = $p_sql_queries->number_of_assignments($email);
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

}