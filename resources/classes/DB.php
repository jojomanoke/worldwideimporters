<?php


class DB
{
    private static $db;
    private $connection;
    
    private function __construct()
    {
        $this->connection = new MySQLi(
            'localhost',
            trim(env('DATABASE_USER')),
            trim(env('DATABASE_PASSWORD', '')),
            trim(env('DATABASE_NAME'))
        );
    }
    
    public static function conn()
    {
        if ( self::$db == null ) {
            self::$db = new DB();
        }
        return self::$db->connection;
    }
}