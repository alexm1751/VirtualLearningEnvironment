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

    public static function check_password($email){
        $m_sql_query_string  = "SELECT dbpass ";
        $m_sql_query_string .= "FROM vle_users ";
        $m_sql_query_string .= "WHERE dbEmail =  '$email' ";
        return $m_sql_query_string;
    }


    public static function check_rank($email){
        $m_sql_query_string  = "SELECT dbRank ";
        $m_sql_query_string .= "FROM vle_users ";
        $m_sql_query_string .= "WHERE dbEmail =  '$email'";
        return $m_sql_query_string;
    }
    public static function check_rank_id($user_id){
        $m_sql_query_string  = "SELECT dbRank ";
        $m_sql_query_string .= "FROM vle_users ";
        $m_sql_query_string .= "WHERE dbUniqueID =  '$user_id'";
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
    public static function get_course_modules($course_id){
        $m_sql_query_string  = "SELECT DISTINCT dbModuleID
                                FROM vle_modules
                                WHERE dbCourseID=  '$course_id'";
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
    public static function update_profileDetails($name,$address,$number,$email){
        $m_sql_query_string  = "UPDATE vle_users ";
        $m_sql_query_string .= "SET   dbFullName='$name', dbAddress='$address', dbNumber='$number' ";
        $m_sql_query_string .= "WHERE dbEmail = '$email'";
        return $m_sql_query_string;
    }

    /*STUDENT Queries*/

    public static function get_attendance($email){
        $m_sql_query_string  = "SELECT a.dbClassID, d.dbModuleTitle , c.dbDescAndWeek, date(c.dbDate) as date, a.dbAttended
        FROM vle_attendance a ,vle_users b, vle_classes c , vle_modules d
        WHERE a.dbUniqueID = b.dbUniqueID
        AND a.dbClassID = c.dbClassID
        AND c.dbModuleID = d.dbModuleID
        AND a.dbAttended= 0
        AND b.dbEmail= '$email'";
        return $m_sql_query_string;
    }

    public static function get_percent($email){
        $m_sql_query_string  = "SELECT CAST( SUM(a.dbAttended) / COUNT(a.dbAttended)*100 AS UNSIGNED) as percent
        FROM vle_attendance a, vle_users b
        WHERE a.dbUniqueID = b.dbUniqueID
        AND b.dbEmail = '$email'";
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
        $m_sql_query_string  = "SELECT DISTINCT a.dbAnnouncementTitle, a.dbDescription, a.dbDate ";
        $m_sql_query_string .= "FROM vle_announcements a, vle_allocation b, vle_modules c ";
        $m_sql_query_string .= "WHERE a.dbModuleID = b.dbModuleID ";
        $m_sql_query_string .= "AND b.dbModuleID = c.dbModuleID  ";
        $m_sql_query_string .= "AND c.dbModuleTitle = '$module'";
        return $m_sql_query_string;
    }
    public static function get_course_announcements($email,$course_name){
        $m_sql_query_string  = "SELECT DISTINCT a.dbAnnouncementID,a.dbAnnouncementTitle, a.dbDescription, a.dbDate, d.dbCourseID
        FROM vle_announcements a, vle_allocation b, vle_users c , vle_courses d
        WHERE a.dbCourseID = b.dbCourseID
        AND b.dbUniqueID = c.dbUniqueID
        AND a.dbCourseID =d.dbCourseID
        AND d.dbCourseName = '$course_name'
        AND c.dbEmail = '$email' 
        AND a.dbModuleID IS NULL ";
        return $m_sql_query_string;
    }
    public static function get_deadlines($email, $module){
        $m_sql_query_string  = "SELECT a.dbDescription, a.dbDeadline
        FROM vle_coursework a, vle_allocation b, vle_users c, vle_modules d
        WHERE a.dbModuleID = b.dbModuleID
        AND b.dbUniqueID = c.dbUniqueID 
        AND b.dbModuleID=d.dbModuleID
        AND c.dbEmail = '$email'
        AND d.dbModuleTitle = '$module'";
        return $m_sql_query_string;
    }
    public static function get_staff_info($module){
        $m_sql_query_string  = "SELECT a.dbFullName, a.dbEmail
        FROM vle_users a, vle_allocation b, vle_modules c
        WHERE a.dbUniqueID = b.dbUniqueID
        AND b.dbModuleID=c.dbModuleID
        AND b.dbTeaches = 1
        AND c.dbModuleTitle = '$module'";
        return $m_sql_query_string;
    }
    public static function get_theory_content($email,$module){
        $m_sql_query_string  = "SELECT DISTINCT a.dbLearningTitle, a.dbDescription, a.dbPDF, date(a.dbDate)as dbDate
        FROM vle_learning a, vle_allocation b, vle_users c, vle_modules d
        WHERE a.dbModuleID = b.dbModuleID
        AND b.dbUniqueID = c.dbUniqueID
        AND a.dbModuleID = d.dbModuleID
        AND a.dbTheory = 1
        AND a.dbPractical = 0
        AND d.dbModuleTitle = '$module'
        AND c.dbEmail = '$email'";
        return $m_sql_query_string;
    }    
    public static function get_practical_content($email,$module){
    $m_sql_query_string  = "SELECT DISTINCT a.dbLearningTitle, a.dbDescription, a.dbPDF, date(a.dbDate)as dbDate
        FROM vle_learning a, vle_allocation b, vle_users c, vle_modules d
        WHERE a.dbModuleID = b.dbModuleID
        AND b.dbUniqueID = c.dbUniqueID
        AND a.dbModuleID = d.dbModuleID
        AND a.dbTheory = 0
        AND a.dbPractical = 1
        AND d.dbModuleTitle = '$module'
        AND c.dbEmail = '$email'";
    return $m_sql_query_string;
    }
    public static function get_assessments($email,$module){
        $m_sql_query_string  = "SELECT a.dbDescription, a.dbPostDate, a.dbDeadline, a.dbbrief, c.dbUniqueID, a.dbCourseWorkID
        FROM vle_coursework a, vle_allocation b, vle_users c, vle_modules d
        WHERE a.dbModuleID = b.dbModuleID
        AND b.dbUniqueID = c.dbUniqueID 
        AND b.dbModuleID = d.dbModuleID
        AND c.dbEmail = '$email'
        AND d.dbModuleTitle = '$module'";
        return $m_sql_query_string;
    }
    public static function check_submission($userID,$courseID){
        $m_sql_query_string  = "SELECT dbSubmissionID, dbUniqueID, dbCourseWorkID
        FROM vle_submissions
        WHERE dbUniqueID = '$userID'
        AND dbCourseWorkID = '$courseID'";
        return $m_sql_query_string;
    }
    public static function submit_assessments($courseworkID,$uniqueID,$filename){
        $m_sql_query_string  = "INSERT INTO vle_submissions(dbDate,dbFeedback,dbSubPdf,dbMarked, dbCourseWorkID,dbUniqueID)
        VALUES (DEFAULT ,'','$filename',0, $courseworkID, $uniqueID)";

        return $m_sql_query_string;
    }
    public static function get_feedback($email,$module){
        $m_sql_query_string  = "SELECT a.dbDescription, b.dbFeedback, b.dbMarked
                FROM vle_coursework a, vle_submissions b, vle_allocation c, vle_users d, vle_modules e
                WHERE a.dbCourseWorkID = b.dbCourseWorkID
                AND b.dbUniqueID = c.dbUniqueID
                AND c.dbUniqueID = d.dbUniqueID
                AND c.dbModuleID = e.dbModuleID
                AND e.dbModuleTitle = '$module'
                AND d.dbEmail = '$email'
                AND b.dbMarked = 1";
        return $m_sql_query_string;
    }

    /*Teacher Queries*/



    public static function set_announcement($name,$courseID,$moduleID,$description){
        $m_sql_query_string  = "INSERT INTO vle_announcements(dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
        VALUES ('$name', $courseID, $moduleID, '$description', default)";
        return $m_sql_query_string;
    }
    public static function remove_announcement($annID){
        $m_sql_query_string  = "DELETE FROM vle_announcements
        WHERE dbAnnouncementID = '$annID'";
        return $m_sql_query_string;
    }
    public static function update_announcement($title,$description,$annID){
        $m_sql_query_string  = " UPDATE vle_announcements
        SET dbAnnouncementTitle = '$title', dbDescription = '$description', dbDate = CURRENT_TIMESTAMP
        WHERE dbAnnouncementID = '$annID'";
        return $m_sql_query_string;
    }
    public static function get_module_announcement($name,$email){
        $m_sql_query_string  = "SELECT DISTINCT a.dbAnnouncementID,a.dbAnnouncementTitle,a.dbCourseID,a.dbModuleID,a.dbDescription,a.dbDate , d.dbModuleTitle
        FROM vle_announcements a, vle_allocation b, vle_users c , vle_modules d
        WHERE a.dbCourseID = b.dbCourseID
        AND b.dbUniqueID = c.dbUniqueID
        AND a.dbModuleID = d.dbModuleID
        AND a.dbModuleID is NOT NULL
        AND c.dbEmail = '$email'
        AND d.dbModuleTitle = '$name'";
        return $m_sql_query_string;
    }
    public static function get_modules_id($module_name){
        $m_sql_query_string = "SELECT dbModuleID FROM vle_modules WHERE dbModuleTitle = '$module_name'";

        return $m_sql_query_string;
    }
    public static function get_classes($email){
        $m_sql_query_string  = "SELECT a.dbClassID, a.dbDate, a.dbDescAndWeek, d.dbModuleTitle
        FROM vle_classes a , vle_allocation b, vle_users c, vle_modules d
        WHERE a.dbModuleID = b.dbModuleID
        AND b.dbUniqueID = c.dbUniqueID
        AND b.dbModuleID = d.dbModuleID
        AND b.dbTeaches = 1
        AND c.dbEmail = '$email'";
        return $m_sql_query_string;
    }
    public static function check_student_attendance($classID){
        $m_sql_query_string  = "SELECT dbClassID
                FROM vle_attendance 
                WHERE dbClassID = '$classID'";
        return $m_sql_query_string;
    }
    public static function get_student_attendance($classID){
        $m_sql_query_string  = "SELECT a.dbUniqueID,a.dbFullName, b.dbClassID,d.dbModuleID
                FROM vle_users a ,vle_allocation d, vle_classes b 
                WHERE a.dbUniqueID = d.dbUniqueID
                AND d.dbModuleID = b.dbModuleID
                AND d.dbTeaches = 0
                AND b.dbClassID = '$classID'";
        return $m_sql_query_string;
    }

    public static function set_student_attendance($classID,$uniqueID,$bool){
        $m_sql_query_string  = "INSERT INTO vle_attendance(dbClassID, dbUniqueID, dbAttended)
        VALUES($classID,$uniqueID,$bool)";
        return $m_sql_query_string;
    }
    public static function delete_student_attendance($classID){
        $m_sql_query_string  = "DELETE FROM vle_attendance
        WHERE dbClassID = $classID";
        return $m_sql_query_string;
    }
    public static function get_coursework($module){
        $m_sql_query_string  = "SELECT DISTINCT a.dbCourseWorkID, a.dbDescription,a.dbPostDate, a.dbDeadline, a.dbbrief, a.dbModuleID
        FROM vle_coursework a, vle_allocation b, vle_modules c
        WHERE a.dbModuleID = b.dbModuleID
        AND a.dbModuleID = c.dbModuleID
        AND c.dbModuleTitle = '$module'";
        return $m_sql_query_string;
    }
    public static function set_coursework($moduleID,$description,$date,$location){
        $m_sql_query_string  = "INSERT INTO vle_coursework(dbDescription,dbPostDate,dbDeadline,dbbrief,dbModuleID)
        VALUES ('$description', default, '$date','$location', '$moduleID')";
        return $m_sql_query_string;
    }
    public static function remove_coursework($courseworkID){
        $m_sql_query_string  = "DELETE FROM vle_coursework
        WHERE dbCourseWorkID = '$courseworkID'";
        return $m_sql_query_string;
    }
    public static function update_coursework($courseworkID,$description,$date,$brief){
        $m_sql_query_string  = "UPDATE vle_coursework
        SET dbDescription='$description', dbDeadline='$date', dbbrief='$brief'
        WHERE dbCourseWorkID = '$courseworkID'";
        return $m_sql_query_string;
    }
    public static function get_practical($module){
        $m_sql_query_string  = "SELECT DISTINCT a.dbResID,a.dbLearningTitle, a.dbDescription, a.dbPDF, a.dbDate,  a.dbModuleID
        FROM vle_learning a, vle_modules b
        WHERE a.dbModuleID = b.dbModuleID
        AND a.dbPractical = 1
        AND b.dbModuleTitle = '$module'";
        return $m_sql_query_string;
    }
    public static function set_practical($moduleID,$title,$description,$pdf){
        $m_sql_query_string  = "INSERT INTO vle_learning(dbPractical,dbTheory,dbLearningTitle,dbDescription,dbPDF,dbDate,dbModuleID)
        VALUES ( 1, 0, '$title', '$description','$pdf', default, $moduleID)";

        return $m_sql_query_string;
    }
    public static function update_learning($moduleID,$title,$description,$pdf,$resID){
        $m_sql_query_string  = "UPDATE vle_coursework
        SET dbLearningTitle='$title',dbDescription='$description',dbPDF='$pdf',dbModuleID='$moduleID'
        WHERE dbResID = '$resID'";

        return $m_sql_query_string;
    }
    public static function get_theory($module){
        $m_sql_query_string  = "SELECT DISTINCT a.dbResID,a.dbLearningTitle, a.dbDescription, a.dbPDF, a.dbDate, a.dbModuleID
        FROM vle_learning a, vle_modules b
        WHERE a.dbModuleID = b.dbModuleID
        AND a.dbTheory = 1
        AND b.dbModuleTitle = '$module'";

        return $m_sql_query_string;
    }
    public static function set_theory($moduleID,$title,$description,$pdf){
        $m_sql_query_string  = "INSERT INTO vle_learning(dbPractical,dbTheory,dbLearningTitle,dbDescription,dbPDF,dbDate,dbModuleID)
        VALUES ( 0, 1, '$title', '$description','$pdf', default, $moduleID)";

        return $m_sql_query_string;
    }
    public static function remove_learning($resID){
        $m_sql_query_string  = "DELETE FROM vle_learning
        WHERE dbResID = $resID";

        return $m_sql_query_string;
    }
    public static function get_submissions($module){
        $m_sql_query_string  = "SELECT  a.dbUniqueID, d.dbFullName,b.dbDescription, a.dbDate, b.dbDeadline
         FROM vle_submissions a , vle_coursework b ,vle_modules c, vle_users d
         WHERE a.dbCourseWorkID = b.dbCourseWorkID
         AND b.dbModuleID = c.dbModuleID
         AND a.dbUniqueID = d.dbUniqueID
         AND dbModuleTitle = '$module'
         AND dbMarked = 0";

        return $m_sql_query_string;
    }
    public static function get_marked_submissions($module){
        $m_sql_query_string  = "SELECT  a.dbUniqueID, d.dbFullName,b.dbDescription, a.dbDate, b.dbDeadline
         FROM vle_submissions a , vle_coursework b ,vle_modules c, vle_users d
         WHERE a.dbCourseWorkID = b.dbCourseWorkID
         AND b.dbModuleID = c.dbModuleID
         AND a.dbUniqueID = d.dbUniqueID
         AND dbModuleTitle = '$module'
         AND dbMarked = 1";

        return $m_sql_query_string;
    }

    public static function update_submissions($feedback){
        $m_sql_query_string  = " UPDATE vle_submissions
         SET dbFeedback='$feedback', dbMarked=1";

        return $m_sql_query_string;
    }
    public static function remove_submissions($subID){
        $m_sql_query_string  =  "DELETE FROM vle_submissions
          WHERE dbSumissionID='$subID'";

        return $m_sql_query_string;
    }

    /*Admin Queries*/


    public static function admin_get_courses(){
        $m_sql_query_string  =
            "SELECT dbCourseID, dbCourseName, dbCourseDescription,dbCredits,dbYears,dbDegreeType
            FROM vle_courses";
        return $m_sql_query_string;
    }
    public static function admin_set_courses($courseName,$courseDescription,$credits,$years,$degree){
        $m_sql_query_string  = "INSERT INTO vle_courses(dbCourseName, dbCourseDescription,dbCredits,dbYears,dbDegreeType)
            VALUES ('$courseName','$courseDescription','$credits','$years','$degree')";
        return $m_sql_query_string;
    }
    public static function admin_update_courses($courseName,$courseDescription,$credits,$years,$degree,$courseID){
        $m_sql_query_string  =
            "Update vle_courses
            SET dbCourseName='$courseName', dbCourseDescription= '$courseDescription', dbCredits='$credits', dbYears='$years', dbDegreeType='$degree'
            WHERE dbCourseID ='$courseID'";
        return $m_sql_query_string;
    }
    public static function admin_remove_courses($courseID){
        $m_sql_query_string  =
            "DELETE FROM vle_courses
            WHERE dbCourseID='$courseID'";

        return $m_sql_query_string;
    }
    public static function admin_get_modules(){
        $m_sql_query_string  =
            "SELECT dbModuleID,dbModuleTitle, dbModuleDescription,dbCredits,dbCourseID
            FROM vle_modules";

        return $m_sql_query_string;
    }
    public static function admin_set_modules($moduleTitle,$moduleDescription,$credits,$courseID){
        $m_sql_query_string  =
            "INSERT INTO vle_modules(dbModuleTitle, dbModuleDescription,dbCredits,dbCourseID)
            VALUES ('$moduleTitle','$moduleDescription','$credits','$courseID')";

        return $m_sql_query_string;
    }
    public static function admin_update_modules($moduleTitle,$moduleDescription,$credits,$courseID, $moduleID){
    $m_sql_query_string  =
        "UPDATE vle_modules
        SET dbModuleTitle='$moduleTitle', dbModuleDescription= '$moduleDescription', dbCredits='$credits', dbCourseID='$courseID'
        WHERE dbModuleID ='$moduleID'";

        return $m_sql_query_string;
    }
    public static function admin_remove_modules($moduleID){
        $m_sql_query_string  =
            "DELETE FROM vle_modules
                WHERE dbModuleID='$moduleID'";

        return $m_sql_query_string;
    }
    public static function admin_get_users(){
        $m_sql_query_string  =
            "SELECT DISTINCT dbUniqueID,dbEmail, dbFullName,dbAddress,dbNumber, dbGender,dbRank
            FROM vle_users a 
            WHERE dbRank = 1 OR dbRank = 2";

        return $m_sql_query_string;
    }
    public static function admin_set_users($password,$email,$name,$address,$number,$rank,$gender){
        $m_sql_query_string  =
            "INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
                VALUES ('$password','$email', '$name','$address','$number', '$rank', '$gender','', DEFAULT)";

        return $m_sql_query_string;
    }
    public static function admin_update_users($email,$name,$address,$number,$rank,$gender,$uniqueID){
    $m_sql_query_string  = "UPDATE vle_users
    SET  dbEmail= '$email', dbFullName='$name', dbAddress='$address', dbNumber='$number',dbRank='$rank',dbGender='$gender'
    WHERE dbUniqueID ='$uniqueID'";

        return $m_sql_query_string;
    }
    public static function admin_remove_users($uniqueID){
        $m_sql_query_string  ="DELETE FROM vle_users
        WHERE dbUniqueID = '$uniqueID'";


        return $m_sql_query_string;
    }
    public static function admin_get_classes(){
        $m_sql_query_string  =
            "SELECT dbClassID, dbModuleID, dbDate, dbDescAndWeek
            FROM vle_classes";

        return $m_sql_query_string;
    }
    public static function admin_set_classes($moduleID, $date, $description){
        $m_sql_query_string  =
            "INSERT INTO vle_classes(dbModuleID,dbDate,dbDescAndWeek)
            VALUES ('$moduleID', '$date', '$description')";

        return $m_sql_query_string;
    }
    public static function admin_update_classes($classID,$moduleID,$date,$descAndWeek){
        $m_sql_query_string  =
            "UPDATE vle_classes
            SET dbModuleID='$moduleID', dbDate= '$date', dbDescAndWeek='$descAndWeek'
            WHERE dbClassID ='$classID'";

        return $m_sql_query_string;
    }
    public static function admin_remove_classes($classID){
        $m_sql_query_string  =
            "DELETE FROM vle_classes
                WHERE dbClassID = '$classID'";


        return $m_sql_query_string;
    }
    public static function admin_get_timetables(){
        $m_sql_query_string  =
            "SELECT a.dbTimeTableID, a.dbtablepdf, a.dbCourseID, b.dbCourseName
            
            FROM vle_timetables a, vle_courses b
            WHERE a.dbCourseID = b.dbCourseID";

        return $m_sql_query_string;
    }
    public static function admin_set_timetables($pdf,$courseID){
        $m_sql_query_string  =
            "INSERT INTO vle_timetables(dbtablepdf,dbCourseID)
            VALUES('$pdf','$courseID')";

        return $m_sql_query_string;
    }
    public static function check_timetable($course_id){
        $m_sql_query_string  = "SELECT dbCourseID
        FROM vle_timetables
        WHERE dbCourseID = '$course_id'";
        return $m_sql_query_string;
    }
    public static function admin_remove_timetables($timetableID){
        $m_sql_query_string  =
            "DELETE FROM vle_timetables
WHERE dbTimeTableID = '$timetableID'";

        return $m_sql_query_string;
    }
    public static function admin_get_admins(){
        $m_sql_query_string  =
            "SELECT dbUniqueID,dbEmail, dbFullName,dbAddress,dbNumber,dbGender, dbRank
            FROM vle_users
            WHERE dbRank = 3 OR dbRank = 4";


        return $m_sql_query_string;
    }
    public static function admin_set_admins($password,$email,$name,$address,$number,$rank,$gender){
        $m_sql_query_string  =
            "INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
            VALUES ('$password','$email', '$name','$address','$number', '$rank', '$gender','', DEFAULT)";

        return $m_sql_query_string;
    }
    public static function admin_get_allocation(){
        $m_sql_query_string= "SELECT DISTINCT b.dbUniqueID,a.dbFullName,a.dbRank, b.dbCourseID, c.dbCourseName, b.dbTeaches
        FROM vle_users a, vle_allocation b, vle_courses c
        WHERE a.dbUniqueID = b.dbUniqueID
        AND b.dbCourseID = c.dbCourseID";
        return $m_sql_query_string;
}
    public static function admin_check_user_allocation($unique_id){
        $m_sql_query_string= "SELECT DISTINCT b.dbUniqueID,a.dbFullName,a.dbRank, b.dbCourseID, c.dbCourseName, b.dbTeaches
        FROM vle_users a, vle_allocation b, vle_courses c
        WHERE a.dbUniqueID = b.dbUniqueID
        AND b.dbCourseID = c.dbCourseID
        AND b.dbUniqueID = '$unique_id'";
        return $m_sql_query_string;
    }
    public static function admin_set_allocation($rank,$user_id,$course_id,$module_id){
        $m_sql_query_string  = "INSERT INTO vle_allocation(dbTeaches, dbUniqueID, dbCourseID, dbModuleID)
        VALUES('$rank','$user_id','$course_id','$module_id')";

        return $m_sql_query_string;
    }

    public static function getCourse($email){
        $m_sql_query_string = "SELECT DISTINCT a.dbCourseName , a.dbCourseDescription
        FROM vle_courses a , vle_allocation b, vle_users c
        WHERE a.dbCourseID = b.dbCourseID
        AND b.dbUniqueID = c.dbUniqueID
        AND c.dbEmail = '$email'";
        return $m_sql_query_string;
    }
    public static function admin_remove_allocation($user_id,$course_id){
        $m_sql_query_string  =
            "DELETE FROM vle_allocation
            WHERE dbUniqueID = '$user_id'
            AND dbCourseID = '$course_id'";

        return $m_sql_query_string;
    }
}