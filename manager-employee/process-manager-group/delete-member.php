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
    $indexGroup = (int)$_GET["indexgroup"];
    $indexEm = (int)$_GET["indexemployee"];

    for ($i=0; $i < count($members[$indexGroup]); $i++)
        if ($members[$indexGroup][$i] == $indexEm) {
            $indexNeedDelete = $i;
            break;
        }

    array_splice($members[$indexGroup], $indexNeedDelete, 1);

    $employees[$indexEm]->group = '';

    if ($_GET["path"] == "add")
        $pathBack="location: add-member.php?select-group=".$indexGroup;
    else
        $pathBack="location: display-manager-group.php";

    $employeeManager->putFileJson($employees);
    $groupManager->putFileJson($members);


}
header($pathBack);