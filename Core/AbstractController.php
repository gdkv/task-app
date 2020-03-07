<?php
    namespace Core;

    use \Config\DB;
    use \Delight\Auth\Auth;
    use \Plasticbrain\FlashMessages\FlashMessages;

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
        public $auth;

        /**
         * @var FlashMessages
         */
        public $msg;

        public function __construct()
        {
            $this->params = [];
            $db = new DB();
            $this->auth = new Auth($db->getDb());
            $this->msg = new FlashMessages();
        }

        public function render($template, $params)
        {
            $this->params = array_merge($this->params, $params);
            extract($this->params);
            $USER = $this->auth;
            $flashbag = $this->msg;
            ob_start();
            require("../Views/" . $template);
            $content = ob_get_clean();
            require("../Views/base.php");
        }
    }
?>