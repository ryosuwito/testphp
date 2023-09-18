<?php
    include 'repositories/taskRepository.php';
    // TaskController.php -> get using 'repository' pattern to get all tasks from database

    class TaskController {
        private $taskRepository = null;

        public function __construct() {
            $this->taskRepository = new TaskRepository();
        }

        private function render($view, $data = []) {
            // render view with data
            include 'views/' . $view . '.php';
        }

        public function list() {
            // Check if request has 'search' and 'filter' query string parameters with error handling
            $search = isset($_GET['search']) ? $_GET['search'] : null;
            $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        
            if ($search && $filter) {
                // Search and filter tasks based on status and keyword
                $tasks = $this->taskRepository->searchAndFilter($search, $filter);
            } elseif ($search) {
                // Search task by title or description
                $tasks = $this->taskRepository->search($search);
            } elseif ($filter) {
                // Filter task by status
                $tasks = $this->taskRepository->filterByStatus($filter);
            } else {
                // Get all tasks from the database
                $tasks = $this->taskRepository->getAll();
            }
        
            // Render view with data
            return $this->render('list', ['tasks' => $tasks]);
        }
        
        public function add() {
            // get title and description from post request with error handling
            $title = isset($_POST['title']) ? $_POST['title'] : null;
            $description = isset($_POST['description']) ? $_POST['description'] : null;
            if (!$title || !$description) {
                // throw bad request error
                http_response_code(400);
                return;
            }
            // add new task to database
            $id = $this->taskRepository->add($title, $description);

            return $this->detail($id);
        }

        public function detail($id) {
            if (!$id || !is_numeric($id)) {
                // throw bad request error
                http_response_code(400);
                return;
            }
            // get task by id from database
            $task = $this->taskRepository->getById($id);
            // render view with data
            return $this->render('detail', ['task' => $task]);
        }

        public function update($id) {
            if (!$id || !is_numeric($id)) {
                // throw bad request error
                http_response_code(400);
                return;
            }
            // get status from post request with error handling
            $status = isset($_POST['status']) ? $_POST['status'] : null;
            if (!$status) {
                // throw bad request error
                http_response_code(400);
                return;
            }
            // check if status match with task model enum
            $task = new Task();
            if (!$task->checkStatus($status)) {
                // throw bad request error
                http_response_code(400);
                return;
            }
            // update task status in database with error handling
            $this->taskRepository->update($id, $status);

            return $this->detail($id);
        }
    }

?>