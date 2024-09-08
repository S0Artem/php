<?php
include 'request.php';
//ролверка поелй
$request = new Request($_POST['name'], 0, $_POST['tel']);
$request->create();

header('Location: ../index.html', response_code: 302);
exit;