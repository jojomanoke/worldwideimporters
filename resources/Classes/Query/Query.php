<?php

namespace Classes\Query;

use Classes\Query\Traits\Getters;
use Classes\Query\Traits\Setters;

class Query
{
    use Getters, Setters;
    
    /**
     * Moves the data objects to an array
     * @return array
     */
    public function toArray(): array
    {
        $returnArray = [];
        foreach($this as $key => $object) {
            if(count((array)$object) <= 1) {
                $returnArray[$key] = array_values((array)$object)[0];
            } else {
                $returnArray[$key] = (array)$object;
            }
        }
        return $returnArray;
    }
    
    /**
     * Returns the count of a collection
     * @return int
     */
    public function count(): int
    {
        return count($this->toArray());
    }
    
    /**
     * recast stdClass object to an object of a type
     *
     * @param mixed $object
     * @return mixed new, typed object
     * @throws \InvalidArgumentException
     */
    private static function convertToQueryObject($object)
    {
        $newCollection = new self();
        foreach($object as $property => &$value) {
            $newCollection->$property = &$value;
            unset($object->$property);
        }
        unset($value);
        return $newCollection;
    }
    
    /**
     * @param $array
     * @return mixed
     */
    private static function convertArrayToQueryObject($array)
    {
        return self::convertToQueryObject((object)$array);
    }
    
}