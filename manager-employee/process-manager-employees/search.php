<?php
session_start();
if (!isset($_SESSION["username"]))
    header("location: ../index.php");

include_once "../class/EmployeeManager.php";
include_once "../define/define-json.php";

$employeeManager = new EmployeeManager(DefineJson::PATH_EMPLOYEE);
$fileJson = new FileJson(DefineJson::PATH_SEARCH);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $keyword = $_GET["keyword"];
}
$resultSearch = $employeeManager->search($keyword);
$fileJson->putFileJson($resultSearch);
header("location: ../login-logout/home.php?searched=true");
