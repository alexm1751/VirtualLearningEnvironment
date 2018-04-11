<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 30/03/2018
 * Time: 13:16
 */

class SQLQueries
{

    public function __construct()
    {
    }

    public function __destruct()
    {
    }


    public static function check_user_exists($email)
    {
        $m_sql_query_string  = "SELECT dbEmail ";
        $m_sql_query_string .= "FROM vle_users ";
        $m_sql_query_string .= "WHERE dbEmail =  '$email' ";
        return $m_sql_query_string;


    }

    /**Builds an SQL string to get a password for a given phone number from the user table
     * @param $number Phone number to check
     * @return string string SQL select statement
     */
    public static function check_password($email){
        $m_sql_query_string  = "SELECT dbpass ";
        $m_sql_query_string .= "FROM vle_users ";
        $m_sql_query_string .= "WHERE dbEmail =  '$email' ";
        return $m_sql_query_string;
    }

    /**Builds an SQL string to get a users name from the user table with a given phone number
     * @param $number Phone number to check
     * @return string string SQL select statement
     */
    public static function check_rank($email){
        $m_sql_query_string  = "SELECT dbRank ";
        $m_sql_query_string .= "FROM vle_users ";
        $m_sql_query_string .= "WHERE dbEmail =  '$email'";
        return $m_sql_query_string;
    }

    public static function update_user_hash($email, $hash){
        $m_sql_query_string  = "UPDATE vle_users set dbRecover_Hash = '$hash' ";
        $m_sql_query_string .= "WHERE dbEmail = '$email' ";
        return $m_sql_query_string;
    }
    public static function check_hash($email){
        $m_sql_query_string  = "SELECT dbRecover_Hash ";
        $m_sql_query_string .= "FROM vle_users ";
        $m_sql_query_string .= "WHERE dbEmail =  '$email' ";
        return $m_sql_query_string;
    }

    public static function update_pass($email, $hash){
        $m_sql_query_string  = "UPDATE vle_users set dbPass = '$hash' ";
        $m_sql_query_string .= "WHERE dbEmail = '$email' ";
        return $m_sql_query_string;
    }
    public static function get_name($email){
        $m_sql_query_string  = "SELECT dbFullName ";
        $m_sql_query_string .= "FROM vle_users ";
        $m_sql_query_string .= "WHERE dbEmail =  '$email' ";
        return $m_sql_query_string;
    }

    public static function get_modules($email){
        $m_sql_query_string  = "SELECT DISTINCT c.dbModuleTitle ";
        $m_sql_query_string .= "FROM vle_allocation z, vle_users a , vle_modules c ";
        $m_sql_query_string .= "WHERE z.dbUniqueID = a.dbUniqueID  ";
        $m_sql_query_string .= "AND z.dbModuleID = c.dbModuleID AND a.dbEmail=  '$email' ";
        return $m_sql_query_string;
    }

    public static function get_courses($email){
        $m_sql_query_string  = "SELECT DISTINCT c.dbCourseName ";
        $m_sql_query_string .= "FROM vle_allocation z, vle_users a , vle_courses c ";
        $m_sql_query_string .= "WHERE z.dbUniqueID = a.dbUniqueID  ";
        $m_sql_query_string .= "AND z.dbCourseID = c.dbCourseID AND a.dbEmail=  '$email' ";
        return $m_sql_query_string;
    }

    public static function get_profileDetails($email){
        $m_sql_query_string  = "SELECT dbFullName, dbEmail, dbAddress, dbNumber ";
        $m_sql_query_string .= "FROM vle_users ";
        $m_sql_query_string .= "WHERE dbEmail = '$email'";
        return $m_sql_query_string;
    }

    /*STUDENT Queries*/

    public static function get_attendance($email){
        $m_sql_query_string  = "SELECT a.dbClassID, a.dbAttended ";
        $m_sql_query_string .= "FROM vle_attendance a, vle_users b ";
        $m_sql_query_string .= "WHERE a.dbUniqueID = b.dbUniqueID ";
        $m_sql_query_string .= "AND a.dbAttended= 0 ";
        $m_sql_query_string .= "AND b.dbEmail = '$email'";
        return $m_sql_query_string;
    }
    public static function get_timetable($email){
        $m_sql_query_string  = "SELECT DISTINCT a.dbtablepdf ";
        $m_sql_query_string .= "FROM vle_timetables a, vle_allocation b, vle_users c ";
        $m_sql_query_string .= "WHERE a.dbCourseID = b.dbCourseID ";
        $m_sql_query_string .= "AND b.dbUniqueID = c.dbUniqueID ";
        $m_sql_query_string .= "AND c.dbEmail = '$email'";
        return $m_sql_query_string;
    }
    public static function get_module_announcements($module){
        $m_sql_query_string  = "SELECT a.dbAnnouncementTitle, a.dbDescription, a.dbDate ";
        $m_sql_query_string .= "FROM vle_announcements a, vle_allocation b, vle_users c ";
        $m_sql_query_string .= "WHERE a.dbModuleID = b.dbModuleID ";
        $m_sql_query_string .= "AND b.dbUniqueID = c.dbUniqueID  ";
        $m_sql_query_string .= "AND b.dbModuleTitle = '$module'";
        return $m_sql_query_string;
    }
    public static function get_course_announcements($email){
        $m_sql_query_string  = "SELECT DISTINCT a.dbAnnouncementTitle, bEmail = '$email' AND a.dbModuleID IS NULL ";
        return $m_sql_query_string;
    }
    public static function get_deadlines($email, $module){
        $m_sql_query_string  = "SELECT a.dbDescription, a.dbDeadline
        FROM vle_coursework a, vle_allocation b, vle_users c
        WHERE a.dbModuleID = b.dbModuleID
        AND b.dbUniqueID = c.dbUniqueID 
        AND c.dbEmail = '$email'
        AND a.dbModuleTitle = '$module'";
        return $m_sql_query_string;
    }
    public static function get_staff_info($module){
        $m_sql_query_string  = "SELECT a.dbFullName, a.dbEmail
        FROM vle_users a, vle_allocation b
        WHERE a.dbUniqueID = b.dbUniqueID
        AND b.dbTeaches = 1
        AND b.dbModuleTitle = '$module'";
        return $m_sql_query_string;
    }
    public static function get_theory_content($email,$module){
        $m_sql_query_string  = "SELECT a.dbLearningTitle, a.dbDescription, a.dbPDF, a.dbDate
        FROM vle_learning a, vle_allocation b, vle_users c
        WHERE a.dbModuleID = b.dbModuleID
        AND b.dbUniqueID = c.dbUniqueID
        AND a.dbTheory = 1
        AND a.dbPractical = 0
        AND a.dbModuleTitle = '$module'
        AND c.dbEmail = '$email'";
        return $m_sql_query_string;
    }    
    public static function get_practical_content($email,$module){
    $m_sql_query_string  = "SELECT a.dbLearningTitle, a.dbDescription, a.dbPDF, a.dbDate
    FROM vle_learning a, vle_allocation b, vle_users c
    WHERE a.dbModuleID = b.dbModuleID
    AND b.dbUniqueID = c.dbUniqueID
    AND a.dbTheory = 0
    AND a.dbPractical = 1
    AND a.dbModuleTitle = '$module'
    AND c.dbEmail = '$email'";
    return $m_sql_query_string;
    }
    public static function get_assessments($email,$module){
        $m_sql_query_string  = "SELECT a.dbDescription,a.dbPostDate, a.dbDeadline, a.dbbrief
        FROM vle_coursework a, vle_allocation b, vle_users c
        WHERE a.dbModuleID = b.dbModuleID
        AND b.dbUniqueID = c.dbUniqueID 
        AND c.dbEmail = '$email'
        AND a.dbModuleTitle = '$module'";
        return $m_sql_query_string;
    }
    public static function submit_assessments($courseworkID,$uniqueID){
        $m_sql_query_string  = "INSERT INTO vle_submissions(dbDate,dbSubPdf, dbCourseWorkID,dbUniqueID)
        VALUES (DEFAULT ,'/Applications/MAMP/htdocs/FinalYearProject/VLE_Public/media/Assignment1.pdf', '$courseworkID', '$uniqueID')";

        return $m_sql_query_string;
    }
    public static function get_feedback($email,$module){
        $m_sql_query_string  = "SELECT a.dbDescription, b.dbFeedback, b.dbMarked
        FROM vle_coursework a, vle_submissions b, vle_allocation c, vle_users d
        WHERE a.dbCourseWorkID = b.dbCourseWorkID
        AND b.dbUniqueID = c.dbUniqueID
        AND c.dbUniqueID = d.dbUniqueID
        AND c.dbModuleTitle = '$module'
        AND b.dbEmail = '$email'
        AND b.dbMarked = 1";
        return $m_sql_query_string;
    }


}