<?php
include_once "common.php";

class Request
{
    public string $name;
    public int $status;
    public int $phone;
    public int $id;

    public function __construct($name, $status, $phone)
    {
        $this->name = $name;
        $this->status = $status;
        $this->phone = $phone;
        $this->id = $this->genId();
    }

    public function create(): void
    {
        $newLine = $this->name . "\t" . $this->phone . "\t" . $this->id . "\t" . $this->status . "\n";
        file_put_contents(DATA_FILE_NAME, $newLine, FILE_APPEND);
    }

    private function genId(): int
    {
        assureFileExistance(ID_FILE_NAME);

        $id = (int)file_get_contents(ID_FILE_NAME) + 1;
        file_put_contents(ID_FILE_NAME, $id);

        return $id;
    }
}

function assureFileExistance(string $filename): void
{ //убрать
    if (!file_exists($filename)) {
        fclose(fopen($filename, 'w'));
    }
}
