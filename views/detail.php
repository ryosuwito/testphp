<?php
    require_once 'base.php';
    $task = $data['task'];

    $mainContent = null;

    if($task){
        $mainContent .= <<<HTML
        <h2>Task : {$task['title']} </h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
        HTML;
        $mainContent .= <<<HTML
        <tr>
            <td>{$task['title']}</td>
            <td>{$task['description']}</td>
            <td>{$task['status']}</td>
            <td>{$task['created_at']}</td>
            <td>{$task['updated_at']}</td>
        </tr>
        HTML;
        $mainContent .= <<<HTML
            </tbody>
        </table>
        HTML;
    } else {
        $mainContent .= <<<HTML
            <p>No Task Found</p>
        HTML;
    }

    echo render([
        'title' => 'Detail Task',
        'main-content' => $mainContent
    ]);
?>