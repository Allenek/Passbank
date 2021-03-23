<?php
  namespace Handles;
  use \Config\Database\MySQL as MySQLParameters;
  use \PDO;

  class MySQL extends Handle {
    protected function __clone() {}
    protected function __construct() {
       try { 
        $this->pdo = new PDO(
                    MySQLParameters::$type.
                    ':host='.MySQLParameters::$hostname.
                    ';dbname='.MySQLParameters::$database.
                    ';port='.MySQLParameters::$port,
                    MySQLParameters::$user, MySQLParameters::$password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("set names utf8");
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      } catch(\PDOException $e) {
        $this->pdo = null;
        throw new \Exceptions\DatabaseConnection($e);
      }
    }
}
