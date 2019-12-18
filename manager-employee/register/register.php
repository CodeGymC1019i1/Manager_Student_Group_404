<?php

include_once "../data-file-json/users.json";
include_once "../class/UserManager.php";
include_once "../class/User.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userManager = new UserManager("../data-file-json/users.json");
    $user = new User();
    $user->setFirstName($_POST["firstname"]);
    $user->setLastName($_POST["lastname"]);
    $user->setUsername($_POST["username"]);
    $user->setPassword($_POST["password"]);
    $user->setBirthDay($_POST["birthday"]);
    $user->setAddress($_POST["address"]);
    $user->setPosition($_POST["position"]);
    $userManager->add($user);
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
        div{
            position: absolute;
            margin-left: 30%;
            padding: 10px;
            border: 1px solid gray;
        }
        caption{
            size: 14px;
            padding: 15px;
        }
    </style>
</head>
<body>
<div>
    <form action="" method="post">
        <table>
            <caption><b>Register</b></caption>
            <tr>
                <td>First name: </td>
                <td><input type="text" name="firstname"></td>
            </tr>
            <tr>
                <td>Last name: </td>
                <td><input type="text" name="lastname"></td>
            </tr>
            <tr>
                <td>Username: </td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>Re-type password: </td>
                <td><input type="password" name="retypePassword"></td>
            </tr>
            <tr>
                <td>Birthday: </td>
                <td><input type="date" name="birthday"></td>
            </tr>
            <tr>
                <td>Address: </td>
                <td><input type="text" name="address"></td>
            </tr>
            <tr>
                <td>Position: </td>
                <td><input type="text" name="position"></td>
            </tr>
            <tr>
                <td><input type="submit" value="Register"></td>
                <td><a href="../index.php"><input type="button" value="Back"></a></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>