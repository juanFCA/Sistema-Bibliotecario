<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 2019-03-16
 * Time: 15:25
 */

require_once "configDB.php";

class conexao
{

    private static $pdo;

    private function __construct() {
        self::getInstance();
    }

    public static function getInstance() {
        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO(DRIVER.":host=" . HOSTNAME . "; dbname=" . DBNAME . "; charset=" . CHARSET . ";", USER, PASS);
            } catch (PDOException $e) {
                print "Erro: " . $e->getMessage();
            }
        }
        return self::$pdo;
    }

}