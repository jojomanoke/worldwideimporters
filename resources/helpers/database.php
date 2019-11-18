<?php


if(!(function_exists('getResults'))){
    function getResults ($table, $columns = '*', $where = null, $extraOptions = null) {
        $conn = Database::getConnection();
        $query = "SELECT $columns FROM $table";
        if(isset($where)){
            $query .= " WHERE $where";
        }
        if(isset($extraOptions)){
            $query .= " $extraOptions";
        }
        
        $statement = $conn->prepare($query);
        $statement->execute();
        
        return $statement->get_result();
    }
}