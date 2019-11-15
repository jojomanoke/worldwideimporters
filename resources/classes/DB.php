<?php


class DB
{
    /**
     * @var $db DB Current class
     */
    private static $db;
    
    /**
     * @var \MySQLi Connection
     */
    private $connection;
    
    private function __construct()
    {
        $this->connection = new MySQLi(
            env('DATABASE_HOST', '127.0.0.1'),
            env('DATABASE_USER', 'root'),
            env('DATABASE_PASSWORD', ''),
            env('DATABASE_NAME', 'wideworldimporters')
        );
    }
    
    public function __destruct()
    {
        $this->connection->close();
    }
    
    public static function conn(): \MySQLi
    {
        if ( self::$db == null ) {
            self::$db = new DB();
        }
        return self::$db->connection;
    }
}