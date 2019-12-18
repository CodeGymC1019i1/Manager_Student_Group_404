<?php
session_start();

include_once "../data-file-json/";
include_once "../class/FileJson.php";
include_once "../define/define-json.php";
include_once "../class/EmployeeManager.php";

$dateWorld = new DateTime();

$attendanceJson = new FileJson(DefineJson::PATH_ATTENDANCE);
$employeeData = new FileJson(DefineJson::PATH_EMPLOYEE);
$listAttendance = $attendanceJson->readFileJson();
$employees = $employeeData->readFileJson();
$index = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $index = -1;

    for ($i=0; $i < count($listAttendance); $i++) {
        if (array_search(date("Y/m/d"),$listAttendance[$i]) !== false) {
            $index = $i;
            break;
        }
    }

    if ($index == -1) {
        array_push($listAttendance, []);
        $index = count($listAttendance)-1;
        $listAttendance[$index][0] = date("Y/m/d");
        for ($i=0; $i < count($employees); $i++) {
            array_push($listAttendance[$index],$_POST["attendance".$i]);
        }
    }
    else {
        $listAttendance[$index] =[$listAttendance[$index][0]];
        for ($i=0; $i < count($employees); $i++) {
            array_push($listAttendance[$index],$_POST["attendance".$i]);
        }
    }

    $attendanceJson->putFileJson($listAttendance);
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
    </style>
</head>
<body>
<div>
    <a href="../login-logout/home.php"><input type="button" value="Back"></a>
    <form method="post">
        <table>
            <caption><b>Attendance<b></caption><br>
            <p><b><?php echo date("Y/m/d"); ?></b></p>
            <tr>
                <th>Index</th>
                <th>Name</th>
                <th>Birthday</th>
                <th>Address</th>
                <th>Position</th>
                <th>Group</th>
                <th></th>
            </tr>
            <?php
            for($i = 0; $i < count($employees); $i++):
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $employees[$i]->firstName.' '.$employees[$i]->lastName; ?></td>
                    <td><?php echo $employees[$i]->birthDay;?></td>
                    <td><?php echo $employees[$i]->address;?></td>
                    <td><?php echo $employees[$i]->position;?></td>
                    <td><?php echo $employees[$i]->group;?></td>
                    <?php if ($_SESSION["username"] == "admin" && $_SESSION["password"] == "admin"):  ?>
                        <td>
                            <input type="checkbox" name="attendance<?php echo $i; ?>"
                            value="true" <?php if ($listAttendance[$index][$i+1] == "true"): ?>
                            checked <?php endif; ?>>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endfor;?>
        </table>
        <input type="submit" value="Save">
    </form>
</div>
</body>
</html>