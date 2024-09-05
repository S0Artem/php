<?php
session_start();

$file = 'data.tsv';
$homepage = file_get_contents($file);
$lines = explode("\r\n", trim($homepage));

$indificator = $_POST['indificator'];

function updateStatus($lines, $indificator) {
    foreach ($lines as &$line) {
        list($name, $tel, $currentIndificator, $statys) = explode(' ', $line, 4) + [NULL, NULL, NULL, NULL];
        
        if ($currentIndificator === $indificator) {
            $statys = ($statys == '0') ? '1' : '0';
            $line = implode(' ', [$name, $tel, $currentIndificator, $statys]);
        }
    }
    return $lines;
}

$updatedLines = updateStatus($lines, $indificator);
file_put_contents($file, implode("\r\n", $updatedLines));

header('Location: ../php/admin.php');  // Обновите путь к вашей главной странице
exit;
