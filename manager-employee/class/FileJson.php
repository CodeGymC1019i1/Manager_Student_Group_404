<?php


class FileJson
{
    public $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function readFileJson($isArray = false)
    {
        $arrayData = [];
        $dataJson = file_get_contents($this->path);
        $arrayData = json_decode($dataJson, $isArray);
        return $arrayData;
    }

    public function putFileJson($data)
    {
        $dataJson = json_encode($data);
        file_put_contents($this->path,$dataJson);
    }

}