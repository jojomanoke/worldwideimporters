<?php


namespace Classes;


use Classes\Query\Query;

class Auth
{
    public static function user(): Auth
    {
        if(!isset($_SESSION['userSession'])) {
            return new self();
        }
        return self::convertToAuthObject(Query::get('users')->where('UserID', $_SESSION['userSession'][2])->first());
    }
    
    public static function id(): int
    {
        if(!self::user()) {
            return 0;
        }
        
        return (self::user())->UserID;
    }
    
    /**
     * recast stdClass object to an object of a type
     *
     * @param mixed $object
     * @return mixed new, typed object
     * @throws \InvalidArgumentException
     */
    private static function convertToAuthObject($object)
    {
        $newCollection = new self();
        
        foreach($object as $property => &$value) {
            $newCollection->$property = &$value;
            unset($object->$property);
        }
        unset($value);
        return $newCollection;
    }
}