<?php
    include 'config.php';
    include 'controllers/taskController.php';

    // simple routing based on url, request method, and controller
    $url = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    $controller = null;
    if ($url == '/') {
        header('Location: /tasks');
    }
    if ($url == '/tasks' && $method == 'POST') {
        return (new TaskController())->add();
    }
    // show detail task
    else if (preg_match('/\/tasks\/\d+/', $url) && $method == 'GET') {
        $controller = new TaskController();
        $id = preg_replace('/\/tasks\//', '', $url);
        return (new TaskController())->detail($id);
    }
    // update single task
    else if (preg_match('/\/tasks\/\d+/', $url) && $method == 'POST') {
        $controller = new TaskController();
        // get and pass id to update function
        $id = preg_replace('/\/tasks\//', '', $url);
        return (new TaskController())->update($id);
    } else if (preg_match('/\/tasks(\?.*)?$/', $url) && $method == 'GET') {
        // task controller with function list
        return (new TaskController())->list();
    } else {
        echo $url;
        echo $method;
        echo '404 Not Found';
        exit;
    }

    // test list task
    $list = new TaskController();
    echo $list->list();
?>