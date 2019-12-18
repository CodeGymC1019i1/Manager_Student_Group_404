<?php

session_start();
if (!isset($_SESSION["username"]))
    header("location: ../index.php");

include_once "../class/Employee.php";
include_once "../class/EmployeeManager.php";
include_once "../class/Group.php";
include_once "../define/define-json.php";
include_once "../class/GroupManager.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $index = (int)$_GET["id"];
}

$employeeManager = new EmployeeManager(DefineJson::PATH_EMPLOYEE);
$dataGroups = new Group(DefineJson::PATH_GROUP);
$dataMember = new GroupManager(DefineJson::PATH_MEMBER);
$groups = $dataGroups->readFileJson();
$membersInGroup = $dataMember->readFileJson(true);
$arr = $employeeManager->readFileJson();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $index = (int)$_GET["id"];
    $employee = new Employee();

    include_once("../login-logout/upload-image.php");

    $employee->setFirstName($_POST["firstname"]);
    $employee->setLastName($_POST["lastname"]);
    $employee->setBirthDay($_POST["birthday"]);
    $employee->setAddress($_POST["address"]);
    $employee->setPosition($_POST["position"]);
    $employee->setGroup($groups[$_POST["select-group"]]);
    $employee->setAvatar($arr[$index]->avatar);

    if (!empty(basename($_FILES["fileToUpload"]["name"]))) {
        for ($i = 0; $i < count($membersInGroup); $i++) {
            for ($j = 0; $j < count($membersInGroup[$i]); $j++) {
                if ($membersInGroup[$i][$j] == $index) {
                    $finded = true;
                    array_splice($membersInGroup[$i], $j, 1);
                }
            }
        }
        $employee->setAvatar($target_file);
        array_push($membersInGroup[$_POST["select-group"]], $index);
    }

    $dataMember->putFileJson($membersInGroup);

    $employeeManager->edit($index, $employee);


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
    <style>
        div {
            position: absolute;
            margin-left: 30%;
            border: #808080 solid 1px;
            width: 30%;
            padding: 10px;
        }

        img {
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>
<div>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <h1>Edit Employee</h1>
            <tr>
                <td>First name:</td>
                <td><input type="text" name="firstname" value="<?php echo $arr[$index]->firstName ?>"></td>
            </tr>

            <tr>
                <td>Last name:</td>
                <td><input type="text" name="lastname" value="<?php echo $arr[$index]->lastName ?>"></td>
            </tr>

            <tr>
                <td>Birth day:</td>
                <td><input type="date" name="birthday" value="<?php echo $arr[$index]->birthDay ?>"></td>
            </tr>

            <tr>
                <td>Address:</td>
                <td><input type="text" name="address" value="<?php echo $arr[$index]->address ?>"></td>
            </tr>

            <tr>
                <td>Position:</td>
                <td><input type="text" name="position" value="<?php echo $arr[$index]->position ?>"></td>
            </tr>

            <tr>
                <td>Group:</td>
                <td>
                    <select name="select-group">
                        <?php
                        for ($i = 0; $i < count($groups); $i++):
                            ?>
                            <option value="<?php echo $i ?>"
                                <?php if ($groups[$i] == $arr[$index]->group): ?>
                                    selected="selected"
                                <?php endif; ?>
                            ><?php echo $groups[$i]; ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Avatar:</td>
                <td><img src="<?php echo $arr[$index]->avatar; ?>">
                    <input type="file" name="fileToUpload" id="fileToUpload"></td>
            </tr>

            <tr>
                <td><input type="submit" value="Update"></td>
                <td>
                    <button><a href="../login-logout/home.php">Back</a></button>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>