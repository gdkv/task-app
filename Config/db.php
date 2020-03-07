<?php
    namespace Config;
    use \PDO;

    class DB 
    {
        /**
         * @var $db current database connection
         */
        private $db;

        public function __construct()
        {
            $this->db = null;
        }

        /**
         * Get current database connection
         * @return $db
         */ 
        public function getDb()
        {
            // if (is_null($this->db)){
            $this->db = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=task_db', 'task_user', 'task123pass');
            // }
            return $this->db;
        }
    }
?>