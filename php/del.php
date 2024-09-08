<?php
include_once "common.php";

function del(array $lines, int $idToDelete): array
{
    $callback = function ($line) use ($idToDelete) {
        $request = explode("\t", $line, 4);
        return (int)$request[REQUEST_ID] !== $idToDelete;
    };

    return array_filter($lines, $callback);
}

$lines = file(DATA_FILE_NAME, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

$idToDelete = (int)$_POST['id'];

$filteredLines = del($lines, $idToDelete);

$content = implode("\n", $filteredLines);
if ($content) {
    $content .= "\n";
}

file_put_contents(DATA_FILE_NAME, $content);

header('Location: ../php/admin.php', response_code: 302);
exit;