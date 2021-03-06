<?php 

class BDD {
    
    private static $pdo = NULL;

    public static function init(){

        // Identifiants pour se connecter à la base de donnée (dans ce cas ma base de données personnelle)
        $hostname = 'localhost';
        $database_name = 'gt2i';
        $login = 'host';
        $password = '123456789';
        
        try{
            self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name",$login,$password,
                                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getPDO(){
        if(is_null(self::$pdo)){
            self::init();
        }
        return self::$pdo;
    }
}
?>