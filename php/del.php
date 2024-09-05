<?php
session_start();  // Запуск сессии

$file = 'data.tsv';
$homepage = file_get_contents($file);
$lines = explode("\r\n", trim($homepage));

$indificatorToDelete = $_POST['indificator'];

function del($lines, $indificatorToDelete) {
    return array_filter($lines, function($line) use ($indificatorToDelete) {
        list($name, $tel, $indificator, $statys) = explode(' ', $line, 4) + [NULL, NULL, NULL, NULL];
        return $indificator !== $indificatorToDelete;
    });
}

$filteredLines = del($lines, $indificatorToDelete);

file_put_contents($file, implode("\r\n", $filteredLines));





// Перенаправляем обратно в admin.php, сессия сохранит данные
header('Location: ../php/admin.php');  // Обновите путь к вашей главной странице
exit;