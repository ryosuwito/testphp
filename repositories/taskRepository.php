<?php
    include 'connections/database.php';
    include 'models/task.php';
    class TaskRepository {
        // get instance of database connection and pdo object from singleton
        private $db = null;
        private $pdo = null;

        public function __construct() {
            $this->db = Database::getInstance();
            $this->pdo = $this->db->getPdo();
        }

        public function getAll() {
            // get all tasks from database with error handling
            try {
                $stmt = $this->pdo->prepare('SELECT * FROM tasks');
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function add($title, $description) {
            // sanitize input, insert into database, and return id of new task with error handling
            try {
                $stmt = $this->pdo->prepare('INSERT INTO tasks (title, description, status) VALUES (:title, :description, :status)');
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'status' => 'Pending'
                ]);
                return $this->pdo->lastInsertId();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function update($id, $status) {
            // check if status match with task model enum
            $task = new Task();
            if (!$task->checkStatus($status)) {
                // throw bad request error
                http_response_code(400);
            }
            // update task status in database with error handling
            try {
                $stmt = $this->pdo->prepare('UPDATE tasks SET status = :status WHERE id = :id');
                $stmt->execute([
                    'status' => $status,
                    'id' => $id
                ]);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        // search task by id
        public function getById($id) {
            $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE id = :id');
            $stmt->execute([
                'id' => $id
            ]);
            // if task not found, throw not found error
            if ($stmt->rowCount() == 0) {
                http_response_code(404);
                return;
            }
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // search task by title or description
        public function search($keyword) {
            $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE title LIKE :keyword OR description LIKE :keyword');
            $stmt->execute([
                'keyword' => '%' . $keyword . '%'
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function searchAndFilter($keyword, $status) {
            $sql = 'SELECT * FROM tasks WHERE (title LIKE :keyword OR description LIKE :keyword)';
            $params = ['keyword' => '%' . $keyword . '%'];
        
            if ($status) {
                $sql .= ' AND status = :status';
                $params['status'] = $status;
            }
        
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function filterByStatus($status) {
            if($status != ""){
                $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE status = :status');
                $stmt->execute([
                    'status' => $status
                ]);
            } else {
                $stmt = $this->pdo->prepare('SELECT * FROM tasks');
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>