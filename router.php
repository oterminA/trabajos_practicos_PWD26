<?php
$file = $_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"];

if (file_exists($file) && !is_dir($file)) {
    return false; 
} else {
    include_once __DIR__ . '/mi404.php';
}