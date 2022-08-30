<?php
function is_set_and_not_empty($field){
    if(isset($field) && !empty($field)) return true;
    return false;
}

function connect_to_database($db_controller){
    try{
    $db_controller->connect_to_db();
    }catch(mysqli_sql_exception $e){
        $GLOBALS['error_message'] = "Unable to login due to database issues. Please try again or check back later.";
        throw new mysqli_sql_exception;
    }
}

function check_if_result_empty($result){
    if(!is_set_and_not_empty($result)){
        $GLOBALS['error_message'] = "Please enter a valid email and password.";
        throw new mysqli_sql_exception;
    }
}

function try_to_close_database_connection($db_controller){
    try{
        $db_controller->close_connection();
    }catch(mysqli_sql_exception $e){
    }
}

function query_specified_value($db_controller, $column, $table, $where_column, $where_column_value){
    $result = "";
    try{
        $result = $db_controller->fetch_a_row("SELECT $column FROM $table WHERE $where_column = '$where_column_value'");
        if(is_set_and_not_empty($result)) $result = $result[$column];
    }catch(mysqli_sql_exception $e){
        throw new mysqli_sql_exception;
    }

    return $result;
}

function db_single_query_handling($db_controller, $query_fields){
    $result= "";
     try{
        connect_to_database($db_controller);
        $result = query_specified_value($db_controller, $query_fields['column'], $query_fields['table'], $query_fields['where_column'], $query_fields['where_column_value']);
        check_if_result_empty($result);
        $db_controller->close_connection();
    }catch(mysqli_sql_exception $e){
        try_to_close_database_connection($db_controller);
    }finally{
         return $result;
    }
}
?>