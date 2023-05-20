<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登陆错误</title>
    <link rel="shortcut icon" href="./imgs/icon.png" type="image/x-icon">  
    <link rel="stylesheet" href="css/reset.css">
    <style>
    html{
    background: linear-gradient(to left top,rgb(232, 236, 238),rgb(39, 180, 236));
    height: 100vh;
    }
    h1{
    color:rgb(250, 72, 72);
    font-size: 2vw;
    text-align: center;
    height: 10vw;
    line-height: 10vw;
    }
    a {
    display: block;
    font-size: 1vw;
    height: 3vw;
    width: 10vw;
    margin: auto;
    border: 0.01vw solid white;
    border-radius: 5vw;
    line-height: 3vw ;
    text-align: center;
    margin-top: 2vw;
    color: white
    }
    a:hover{
    background-color: rgb(52, 201, 7);
    border:0.01vw rgb(52, 201, 7) solid;

    }
    </style>
</head>

<?php
session_start();

if (!isset($_POST['submit'])) {
    exit("错误执行");
} //判断是否有submit操作


include("connect.php");
if (isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] == true) {
    $oldpwd_sha = hash("sha256", $_POST["oldpassword"]);
    $username_base64 = base64_encode($_SESSION["username"]);
    $sql = "select * from user where username_base64 = '$username_base64' and pwd_sha256='$oldpwd_sha'";
    $result = mysqli_query($con, $sql); //执行sql
    $rows = mysqli_num_rows($result); //返回一个数值
    if ($rows) {
        if ($_POST["new1"] == $_POST["new2"]) {
            $newpwd_sha = hash("sha256", $_POST["new1"]);
            mysqli_query($con, "update user set pwd_sha256 = '$newpwd_sha' where username_base64 = '$username_base64'");
            echo "<h1>修改成功!</h1> <a href=\"index.html\" >回到首页</a>";
        } else {
            echo "<h1>新密码输入不匹配！</h1>";
        }
    } else {
        echo "<h1>原密码不匹配！</h1>";
    }
}