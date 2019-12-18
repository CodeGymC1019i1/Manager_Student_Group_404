<?php

session_start();
include_once "../class/Group.php";
include_once "../class/GroupManager.php";
include_once "../define/define-json.php";
include_once "../class/EmployeeManager.php";

if (!isset($_SESSION["username"]))
    header("location: ../index.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $index = $_GET["index"];

    $employeeManager = new EmployeeManager(DefineJson::PATH_EMPLOYEE);
    $memmber = new GroupManager(DefineJson::PATH_MEMBER);
    $group = new Group(DefineJson::PATH_GROUP);
    $listGroup = $group->readFileJson();

    $listEmployee = $employeeManager->readFileJson();

    foreach ($listEmployee as $employee) {
        if ($employee->group == $listGroup[$index]) {
            $employee->group = '';
        }
    }

    $employeeManager->putFileJson($listEmployee);

    $group->delete($index);

    $memmber->delete($index);

    header("location: display-manager-group.php");
}
