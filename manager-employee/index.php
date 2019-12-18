<?php
session_start();
include_once "class/UserManager.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $usersJson = new FileJson("data-file-json/users.json");
    $users = $usersJson->readFileJson();

    foreach ($users as $index => $user)
        if ($user->username == $username && $user->password == $password) {
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            header("location: login-logout/home.php");
        } else
            $message = "Wrong username or password! Please retype!";
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
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div>
    <form action="" method="post">
        <table>
            <caption><b>Login</b></caption>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" placeholder="username"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password"></td>
            </tr>
        </table>
        <a href="login-logout/home.php"><input type="submit" value="Login" name="login"></a>
        <a href="register/register.php"><input type="button" value="Register"></a>
    </form>
    <p><?php echo $message ?></p>
</div>

</body>
</html>
