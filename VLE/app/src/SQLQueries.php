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
        $m_sql_query_string  = "SELECT c.dbModuleTitle ";
        $m_sql_query_string .= "FROM vle_allocation z, vle_users a , vle_modules c ";
        $m_sql_query_string .= "WHERE z.dbUniqueID = a.dbUniqueID  ";
        $m_sql_query_string .= "AND z.dbModuleID = c.dbModuleID AND a.dbEmail=  '$email' ";
        return $m_sql_query_string;
    }

}