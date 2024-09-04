<?php

$file = 'data.tsv';

$homepage = file_get_contents($file);

$lines = explode("\r\n", trim($homepage));

$indificatorToDelete = $_POST['indificator'];

function del($lines, $indificatorToDelete) {
    return array_filter($lines, function($line) use ($indificatorToDelete) {
        list($name, $tel, $indificator) = explode(' ', $line, 3) + [NULL, NULL, NULL];
        return $indificator !== $indificatorToDelete;
    });
}

$filteredLines = del($lines, $indificatorToDelete);

file_put_contents($file, implode("\r\n", $filteredLines));

header('Location: ../php/index.php'); // Обновите путь к вашей главной странице
exit;