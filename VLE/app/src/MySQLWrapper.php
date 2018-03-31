<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 30/03/2018
 * Time: 13:15
 */

class MySQLWrapper
{
    private $c_obj_db_handle;
    private $c_obj_sql_queries;
    private $c_obj_stmt;
    private $c_arr_errors;

    public function __construct()
    {
        $this->c_obj_db_handle = null;
        $this->c_obj_sql_queries = null;
        $this->c_obj_stmt = null;
        $this->c_arr_errors = [];
    }

    public function __destruct() { }

    public function set_db_handle($p_obj_db_handle)
    {
        $this->c_obj_db_handle = $p_obj_db_handle;
    }

    /**Using a build in library PDO, this function take a string in the form of an SQL query and any parameters
     * to pass with it and attempts to query the SQL database attached to this application. An error is thrown
     * in the event PDO can not complete the function.
     * @param $p_query_string SQL string to query the database with
     * @param null $p_arr_params Data to be passed to the database
     * @return mixed
     */
    public function safe_query($p_query_string, $p_arr_params = null)
    {
        $this->c_arr_errors['db_error'] = false;
        $m_query_string = $p_query_string;
        $m_arr_query_parameters = $p_arr_params;
        try
        {
            $m_temp = array();
            $this->c_obj_stmt = $this->c_obj_db_handle->prepare($m_query_string);

            // bind the parameters
            if (sizeof($m_arr_query_parameters) > 0)
            {
                foreach ($m_arr_query_parameters as $m_param_key => $m_param_value)
                {
                    $m_temp[$m_param_key] = $m_param_value;
                    $this->c_obj_stmt->bindParam($m_param_key, $m_temp[$m_param_key], PDO::PARAM_STR);
                }
            }

            // execute the query
            $m_execute_result = $this->c_obj_stmt->execute();
            $this->c_arr_errors['execute-OK'] = $m_execute_result;
        }
        catch (PDOException $exception_object)
        {
            $m_error_message  = 'PDO Exception caught. ';
            $m_error_message .= 'Error with the database access.' . "\n";
            $m_error_message .= 'SQL query: ' . $m_query_string . "\n";
            $m_error_message .= 'Error: ' . //var_dump($this->c_obj_stmt->errorInfo(), true) . "\n";
                // NB would usually output to file for sysadmin attention
                $this->c_arr_errors['db_error'] = true;
            $this->c_arr_errors['sql_error'] = $m_error_message;
        }
        return $this->c_arr_errors['db_error'];
    }

    /**Count ths number of rows for a given SQL query
     * @return mixed
     */
    public function count_rows()
    {
        $m_num_rows = $this->c_obj_stmt->rowCount();
        return $m_num_rows;
    }

    /**Returns a row of data for the current instance on MySQLWrapper
     * @return mixed
     */
    public function safe_fetch_row()
    {
        $m_record_set = $this->c_obj_stmt->fetch(PDO::FETCH_NUM);
        return $m_record_set;
    }

    /**Returns the array fo data currently held in this instance of MySQLWrapper
     * @return mixed
     */
    public function safe_fetch_array()
    {
        $m_arr_row = $this->c_obj_stmt->fetch(PDO::FETCH_ASSOC);
        return $m_arr_row;
    }

    /**Returns the ID of the last element inserted into the database
     * @return mixed
     */
    public function last_inserted_ID()
    {
        $m_sql_query = 'SELECT LAST_INSERT_ID()';

        $this->safe_query($m_sql_query);
        $m_arr_last_inserted_id = $this->safe_fetch_array();
        $m_last_inserted_id = $m_arr_last_inserted_id['LAST_INSERT_ID()'];
        return $m_last_inserted_id;
    }
}