<?php
namespace Classes\Query\Traits;

use Classes\Query\Query;
use Classes\Database;

trait Getters
{
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
        $conn = Database::getConnection();
        $query = "SELECT $columns FROM $table";
        /**
         * $stmt is the same as $statement
         */
        $stmt = $conn->prepare($query);
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
        return new Query();
    }
    
    /**
     * Returns all database records where a columns equals value
     *
     * @param string $column WHERE column = ...
     * @param string $value WHERE ... = value
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
        return $results;
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
    
    /**
     * Returns the first result of a data collection
     * @return Query
     */
    public function first(): Query
    {
        return $this->{0};
    }
}