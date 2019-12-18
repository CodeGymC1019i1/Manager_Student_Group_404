<?php

include_once "../define/define-json.php";
include_once "../class/EmployeeManager.php";
include_once "../class/GroupManager.php";
include_once "../class/Group.php";

$employeeManager = new EmployeeManager(DefineJson::PATH_EMPLOYEE);
$group = new Group(DefineJson::PATH_GROUP);
$groupManager = new GroupManager(DefineJson::PATH_MEMBER);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $employees = $employeeManager->readFileJson();
    $groups = $group->readFileJson();
    $members = $groupManager->readFileJson();
    $indexGroup = (int) $_GET["indexgroup"];
    $indexEm = (int) $_GET["indexemployee"];
    array_push($members[$indexGroup],  $indexEm);

    for ($i=0; $i<count($groups);$i++) {
        if ($groups[$i] == $employees[$indexEm]->group) {
            $indexOldGroup = $i;
            break;
        }
    }
    $indexNeedDelete = array_search($indexEm,$members[$indexOldGroup]);
    array_splice($members[$i], $indexNeedDelete,1);

    $employees[ $indexEm]->group = $groups[$indexGroup];

    $employeeManager->putFileJson($employees);
    $groupManager->putFileJson($members);
}
$pathBack = "location: add-member.php?select-group=".$indexGroup;
header($pathBack);