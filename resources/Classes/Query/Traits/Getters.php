<?php

namespace Classes\Query\Traits;

use Classes\Query\Query;
use Classes\Database;

trait Getters
{
    private static $key;
    private static $desc;
    
    /**
     * Creates a collection from all data that has been fetched from the database
     *
     * @param $table
     * @param string $columns
     * @return \Classes\Query\Query
     * @author sylvano verkuyl<sylvanoverkuyl@hotmail.com>
     */
    public static function get( $table, $columns = '*' ): Query
    {
        /**
         * Is the same as: new MySQLi($host, $username, $password, $databaseName, $port);
         */
        $query = "SELECT $columns FROM $table";
        return self::getResults($query);
    }
    
    /**
     * Creates a collection from all data that has been fetched from the database
     *
     * @param $table
     * @param $column
     * @param $keys
     * @return \Classes\Query\Query
     * @author sylvano verkuyl<sylvanoverkuyl@hotmail.com>
     */
    public static function in( $table, $column, $keys ): Query
    {
        /**
         * Is the same as: new MySQLi($host, $username, $password, $databaseName, $port);
         */
        $query = "SELECT * FROM $table WHERE $column IN (";
        
        foreach ( $keys as $index => $key ) {
            $query .= is_string($key) ? "'$key'" : $key;
            if ( $index !== ( count($keys) - 1 ) ) {
                $query .= ', ';
            } else {
                $query .= ')';
            }
        }
        
        return self::getResults($query);
    }
    
    
    private static function getResults( string $query ): Query
    {
        $conn = Database::getConnection();
        /**
         * $stmt is the same as $statement
         */
        if ( $stmt = $conn->prepare($query) ) {
            $stmt->execute();
            $results = $stmt->get_result();
            
            if ( $results->num_rows > 0 ) {
                /**
                 * Creates an empty object.
                 * Will be used in the while loop and will be populated with database records
                 */
                $totalResults = new Query();
                
                /**
                 * Is used to create a key for every database record
                 * e.g. $array[0] = $databaseRecord;
                 */
                $index = 0;
                
                /**
                 * Simple while loop to loop over all database records
                 */
                while ( $databaseRecord = $results->fetch_object() ) {
                    
                    /**
                     * Adds the record to the empty object
                     */
                    $totalResults->$index = self::convertToQueryObject($databaseRecord);
                    $index++;
                }
                $results->free_result();
                return $totalResults;
            }
        }
        return new Query();
    }
    
    
    /**
     * Returns all database records where a columns equals value
     *
     * @param string $column WHERE column = ...
     * @param mixed $value WHERE ... = value
     * @return Query
     */
    public function where( $column, $value ): Query
    {
        /**
         * Creates an empty object which will be populated in the foreach loop
         */
        $results = new Query();
        $resultCount = 0;
        /**
         * This loop will loop over each database record fetched by: Query::get('tableName');
         */
        if ( $this->count() !== null ) {
            if ( str_contains($column, ',') ) {
                foreach ( $this as $key => $object ) {
                    foreach ( explode(',', $column) as $col ) {
                        
                        if ( is_array($value) ) {
                            if ( in_array($object->$col, $value, false) ) {
                                $results->$resultCount = $object;
                                $resultCount++;
                                break;
                            }
                        } else {
                            if ( $object->$col == $value ) {
                                $results->$resultCount = $object;
                                $resultCount++;
                                break;
                            }
                        }
                    }
                }
            } elseif ( is_array($value) || str_contains($value, ',') ) {
                if ( is_string($value) ) {
                    $value = explode(',', $value);
                }
                foreach ( $this as $key => $object ) {
                    /**
                     * $column is the name of the column that needs to be searched
                     * This checks if the column value is the same as the value to find
                     */
                    if ( in_array($object->$column, $value, false) ) {
                        /**
                         * Once it finds something, the loop will add the data object to the empty object earlier
                         */
                        $results->$resultCount = $object;
                        $resultCount++;
                    }
                }
            } else {
                foreach ( $this as $key => $object ) {
                    /**
                     * $column is the name of the column that needs to be searched
                     * This checks if the column value is the same as the value to find
                     */
                    if ( $object->$column == $value ) {
                        /**
                         * Once it finds something, the loop will add the data object to the empty object earlier
                         */
                        $results->$resultCount = $object;
                        $resultCount++;
                    }
                }
            }
            
            
        }
        return $results;
    }
    
    /**
     * same as SELECT ... FROM ... WHERE ... LIKE '%...%'
     *
     * @param array $columns
     * @param string $value
     * @return \Classes\Query\Query
     */
    public function like( array $columns, string $value ): Query
    {
        $returnCollection = new Query();
        $resultsCount = 0;
        foreach ( $this as $item ) {
            foreach ( $columns as $key => $column ) {
                if ( stripos($item->{$column}, $value) !== false ) {
                    $returnCollection->{$resultsCount} = $item;
                    $resultsCount++;
                    break;
                }
//                if(in_array($item->{$column}, $values, false)){
//                    $returnCollection->{$resultsCount} = $item;
//                }
            }
        }
        
        return $returnCollection;
    }
    
    public function limit( int $first, int $second = 0 )
    {
        $returnCollection = new Query();
        $resultsCount = 0;
        foreach ( $this as $key => $item ) {
            if ( $second && ( $key >= $first && $resultsCount < $second ) ) {
                $returnCollection->{$resultsCount} = $item;
                $resultsCount++;
            } elseif ( !$second && ( $key < $first ) ) {
                $returnCollection->{$resultsCount} = $item;
                $resultsCount++;
            }
        }
        
        return $returnCollection;
    }
    
    /**
     * Limit a collection to a certain amount of objects
     * @param $amount
     * @return Query
     */
    public function take( $amount ): Query
    {
        $returnCollection = new Query();
        for ( $i = 0; $i < $amount; $i++ ) {
            $returnCollection->$i = $this->$i;
        }
        
        return $returnCollection;
    }
    
    public function sort($key, $desc = false){
        self::$key = $key;
        self::$desc = $desc;
        $array = $this->toArray();
        usort($array, array(Query::class, 'uSortFunction'));
        return Query::convertArrayToQueryObject($array);
    }
    
    private static function uSortFunction ($a, $b){
        $key = self::$key;
        if($a->{$key} === $b->{$key}) {
            return 0;
        }
        
        if(self::$desc){
            return ($a->{$key} < $b->{$key}) ? 1 : -1;
        }
        return ($a->{$key} < $b->{$key}) ? -1 : 1;
    }
    
    /**
     * Returns the first result of a data collection
     * @return Query
     */
    public function first(): Query
    {
        return $this->{0};
    }
}