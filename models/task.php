<?php
    class Task {
        private $status = ['Pending', 'In Progress', 'Completed'];

        public function checkStatus($status) {
            return in_array($status, $this->status);
        }
    }
?>