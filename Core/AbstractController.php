<?php
    namespace Core;

    use \Config\DB;
    use \Delight\Auth\Auth;

    class AbstractController 
    {
        /**
         * Vars for template
         * @var array
         */
        private $params;

        /**
         * @var Auth
         */
        private $auth;

        public function __construct()
        {
            $this->params = [];
            $db = new DB();
            $this->auth = new Auth($db->getDb());
        }

        public function render($template, $params)
        {
            $this->params = array_merge($this->params, $params);
            extract($this->params);
            $USER = $this->auth;
            ob_start();
            require("../Views/" . $template);
            $content = ob_get_clean();
            require("../Views/base.php");
        }
    }
?>