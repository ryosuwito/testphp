# Task Manager Application

This is a simple task management application built with PHP 8.1.6, MySQL 8.0.31, and Apache.

## Server Setup

1. Download and install XAMPP for the easiest development setup. You can download it from [here](https://www.apachefriends.org/download.html).
2. Once XAMPP is installed, start Apache and MySQL services.

## Database Setup

1. Create a MySQL database named "task_manager".
2. Import the SQL file named `dump.sql` located in the repository into the "task_manager" database. This can be done using phpMyAdmin or MySQL Workbench.

## Application Setup

1. The application consists of two main files: `index.php` and `config.php`.
2. `index.php` is the entry point of the application, it includes the following functionality:
   - Display a list of existing tasks (title and status) from the "tasks" table.
   - Provide a form to add a new task with title and description fields.
   - Allow updating the status of each task (e.g., changing from "Pending" to "In Progress" or "Completed").
   - Provide a search functionality to filter tasks by title and/or status.
3. `config.php` is used to store database connection details (e.g., hostname, username, password, database name). It is included in `index.php`.

## API Documentation

API endpoints and documentation are included in the Postman collection located [here](https://documenter.getpostman.com/view/19805337/2s9YC8uVvF)

## Testing the Application

1. Navigate to the application directory in your local server (e.g., `http://localhost/tasks`).
2. You should see a blank list of tasks fetched from the "tasks" table in the "task_manager" database.
3. Use the form to add new tasks.
4. You can also update the status of each task and use the search functionality to filter tasks.