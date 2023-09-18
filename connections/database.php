<?php
    // singleton for database connection
    class Database {
        private static $instance = null;
        private $pdo;

        private function __construct() {
            $config = include 'config.php';
            $connection = $config['connections']['mysql'];
            $this->pdo = new PDO(
                'mysql:host=' . $connection['host'] . ';dbname=' . $connection['database'] . ';charset=' . $connection['charset'],
                $connection['username'],
                $connection['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public static function getInstance() {
            if (!self::$instance) {
                self::$instance = new Database();
            }
            return self::$instance;
        }

        public function getPdo() {
            return $this->pdo;
        }
    }
?>