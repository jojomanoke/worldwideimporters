<?php
namespace Classes;
class Database
{
    
    private static $db;
    private $connection;
    
    private function __construct()
    {
        $this->connection = new \MySQLi(
            'localhost',
            env('DATABASE_USER'),
            env('DATABASE_PASSWORD'),
            env('DATABASE_NAME')
        );
    }
    
    public function __destruct()
    {
        $this->connection->close();
    }
    
    public static function getConnection(): \MySQLi
    {
        if ( self::$db == null ) {
            self::$db = new Database();
        }
        return self::$db->connection;
    }
}