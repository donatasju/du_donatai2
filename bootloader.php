<?php

declare (strict_types=1);

define('ROOT_DIR', __DIR__);
define('DEBUG', true);
define('DB_CREDENTIALS', [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '12345'
]);
define('DB_SCHEMA', 'poopwall_db');
define('DB_TABLE', 'poopwall_du_donatai');

// require ROOT_DIR .  '/config.php';
require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/core/functions/form.php';