<?php
function genId(){
    $file = 'data.tsv'; // обращаемся к файлу
    $current = file_get_contents($file); // считываем
    $lines = explode("\r\n", trim($current));
    $linesId = end($lines);
    $int = explode(" ", $linesId);
    $id = $int[2];
    $id = (int)$id;
    $x = $id + 1;
    return $x;
}


class Request {
    public string $name;
    public int $status;
    public int $tel;
    public int $id;
    function __construct($name, $status, $tel, $id = null)
    {
        $this->name = $name;
        $this->status = $status;
        $this->tel = $tel;
        $this->id = $id ?? genId();// если $id не нул задаеться он а если нулл genId()
    }
    function record()
    {
        $current .= "\r\n" . $this->name . " " . $this->tel . " " . $this->id . " " . $this->status;
        file_put_contents('data.tsv', $current, FILE_APPEND);
        header('Location: ../index.html');  // Обновите путь к вашей главной странице
        exit;
    }
}
$request = new Request($_POST['name'], 0 , $_POST['tel']);
$request -> record();
