<?php
class Id
{
    function id()
    {
        $file = file('data.tsv', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);//читаем файл в массив построчно
        if (!$file) {
            return 1;//если пустой возвращаем 1
        }

        while ($line = end($file)) {//пока не дойдем до конца файла
            $str = explode(" ", $line);
            if (isset($str[0], $str[1], $str[2], $str[3]) && is_string($str[0]) && is_numeric($str[1]) && is_numeric($str[2]) && is_numeric($str[3])) {
                return (int)$str[2] + 1;//елси есть все переменные и они совпадают с нужными хракатеристиками то прошлый id +1
            }
            array_pop($file);//если нет удаляем но только у нас, мы это не сохроняем в общую базу(возможно еще млжно востановить строку с данными и тд.) строку
        }
        return 1;//если прошли весь файл и не нашли то 1
    }
}


class Request
{
    public string $name;
    public int $status;
    public int $tel;
    public int $id;
    function __construct($name, $status, $tel, $id = null)
    {
        $this->name = $name;
        $this->status = $status;
        $this->tel = $tel;
        $this->id = $id;
    }
    function record()
    {
        $current = file_get_contents('data.tsv');
        $newLine = $this->name . " " . $this->tel . " " . $this->id . " " . $this->status;
        $current .= "\r\n" . $newLine;
        file_put_contents('data.tsv', $current);
        header('Location: ../index.html');
        exit;
    }
}
$newId = new Id();
$id = $newId->id();
$request = new Request($_POST['name'], 0, $_POST['tel'], $id);
$request->record();