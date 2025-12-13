<?php
// api/debug.php
echo "<h1>Vercel File System Debugger</h1>";

// 1. Cek posisi kita sekarang
echo "<b>Current Directory (API):</b> " . __DIR__ . "<br><br>";

// 2. Cek apakah folder public ada di root
$publicPath = __DIR__ . '/../public';
echo "<b>Checking Public Folder:</b> " . realpath($publicPath) . "<br>";

if (is_dir($publicPath)) {
    echo "<span style='color:green'>[OK] Public folder found.</span><br>";
    
    // 3. Cek apakah folder js ada
    $jsPath = $publicPath . '/js';
    if (is_dir($jsPath)) {
        echo "<span style='color:green'>[OK] JS folder found.</span><br>";
        
        // 4. List semua file di dalam folder js
        echo "<b>Files inside /public/js:</b><br><pre>";
        $files = scandir($jsPath);
        print_r($files);
        echo "</pre>";
    } else {
        echo "<span style='color:red'>[ERROR] JS folder NOT found inside public!</span><br>";
        echo "Check folder contents of public:<br><pre>";
        print_r(scandir($publicPath));
        echo "</pre>";
    }
} else {
    echo "<span style='color:red'>[ERROR] Public folder NOT found at root!</span><br>";
    echo "Files at Root:<br><pre>";
    print_r(scandir(__DIR__ . '/../'));
    echo "</pre>";
}