<?php
include 'request.php';
//ролверка поелй
$request = new Request($_POST['name'], 0, $_POST['tel']);
$request->create();



header('Location: ../index.html', true, 302);
exit;