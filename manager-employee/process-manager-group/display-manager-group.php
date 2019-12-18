<?php
session_start();

if (!isset($_SESSION["username"]))
    header("location: ../index.php");

include_once "../class/Group.php";
include_once "../class/EmployeeManager.php";
include_once "../class/FileJson.php";
include_once "../define/define-json.php";
include_once "../class/GroupManager.php";

$index = 0;

$employeeManager = new EmployeeManager(DefineJson::PATH_EMPLOYEE);
$dataGroups = new FileJson(DefineJson::PATH_GROUP);
$member = new GroupManager(DefineJson::PATH_MEMBER);
$listEmployee = $employeeManager->readFileJson();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group = new Group(DefineJson::PATH_GROUP, $_POST["namegroup"]);
    $group->add($group->name);

    $member->add([]);
}

if (isset($_GET["select-group"]))
    $index = (int)$_GET["select-group"];

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
        #container {
            position: absolute;
            margin-left: 10%;
            border: #808080 solid 1px;
            width: 80%;
            padding: 10px;
        }

    </style>
</head>
<body>
<div id="container">
    <h1>Manager Group</h1>
    <a href="../login-logout/home.php">
        <button>Back</button>
    </a>
    <form action="" method="post">
        <input type="text" name="namegroup"><input type="submit" value="Create">
    </form>
    <div>
        <form method="get">
            <select name="select-group" onchange="this.form.submit()">
                <?php
                $groups = $dataGroups->readFileJson();
                for ($i = 0; $i < count($groups); $i++):
                    ?>
                    <option value="<?php echo $i ?>" <?php if ($groups[$i] == $groups[$index]): ?>
                        selected="selected" <?php endif; ?>>
                        <?php echo $groups[$i]; ?></option>
                <?php endfor; ?>
            </select>
        </form>
        <a href="delete-group.php?index=<?php echo $index; ?>">
            <input type="submit" value="Delete group"></a>
        <a href="edit-name-group.php?index=<?php echo $index; ?>">
            <input type="button" value="Edit name"></a>
        <a href="../process-manager-group/add-member.php"><input type="button" value="Add member"></a>
        <div>
            <table>
                <caption><b>List Members<b></caption>
                <br>
                <tr>
                    <th>Index</th>
                    <th>Name</th>
                    <th>Birthday</th>
                    <th>Address</th>
                    <th>Position</th>
                    <th>Group</th>
                </tr>
                <?php
                $listMember = $member->readFileJson()[$index];
                for ($i = 0; $i < count($listMember); $i++):
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $listEmployee[$listMember[$i]]->firstName . ' ' .
                                $listEmployee[$listMember[$i]]->lastName; ?></td>
                        <td><?php echo $listEmployee[$listMember[$i]]->birthDay; ?></td>
                        <td><?php echo $listEmployee[$listMember[$i]]->address; ?></td>
                        <td><?php echo $listEmployee[$listMember[$i]]->position; ?></td>
                        <td><?php echo $listEmployee[$listMember[$i]]->group; ?></td>
                        <td><a href="delete-member.php?indexgroup=<?php echo $index; ?>&indexemployee=<?php echo $listMember[$i];
                                                    ?>&path=display">
                                <input type="button" value="Remove Member"></a></td>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>
