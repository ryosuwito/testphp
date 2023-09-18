<?php
    require_once 'base.php';
    $tasks = $data['tasks'];

    $mainContent = null;

    if($tasks && count($tasks) >0){
        $mainContent .= <<<HTML
        <div id="errContainer"></div>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
        HTML;
        foreach($tasks as $task){
            $mainContent .= <<<HTML
            <tr>
                <td><a href="/tasks/{$task['id']}">{$task['title']}</a></td>
                <td>{$task['status']}</td>
                <td>
                    <select class="status-selector" data-task-id="{$task['id']}">
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                    </select>
                </td>
                </td>
            </tr>
            HTML;
        }
        $mainContent .= <<<HTML
            </tbody>
        </table>
        <script>
            document.querySelectorAll('.status-selector').forEach(function(selector) {
                selector.addEventListener('change', function(e) {
                    var taskId = e.target.getAttribute('data-task-id');
                    var status = e.target.value;
                    if(status == ""){
                        document.getElementById("errContainer").innerHTML = ""; 
                        return
                    }
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '/tasks/' + taskId, true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send('status=' + encodeURIComponent(status));
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == XMLHttpRequest.DONE) {
                            if(xhr.status!=200){
                                document.getElementById("errContainer").innerHTML = "XMLHttprequest error: " + xhr.statusText; 
                            } else {
                                window.location = xhr.responseURL
                            }
                        }
                    }
                });
            });
        </script>
        HTML;
    } else {
        $mainContent .= <<<HTML
            <p>No Task Found</p>
        HTML;
    }

    echo render([
        'title' => 'List Task',
        'main-content' => $mainContent
    ]);
?>