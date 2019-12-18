<?php

session_start();

if (!isset($_SESSION["username"]))
    header("location: ../index.php");

include_once "../class/Group.php";
include_once "../class/EmployeeManager.php";
include_once "../class/FileJson.php";
include_once "../define/define-json.php";
include_once "../class/GroupManager.php";

if (!empty($_GET["select-group"]))
    $index = $_GET["select-group"];
else
    $index = 0;

$employeeManager = new EmployeeManager(DefineJson::PATH_EMPLOYEE);
$dataGroups = new FileJson(DefineJson::PATH_GROUP);
$member = new GroupManager(DefineJson::PATH_MEMBER);
$listEmployee = $employeeManager->readFileJson();

echo $index;
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
        #title-member{
            text-align: center;
        }
    </style>
</head>
<body>
<div id="container">
    <h1>Add Member For Group</h1>
    <a href="../process-manager-group/display-manager-group.php">
        <button>Back</button>
    </a>
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
        <div>
            <table>
                <caption><b>List Employee<b></caption>
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
                for ($i = 0; $i < count($listEmployee); $i++):
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $listEmployee[$i]->firstName . ' ' .
                                $listEmployee[$i]->lastName; ?></td>
                        <td><?php echo $listEmployee[$i]->birthDay; ?></td>
                        <td><?php echo $listEmployee[$i]->address; ?></td>
                        <td><?php echo $listEmployee[$i]->position; ?></td>
                        <td><?php echo $listEmployee[$i]->group; ?></td>
                        <td><a href="add-member-into-group.php?indexgroup=<?php echo $index; ?>&indexemployee=<?php echo $i; ?>">
                                <input type="button" value="Add member"></a></td>
                    </tr>
                <?php endfor; ?>

                <tr>
                    <td colspan="7" id="title-member"><b>Members</b></td>
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
                            ?>&path=add">
                                <input type="button" value="Remove member"></a></td>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>
