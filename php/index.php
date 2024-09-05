<?php

$file = 'data.tsv'; // обращаемся к файлу

$current = file_get_contents($file); // считываем

$lines = explode("\r\n", trim($current));

$linesId = end($lines);

$int = explode(" ", $linesId);
$id = $int[2];

$id = (int)$id;

$x = $id + 1;

$statys = 0;

if (!isset($_POST['name']) || !isset($_POST['tel']) || $_POST['name'] === null || $_POST['tel'] === null) {
    echo "Записей нету"; // Используйте echo для вывода сообщения
    exit;
}
else{
    $current .= $_POST['name'] . " " . $_POST['tel'] . " " . $x . " " . $statys . "\r\n"; // добавляем данные
}

file_put_contents($file, $current); // записываем данные
header('Location: ../index.html');  // Обновите путь к вашей главной странице
exit;