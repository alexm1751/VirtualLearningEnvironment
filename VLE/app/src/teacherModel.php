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
    /*Course Announcements*/
    public function getCourseAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function setCourseAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function removeCourseAnnouncement($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function updateCourseAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }

    /*Module Announcements*/
    public function getModuleAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function setModuleAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function removeModuleAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function updateModuleAnnouncements($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }

    /*Attendance Control*/

    public function getAttendance($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }

    public function setAttendance($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function updateAttendance($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }

    /*Coursework Control*/

    public function getCoursework($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function setCoursework($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }

    public function removeCoursework($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }

    public function updateCoursework($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }

    /*Course Content Control*/

    public function getPractical($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function setPractical($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function updatePractical($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function removePractical($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }

    public function getTheory($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function setTheory($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function updateTheory($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }
    public function removeTheory($p_db_handle, $p_sql_queries, $p_wrapper_mysql){

    }


    /*Assignment Marking*/

    public function getSubmissions($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }

    public function updateSubmissions($p_db_handle, $p_sql_queries, $p_wrapper_mysql){
        try{

        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }



}