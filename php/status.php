<?php
$filename = 'data.tsv';

$id = $_POST['id'];

$file = fopen($filename, "r+");
while (!feof($file)) {
    $request = fgetcsv($file, separator: "\t");
    if ($request[2] === $id) {
        fseek($file, -2, SEEK_CUR);
        $newStatus = ($request[3] + 1) % 2;
        fwrite($file, $newStatus);
    }
}
fclose($file);

header('Location: ../php/admin.php', response_code: 302);
exit;