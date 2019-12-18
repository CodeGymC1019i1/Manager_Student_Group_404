<?php

include_once "../define/define-json.php";
include_once "../class/Group.php";
include_once "../class/EmployeeManager.php";
include_once "../class/GroupManager.php";

$group = new Group(DefineJson::PATH_GROUP);
$listMember = $group->readFileJson();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listMember[$_GET["index"]] = $_POST["nameGroup"];
    $group->putFileJson($listMember);

    $employeeManager = new EmployeeManager(DefineJson::PATH_EMPLOYEE);
    $groupManager = new GroupManager(DefineJson::PATH_MEMBER);

    $employees = $employeeManager->readFileJson();
    $memberInGroup = $groupManager->readFileJson();

    foreach ($memberInGroup[$_GET["index"]] as $indexMember) {
        $employees[$indexMember]->group = $_POST["nameGroup"];
    }

    $employeeManager->putFileJson($employees);
    $groupManager->putFileJson($memberInGroup);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div>
    <a href="display-manager-group.php"><input type="button" value="Back"></a>
    <form action="" method="post">
        Edit name group<br>
        <input type="text" name="nameGroup" value="<?php echo $listMember[$_GET["index"]]; ?>"><br>
        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>