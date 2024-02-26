<?php


class ConnData
{
    private static $instance = null;

    public static function shared()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function __clone() {}
    private function __construct() {}

    public function host(){
        return "127.0.0.1";
    }
    public function user(){
        return "u2371575_default";
    }
    public function password(){
        return "Xj03Di7ILpPNH37u";
    }
    public function database(){
        return "u2371575_default";
    }
    public function botToken(){
        return '1480500018:AAGyEekow7WFuNqtNrx4VyEShwpu_Fjjmx8';
    }



}
?>