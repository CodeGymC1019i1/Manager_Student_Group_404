<?php
session_start();
if (!isset($_SESSION["username"]))
    header("location: ../index.php");

include_once "../class/Employee.php";
include_once "../class/EmployeeManager.php";
include_once "../class/Group.php";
include_once "../class/GroupManager.php";
include_once "../define/define-json.php";

$employeeManager = new EmployeeManager(DefineJson::PATH_EMPLOYEE);
$group = new Group(DefineJson::PATH_GROUP);
$managerGroup = new GroupManager(DefineJson::PATH_MEMBER);
$listMember = $managerGroup->readFileJson(true);

$listGroup = $group->readFileJson();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include_once("../login-logout/upload-image.php");

    if (!empty(basename($_FILES["fileToUpload"]["name"]))) {
        $employee = new Employee();
        $employee->setFirstName($_POST["firstname"]);
        $employee->setLastName($_POST["lastname"]);
        $employee->setBirthDay($_POST["birthday"]);
        $employee->setAddress($_POST["address"]);
        $employee->setPosition($_POST["position"]);
        $employee->setGroup($listGroup[$_POST["group"]]);
        $employee->setAvatar($target_file);

        $employeeManager->add($employee);
        array_push($listMember[$_POST["group"]], count($employeeManager->readFileJson()) - 1);
        $managerGroup->putFileJson($listMember);
    }

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
    </style>
</head>
<body>
<div>
    <form action="" method="post">
        <table>
            <h1>Add Employee</h1>
            <tr>
                <td>First name:</td>
                <td><input type="text" name="firstname"></td>
            </tr>

            <tr>
                <td>Last name:</td>
                <td><input type="text" name="lastname"></td>
            </tr>

            <tr>
                <td>Birth day:</td>
                <td><input type="date" name="birthday"></td>
            </tr>

            <tr>
                <td>Address:</td>
                <td><input type="text" name="address"></td>
            </tr>

            <tr>
                <td>Position:</td>
                <td><input type="text" name="position"></td>
            </tr>

            <tr>
                <td>Group:</td>
                <td>
                    <select name="group">
                        <?php for ($i = 0; $i < count($listGroup); $i++): ?>
                            <option value="<?php echo $i; ?>" <?php if ($i == $_POST["group"]): ?>
                                selected="selected" <?php endif; ?>>
                                <?php echo $listGroup[$i]; ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Avatar:</td>
                <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
            </tr>

            <tr>
                <td><input type="submit" value="Add"></td>
                <td><a href="../login-logout/home.php"><input type="button" value="Back"></a></td>
            </tr>
        </table>
        <?php ?>
    </form>
</div>
</body>
</html>