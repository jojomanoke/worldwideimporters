<?php

namespace Classes\Query\Traits;

use Classes\Database;
use Classes\Query\Query;

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
    public static function get($table, $columns = '*'): Query
    {
        /**
         * Is the same as: new MySQLi($host, $username, $password, $databaseName, $port);
         */
        if(str_contains($table, ' ')) {
            $query = $table;
        } else {
            $query = "SELECT $columns FROM $table";
        }
        
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
    public static function in($table, $column, $keys): Query
    {
        /**
         * Is the same as: new MySQLi($host, $username, $password, $databaseName, $port);
         */
        $keys = array_merge(array_filter($keys));
        $query = "SELECT * FROM $table WHERE $column IN (";
        foreach($keys as $index => $key) {
            if($key !== 0) {
                if(is_array($key)){
                    $key = implode(', ', $key);
                }
                $query .= is_string($key) ? "'$key'" : $key;
                if($index !== (count($keys) - 1)) {
                    $query .= ', ';
                }
            }
        }
        $query .= ')';
        return self::getResults($query);
    }
    
    
    protected static function getResults(string $query, $className = 'Classes\Query\Query')
    {
        $conn = Database::getConnection();
        /**
         * $stmt is the same as $statement
         */
        if($stmt = $conn->prepare($query)) {
            $stmt->execute();
            $results = $stmt->get_result();
            
            if($results->num_rows > 0) {
                /**
                 * Creates an empty object.
                 * Will be used in the while loop and will be populated with database records
                 */
                $class = (new $className())->className;
                $totalResults = new $class();
                /**
                 * Is used to create a key for every database record
                 * e.g. $array[0] = $databaseRecord;
                 */
                $index = 0;
                /**
                 * Simple while loop to loop over all database records
                 */
                while($databaseRecord = $results->fetch_object()) {
                    
                    /**
                     * Adds the record to the empty object
                     */
                    $totalResults->$index = self::convertToClassObject($className, $databaseRecord);
                    
                    $index++;
                }
                $results->free_result();
                return $totalResults;
            }
        }
        return new $className();
    }
    
    
    /**
     * Returns all database records where a columns equals value
     *
     * @param string $column WHERE column = ...
     * @param mixed $value WHERE ... = value
     * @return Query
     */
    public function where($column, $value): Query
    {
        /**
         * Creates an empty object which will be populated in the foreach loop
         */
        $class = $this->className;
        $results = new $class();
        $resultCount = 0;
        /**
         * This loop will loop over each database record fetched by: Query::get('tableName');
         */
        if($this->count() !== null) {
            if(str_contains($column, ',')) {
                foreach($this as $key => $object) {
                    foreach(explode(',', $column) as $col) {
    
                        if(is_array($value)) {
                            if(in_array($object->$col, $value, false)) {
                                $results->$resultCount = $object;
                                $resultCount++;
                                break;
                            }
                        } else {
                            if($object->$col == $value) {
                                $results->$resultCount = $object;
                                $resultCount++;
                                break;
                            }
                        }
                    }
                }
            } elseif(is_array($value) || str_contains($value, ',')) {
                if(is_string($value)) {
                    $value = explode(',', $value);
                }
                foreach($this as $key => $object) {
                    if(str_contains($key, 'className')){
                        continue;
                    }
                    /**
                     * $column is the name of the column that needs to be searched
                     * This checks if the column value is the same as the value to find
                     */
                    if(in_array($object->$column, $value, false)) {
                        /**
                         * Once it finds something, the loop will add the data object to the empty object earlier
                         */
                        $results->$resultCount = $object;
                        $resultCount++;
                    }
                }
            } else {
                foreach($this as $key => $object) {
                    /**
                     * $column is the name of the column that needs to be searched
                     * This checks if the column value is the same as the value to find
                     */
                    if(str_contains($key, 'className')){
                        continue;
                    }
                    if($object->$column == $value) {
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
    public function like(array $columns, string $value): Query
    {
        $class = $this->className;
        $returnCollection = new $class();
        $resultsCount = 0;
        foreach($this as $index => $item) {
            if($index === 'className'){
                continue;
            }
            foreach($columns as $key => $column) {
                if(stripos($item->{$column}, $value) !== false) {
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
    
    public function limit(int $first, int $second = 0)
    {
        $class = $this->className;
        $returnCollection = new $class();
        $resultsCount = 0;
        foreach($this as $key => $item) {
            if($key === 'className') {
                continue;
            }
            if($second && ($key >= $first && $resultsCount < $second)) {
                $returnCollection->{$resultsCount} = $item;
                $resultsCount++;
            } elseif(!$second && ($key < $first)) {
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
    public function take($amount): Query
    {
        $class = $this->className;
        $returnCollection = new $class();
        for($i = 0; $i < $amount; $i++) {
            $returnCollection->$i = $this->$i;
        }
        
        return $returnCollection;
    }
    
    public function sort($key, $desc = false)
    {
        self::$key = $key;
        self::$desc = $desc;
        $array = array_merge(array_filter($this->toArray()));
        
        if(array_key_exists(0, $array) && is_array($array[0])){
           usort($array, array(Query::class, 'uSortFunction'));
        } else {
            if($desc){
                rsort($array);
            } else {
                sort($array);
            }
        }
        foreach($array as $loopKey => $item) {
            $array[$loopKey] = self::convertToClassObject($this->className, $item);
        }
        return $this->className::convertToQueryObject($array);
    }
    
    private static function uSortFunction($a, $b)
    {
        $key = self::$key;
        if($a[$key] === $b[$key]) {
            return 0;
        }
        
        if(self::$desc) {
            return ($a[$key] < $b[$key]) ? 1 : -1;
        }
        return ($a[$key] < $b[$key]) ? -1 : 1;
    }
    
    /**
     * Returns the first result of a data collection
     * @return Query
     */
    public function first(): Query
    {
        return $this->{0};
    }
    
    public function column($column) {
        $class = $this->className;
        $returnCollection = new $class();
        $index = 0;
        foreach($this as $item) {
            foreach($item as $col => $value){
                if($col === $column){
                    $returnCollection->{$index} = self::convertToClassObject($this->className, [$col => $value]);
                    $index++;
                }
            }
        }
        return $returnCollection;
    }
}