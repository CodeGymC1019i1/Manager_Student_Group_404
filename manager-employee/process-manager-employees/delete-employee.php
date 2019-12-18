<?php
session_start();

if (!isset($_SESSION["username"]))
    header("location: ../index.php");

include_once "../class/EmployeeManager.php";
include_once "../define/define-json.php";
include_once "../class/GroupManager.php";

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $index = (int) $_GET["id"];
}

$employeeManager = new EmployeeManager(DefineJson::PATH_EMPLOYEE);
$groupManager = new GroupManager(DefineJson::PATH_MEMBER);
$listMember = $groupManager->readFileJson();


for ($j=0; $j < count($listMember); $j++) {
    for ($i=0; $i < count($listMember[$j]); $i++) {
        if ($listMember[$j][$i] > $index)
            $listMember[$j][$i]--;
        if ($listMember[$j][$i] == $index) {
            $jIndex = $j;
            $iIndex = $i;
        }
    }
}
array_splice($listMember[$jIndex], $iIndex,1);
var_dump($listMember);

$groupManager->putFileJson($listMember);

$employeeManager->delete($index);

header("location:../login-logout/home.php");

