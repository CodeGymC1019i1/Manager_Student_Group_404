<?php

include_once "CRUD.php";

class Group extends CRUD
{
    public $name;

    public function __construct($path, $name='')
    {
        parent::__construct($path);
        $this->name=$name;
    }

}