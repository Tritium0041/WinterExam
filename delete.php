<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登出</title>
    <link rel="shortcut icon" href="./imgs/icon.png" type="image/x-icon">  
    <link rel="stylesheet" href="css/reset.css">
    <style>
    html{
    background: linear-gradient(to left top,rgb(232, 236, 238),rgb(39, 180, 236));
    height: 100vh;
    }
    h1{
    color: white;
    font-size: 2vw;
    text-align: center;
    height: 10vw;
    line-height: 10vw;
    }
    h2{
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
error_log(0);
include("connect.php");
if (!isset($_SESSION["isLogin"])) {
    echo "<h2>未经授权</h2> <a href=\"index.html\">回到首页</a><br />";
    exit();
}
error_log(0);
$hash = $_GET["hash"];
$user = $_GET["user"];
mysqli_query($con, "delete from $user where hash_sha256 = '$hash'");
mysqli_query($con, "update file set count=count-1 where hash_sha256 = '$hash'");
$result = mysqli_query($con, "select * from file where hash_sha256 = '$hash'");
$row = $result->fetch_assoc();
if ($row["count"] <= 0) {
    mysqli_query($con, "delete from file where hash_sha256 = '$hash'");
    unlink("./files/" . $hash);
}
echo "<h1>删除完成</h1><a href=\"index.html\">回到首页</a><br />";