<?php
namespace Classes\Query\Traits;

use Classes\Query\Query;
use Classes\Database;

trait Setters
{
    /**
     * Inserts a new row in the database
     *
     * @param $into
     * @param null $columns
     * @param array $values
     * @return \Classes\Query\Query
     */
    public static function insert( $into, $columns = null, $values = [] ): Query
    {
        $query = "INSERT INTO $into ";
        if ( $columns !== null ) {
            if ( is_string($columns) ) {
                $query .= "($columns)";
            } elseif ( is_array($columns) ) {
                foreach ( $columns as $key => $column ) {
                    if ( (int)$key === 0 ) {
                        $query .= "($column, ";
                    } elseif ( (int)$key === ( count($columns) - 1 ) ) {
                        $query .= "$column)";
                    } else {
                        $query .= "$column, ";
                    }
                }
            }
        }
        if ( count($values) ) {
            $query .= ' VALUES (';
            foreach ( $values as $key => $value ) {
                if ( is_string($value) ) {
                    $query .= "'$value'";
                } else {
                    $query .= $value;
                }
                if ( $key !== count($values) - 1 ) {
                    $query .= ', ';
                }
            }
            $query .= ')';
        }
        $conn = Database::getConnection();
        if ( $conn->query($query) === true ) {
            return Query::get($into)->where('StockItemId', $conn->insert_id);
        }
        
        print( $conn->error );
        die();
    }
    
    /**
     * Updates a row from the database
     *
     * @param $table
     * @param $primaryKey
     * @param array $columnsAndValues
     * @return \Classes\Query\Query
     */
    public function update( $table, $primaryKey, $columnsAndValues = [] ): Query
    {
        $query = "UPDATE $table SET ";
        if ( !count($columnsAndValues) ) {
            print( 'U kunt geen lege waardes mee sturen' );
        }
        $loop = 0;
        foreach ( $columnsAndValues as $column => $value ) {
            $query .= "$column = $value";
            if ( $loop !== ( count($columnsAndValues) - 1 ) ) {
                $query .= ', ';
            }
        }
        
        $query .= " WHERE $primaryKey = {$this->$primaryKey}";
        $conn = Database::getConnection();
        if ( $conn->query($query) === true ) {
            return Query::get($table)->where($primaryKey, $this->$primaryKey)->first();
        }
        
        print $conn->error;
        die();
    }
}