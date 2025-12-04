
<?php
// config/config.php
spl_autoload_register(function($class) {
    $paths = ['app/models/', 'app/controllers/'];
    foreach ($paths as $path) {
        $file = __DIR__ . '/../' . $path . strtolower($class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
session_start();
