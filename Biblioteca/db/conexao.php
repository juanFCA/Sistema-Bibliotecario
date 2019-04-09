<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 18/03/19
 * Time: 14:42
 */

require_once "configDB.php";

class Conexao
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
?>