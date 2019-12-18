<?php
session_start();
if (!isset($_SESSION["username"]))
    header("location: ../index.php");

include_once "../class/FileJson.php";
include_once "../define/define-json.php";

$fileJsonSearch = new FileJson(DefineJson::PATH_SEARCH);
$fileJsonEmployee = new FileJson(DefineJson::PATH_EMPLOYEE);

if ($_SERVER["REQUEST_METHOD"] == "GET")
    if (empty($_GET["searched"])) {
        $list = $fileJsonEmployee->readFileJson();
        $fileJsonSearch->putFileJson($list);
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
            margin-left: 10%;
            border: #808080 solid 1px;
            width: 80%;
            padding: 10px;
        }
        table{
            width: 100%;
        }
        td{
            border-bottom: 1px solid #808080;
            padding: 20px;
        }
        th{
            text-align: left;
            size: 14px;
            padding: 20px;
        }
        caption{
            size: 20px;
        }
        img{
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>
<div>
    <a href="logout.php"><button id="logout">Log out</button></a>
    <form action="../process-manager-employees/search.php" method="get">
    <input type="text" name="keyword" ><input type="submit" value="Search">
    </form>
    <a href="../process-manager-employees/display-add-employee.php"><button>Create Employee</button></a>
    <a href="../process-manager-group/display-manager-group.php"><button>Manager Group</button></a>
    <a href="../process-attendance/attendance.php"><input type="button" value="Attendance"></a>
    <table>
        <caption><b>List Employees<b></caption><br>
        <tr>
            <th>Index</th>
            <th>Avatar</th>
            <th>Name</th>
            <th>Birthday</th>
            <th>Address</th>
            <th>Position</th>
            <th>Group</th>
        </tr>
        <?php

        $listMember = $fileJsonSearch->readFileJson();
        for($i = 0; $i < count($listMember); $i++):
            ?>
        <tr>
            <td><?php echo $i ?></td>
            <td><img src="<?php echo $listMember[$i]->avatar; ?>"></td>
            <td><?php echo $listMember[$i]->firstName.' '.$listMember[$i]->lastName; ?></td>
            <td><?php echo $listMember[$i]->birthDay;?></td>
            <td><?php echo $listMember[$i]->address;?></td>
            <td><?php echo $listMember[$i]->position;?></td>
            <td><?php echo $listMember[$i]->group;?></td>
            <?php if ($_SESSION["username"] == "admin" && $_SESSION["password"] == "admin"):  ?>
            <td>
                <a href="../process-manager-employees/display-edit-employee.php?id=<?php echo $i; ?>"><button>Edit</button></a>
                <a href="../process-manager-employees/delete-employee.php?id=<?php echo $i; ?>"><button>Delete</button></a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endfor;?>
    </table>
</div>
</body>
</html>
