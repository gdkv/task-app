<?php
    class Router
    {
        /**
         * Server request URI
         * @var string
         */
        public $url;

        private $request;

        public function __construct()
        {
            $this->url = $_SERVER["REQUEST_URI"];
        }

        public function forward()
        {
            $this->detect($this->url);
            $controller = $this->loadController();

            call_user_func_array([$controller, $this->request->action], $this->request->params);
        }

        private function detect()
        {
            $this->url = trim($this->url);

            if (empty($this->url) || $this->url == "/"){
                // start page request
                // set up default values
                $this->request->controller = "tasks";
                $this->request->action = "index";
                $this->request->params = [];
            } else {
                // explode url by slash sign
                $explode_url = explode('/', $this->url);
                $explode_url = array_slice($explode_url, 1);

                $this->request->controller = $explode_url[0];
                $this->request->action = $explode_url[1];

                // get all elements from 2 to end, 
                // and put it to params
                $this->request->params = array_slice($explode_url, 2);
            }

        }


        private function loadController()
        {
            // ucfirst - make first letter to uppercase because all controllers
            // filename starts from capital letter
            $controller_name = ucfirst($this->request->controller) . "Controller";
            $controller_path = "Controllers/{$controller_name}.php";
            // require controller file
            require($controller_path);
            // init controller and return it
            $controller = new $controller_name();
            return $controller;
        }
    }
?>