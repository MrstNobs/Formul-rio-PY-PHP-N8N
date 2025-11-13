<?php 
    class Conn{
        private static $instance;

        public static function getConn(){
            if(!isset(self::$instance)){
                try{
                    self::$instance = new PDO("mysql:host=localhost; dbname=formauto; charset=utf8", "root", "");
                    self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    die("Erro ao conectar: ". $e->getMessage());
                }
            }
            return self::$instance;
        }
        public static function closeConn(){
            self::$instance = null;
        }
    }
?>