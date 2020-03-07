<?php
    require("../Models/Tasks.php");
    require("../Models/User.php");
    use \Model\Tasks;
    use \Model\User;
    use \Core\AbstractController;

    class TasksController extends AbstractController
    {
        public function index(string $params="")
        {
            // default criteria
            $criteria = ['page' => 1, 'recNum' => 3, 'order' => 'edit_at', 'sort' => 'DESC', ];
            if ($params) {
                parse_str(trim($params, "?"), $output);
                // set up pagination and sort if required
                if ($output['page'])
                    $criteria['page'] = $output['page'];
                if ($output['order'])
                    $criteria['order'] = $output['order'];
                if ($output['sort'])
                    $criteria['sort'] = $output['sort'];
            }
            $tasks = new Tasks();
            $result = $tasks->findBy($criteria);
            $this->render("Tasks/list.php", [
                'tasks' => $result['tasks'],
                'pages' => $result['pages'],
                'current' => $criteria['page'],
                'order' => ($output['order'] ? : ''),
                'sort' => ($output['sort'] ? : ''),
            ]);
        }

        public function add()
        {
            // check if form is post
            if (isset($_POST["username"])){
                $errors = "";
                // server validation if JS is not working
                if (empty($_POST["username"]) || empty($_POST["text"])) {
                    $errors .= "Username or task description can not be empty! ";
                }
                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                    $errors .= "Email is not valid! ";
                }

                if (empty($errors)){
                    // validation is OK, create new task
                    $task = new Tasks();
                    $persist = [
                        'username' => $_POST['username'],
                        'email' => $_POST['email'],
                        'text' => htmlspecialchars($_POST['text']),
                    ];
                    if ($task->add($persist)) {
                        $this->msg->info('Task is created 🤟');
                        header("Location: /tasks/index");
                    } 
                }
            }

            $this->render("Tasks/add.php", ['errors' => $errors,]);
        }

        public function edit($id)
        {
            // Voter - only login user can edit
            if ($this->auth->isLoggedIn()) {
                $task = new Tasks();
                $result = $task->findById($id);

                // check if form is post
                if (isset($_POST["username"])){
                    $errors = "";
                    // server validation if JS is not working
                    if (empty($_POST["username"]) || empty($_POST["text"])) {
                        $errors .= "Username or task description can not be empty! ";
                    }
                    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                        $errors .= "Email is not valid! ";
                    }

                    if (empty($errors)){
                        $persist = [
                            'username' => $_POST['username'],
                            'email' => $_POST['email'],
                            'text' => htmlspecialchars($_POST['text']),
                            'is_closed' => (isset($_POST['is_closed'])?'true':'false'),
                            'is_changed' => strcmp($result['text'], $_POST['text']),
                        ];
                        if ($task->edit($id, $persist)) {
                            $this->msg->warning('OK! task edited 🔥');
                            header("Location: /tasks/index");
                        } 
                    }
                }

                $this->render("Tasks/edit.php", ['task' => $result, 'errors' => $errors, ]);
            } else {
                http_response_code(403);
            }
        }

        public function delete($id)
        {
            if ($this->auth->isLoggedIn()) {
                $task = new Tasks();
                if ($task->delete($id)) {
                    $this->msg->error('OMG! task was deleted 😭');
                    header("Location: /tasks/index");
                }
            } else {
                http_response_code(403);
            }
        }
    }
?>