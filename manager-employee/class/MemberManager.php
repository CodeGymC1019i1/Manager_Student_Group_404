<?php

include_once "CRUD.php";

class MemberManager extends CRUD
{
    public function add($member)
    {
        $dataJson = $this->readFileJson()[$groupName];
        array_push($dataJson, $member);
        $this->putFileJson($dataJson);
    }

    public function delete($index)
    {
        $dataJson = $this->readFileJson()[$groupName];
        foreach ($dataJson as $indexMember) {
            if ($indexMember == $index);
        }
    }
}