<?php

include_once "FileJson.php";

class CRUD extends FileJson
{
    public function __construct($path)
    {
        parent::__construct($path);

    }

    public function add($data)
    {
        $dataJson = $this->readFileJson();
        array_push($dataJson, $data);
        $this->putFileJson($dataJson);
    }

    public function delete($index)
    {
        $dataJson = $this->readFileJson();
        array_splice($dataJson ,$index,1);
        $this->putFileJson($dataJson);
    }

    public function edit($index, $element)
    {
        $dataJson = $this->readFileJson();
        $dataJson[$index] = $element;
        $this->putFileJson($dataJson);
    }

    public function search($keyword)
    {
        $dataJson = $this->readFileJson();
        if (empty($keyword))
            return $dataJson;
        else {
            $keyword = strtolower($keyword);
            $resultSearch = [];
            foreach ($dataJson as $index => $element) {
                var_dump($keyword, $element->position);
                if (is_numeric(strpos($element->firstName,$keyword)) || is_numeric(strpos($element->lastName,$keyword))
                    || is_numeric(strpos($element->birthDay,$keyword)) || is_numeric(strpos($element->address,$keyword))
                    || is_numeric(strpos($element->position,$keyword)) ||  is_numeric(strpos($element->group,$keyword)) ) {
                    array_push($resultSearch,$element);
                    continue;
                }
            }
        }
        return $resultSearch;

    }
}