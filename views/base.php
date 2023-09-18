<?php
    function render($data) {
        $title = htmlspecialchars($data['title']);
        $mainContent = $data['main-content'];
        return <<<HTML
        <!DOCTYPE html>
        <html>
            <head>
                <title>
                    {$title}
                </title>
                <style>
                    table, th, td {
                        border: 1px solid black;
                        border-collapse: collapse;
                    }
                </style>
            </head>
            <body>
                <div id="header">
                    <a href="/"> Home </a>
                    <hr/>
                    <form action="/tasks" method="POST">
                        <input type="text" name="title" placeholder="Title"></input>
                        <input type="text" name="description" placeholder="Description"></input>
                        <button type="submit">New Task</button>
                    </form>
                    <hr/>
                </div>
                <div id="searchBar">
                    <form action="/tasks" method="GET">
                        <input type="text" name="search" placeholder="Search Task"></input>
                        <button type="submit">Go!</button>
                    </form>
                    <hr/>
                    <form action="/tasks" method="GET">
                        <label>Filter</label>
                        <select name="filter">
                            <option value="">All Statuses</option>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                        <button type="submit">Go!</button>
                    </form>
                    <hr/>
                </div>
                <div id="main-content">
                    {$mainContent}
                </div>
            </body>
        </html>
        HTML;
    }
?>