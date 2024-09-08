<?php
class Request
{
    public string $name;
    public int $status;
    public int $phone;
    public int $id;

    public function __construct($name, $status, $phone, $id = null)
    {
        $this->name = $name;
        $this->status = $status;
        $this->phone = $phone;
        $this->id = $this->genId();
    }

    function create()
    {
        $newLine = $this->name . "\t" . $this->phone . "\t" . $this->id . "\t" . $this->status . PHP_EOL;
        file_put_contents('data.tsv', $newLine, FILE_APPEND);
    }

    private function genId()
    {
        $idFileName = 'id.tsv';
        assureFileExistance($idFileName);

        $id = (int)file_get_contents($idFileName) + 1;
        file_put_contents($idFileName, $id);

        return $id;
    }
}

function assureFileExistance(string $filename): void {//убрать
    if (!file_exists($filename)) {
        fclose(fopen($filename, 'w'));
    }
}
