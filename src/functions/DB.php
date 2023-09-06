<?php
/*
class DB
{
    private static $instace = null;

    public function __construct()
    {

    }

    public static function getInstance(string $host = DB_HOST, string $database = DB_DATABASE, string $username = DB_USERNAME, string $password = DB_PASSWORD)
    {
        if(is_null(self::$instace)){
            self::$instace = new mysqli($host, $username, $password, $database);

            self::$instace->set_charset('utf8');
        }

        return self::$instace;
    }
}
*/
function db(string $host = DB_HOST, string $database = DB_DATABASE, string $username = DB_USERNAME, string $password = DB_PASSWORD)
{
    $conexao = new mysqli($host, $username, $password, $database);
    
    return $conexao;

}

?>