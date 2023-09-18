<?php
    // config.php -> store credentials for database connection and have singletons for database connection
    return [
        'connections' => [
            'mysql' => [
                'host' => 'localhost',
                'database' => 'task_manager',
                'username' => 'root',
                'password' => 'Kemong123',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci'
            ]
        ]
    ];
?>