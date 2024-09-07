<?php
session_start();  // Запускаем сессию

$storedHashedPassword = password_hash('1234', PASSWORD_BCRYPT);

if (isset($_POST['password'])) {
    $password = $_POST['password'];

    if (password_verify($password, $storedHashedPassword)) {
        $_SESSION['password'] = $storedHashedPassword;
    } else {
        echo "Доступ запрещен!";
        exit;
    }
} elseif (!isset($_SESSION['password']) || !password_verify('1234', $_SESSION['password'])) {
    echo "Доступ запрещен!";
    exit;
}

echo "Добро пожаловать в админку!<br>";
$file = 'data.tsv';
$homepage = file_get_contents($file);
$lines = explode("\r\n", trim($homepage));

function createContactBlock($name, $tel, $indificator, $statys) {
    if ($name === null || $tel === null || $indificator === null || trim($name) === '' || trim($tel) === '' || trim($indificator) === '') {
        return 'неправильная запись<br><br>';
    } else {
        if ($statys == 0){
            $statys = "Не расмотренно";
        }
        elseif ($statys == 1){
            $statys = "Рассмотренно";
        }
        return 
            '<form action="../php/del.php" method="post" style="margin: 0; display: inline;">' . 
            '<input type="hidden" name="indificator" value="' . htmlspecialchars($indificator) . '">' . 
            htmlspecialchars($indificator) . 
            " " . 
            htmlspecialchars($name) . 
            " " . 
            htmlspecialchars($tel) .
            " " . 
            htmlspecialchars($statys)  . 
            " " .
            ' <button type="submit" name="submit_button" style="display: inline;">Удалить</button></form>' . 
            " " . 
            '<form action="../php/statys.php" method="post" style="margin: 0; display: inline;">' . 
            '<input type="hidden" name="indificator" value="' . htmlspecialchars($indificator) . '">' . 
            '<button type="submit" name="submit_button" style="display: inline;">Поменять статус</button>' . 
            '</form><br>';
    }
}

$contactBlocks = array_filter($lines, function($line) {
    return !empty($line);
});

$contactBlocks = array_map(function($line) {
    list($name, $tel, $indificator, $statys) = explode(' ', $line, 4) + [NULL, NULL, NULL, NULL];
    return createContactBlock($name, $tel, $indificator, $statys);
}, $contactBlocks);

echo implode("\n", $contactBlocks);



