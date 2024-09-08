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
$lines = explode("\n", trim($homepage));

function createContactBlock($name, $tel, $id, $statys) {
    if ($name === null || $tel === null || $id === null || trim($name) === '' || trim($tel) === '' || trim($id) === '') {
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
            '<input type="hidden" name="id" value="' . htmlspecialchars($id) . '">' . 
            htmlspecialchars($id) . 
            " " . 
            htmlspecialchars($name) . 
            " " . 
            htmlspecialchars($tel) .
            " " . 
            htmlspecialchars($statys)  . 
            " " .
            ' <button type="submit" name="submit_button" style="display: inline;">Удалить</button></form>' . 
            " " . 
            '<form action="../php/status.php" method="post" style="margin: 0; display: inline;">' . 
            '<input type="hidden" name="id" value="' . htmlspecialchars($id) . '">' . 
            '<button type="submit" name="submit_button" style="display: inline;">Поменять статус</button>' . 
            '</form><br>';
    }
}

$contactBlocks = array_filter($lines, function($line) {
    return !empty($line);
});

$contactBlocks = array_map(function($line) {
    list($name, $tel, $id, $statys) = explode("\t", $line, 4) + [NULL, NULL, NULL, NULL];
    return createContactBlock($name, $tel, $id, $statys);
}, $contactBlocks);

echo implode("\n", $contactBlocks);