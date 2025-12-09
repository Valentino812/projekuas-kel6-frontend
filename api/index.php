<?php
// require __DIR__ . '/../public/index.php';

// Aktifkan error reporting kasar
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    // Tampilkan error ke layar browser
    echo '<h1>Fatal Error</h1>';
    echo '<pre>' . $e->getMessage() . '</pre>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}