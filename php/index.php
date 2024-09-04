<?php

$file = 'data.tsv'; // обращаемся к файлу

$current = file_get_contents($file); // считываем

$lines = explode("\r\n", trim($current));

$linesId = end($lines);

$int = explode(" ", $linesId);
$id = end($int);

$id = (int)$id;

$x = $id + 1;

if (!isset($_POST['name']) || !isset($_POST['tel']) || $_POST['name'] === null || $_POST['tel'] === null) {
    echo "Записей нету"; // Используйте echo для вывода сообщения
    exit;
}
else{
    $current .= $_POST['name'] . " " . $_POST['tel'] . " " . $x . "\r\n"; // добавляем данные
}

file_put_contents($file, $current); // записываем данные