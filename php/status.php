<?php
include_once "common.php";
$filename = 'data.tsv';

$id = $_POST['id'];

$file = fopen(DATA_FILE_NAME, "r+");
while (!feof($file)) {
    $request = fgetcsv($file, separator: "\t");
    if ($request[REQUEST_ID] === $id) {
        fseek($file, -2, SEEK_CUR);
        $newStatus = ($request[REQUEST_STATUS] + 1) % 2;
        fwrite($file, $newStatus);
    }
}
fclose($file);

header('Location: ../php/admin.php', response_code: 302);
exit;