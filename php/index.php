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

$homepage = file_get_contents($file); // считываем

$lines = explode("\r\n", trim($homepage)); // Разбивает строку разделителем

function createContactBlock($name, $tel, $indificator) {
    if ($name === null || $tel === null || $indificator === null || trim($name) === '' || trim($tel) === '' || trim($indificator) === '') {
        return 'неправильная запись<br><br>';
    } else {
        return 
            '<form action="../php/del.php" method="post" style="margin: 0">' . 
            '<input type="hidden" name="indificator" value="' . htmlspecialchars($indificator) . '">' . // Скрытое поле для indificator
            htmlspecialchars($indificator) . 
            " " . 
            htmlspecialchars($name) . 
            " " . 
            htmlspecialchars($tel) .
            " " . 
            ' <button type="submit" name="submit_button" style="display: inline;">Нажмите меня</button></form><br>';
    }
}

$contactBlocks = array_filter($lines, function($line) {
    return !empty($line);
});

$contactBlocks = array_map(function($line) {
    list($name, $tel, $indificator) = explode(' ', $line, 3) + [NULL, NULL, NULL];
    return createContactBlock($name, $tel, $indificator);
}, $contactBlocks);

echo implode("\n", $contactBlocks);
