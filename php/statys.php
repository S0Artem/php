<?php
session_start();

$file = 'data.tsv';
$homepage = file_get_contents($file);
$lines = explode("\r\n", trim($homepage));

$indificator = $_POST['indificator'];

function updateStatus($lines, $indificatorToUpdate) {
    return array_map(function($line) use ($indificatorToUpdate) {
        list($name, $tel, $indificator, $statys) = explode(' ', $line, 4) + [NULL, NULL, NULL, NULL];

        // Изменяем статус, если индикатор совпадает
        if ($indificator === $indificatorToUpdate) {
            $statys = ($statys == '0') ? '1' : '0';  // Меняем статус
        }

        return implode(' ', [$name, $tel, $indificator, $statys]);  // Возвращаем строку
    }, $lines);
}


$updatedLines = updateStatus($lines, $indificator);
file_put_contents($file, implode("\r\n", $updatedLines));

header('Location: ../php/admin.php');  // Обновите путь к вашей главной странице
exit;
