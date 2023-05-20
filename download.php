<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>下载</title>
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
include("connect.php");
if (!isset($_SESSION["isLogin"])) {
    echo "<h1>未经授权</h1><a href=\"index.html\">回到首页</a><br />";
    exit();
}
error_log(0);

$hash = $_GET["hash"];
$user = $_GET["user"];
$filename = $_GET["filename"];
$sql = "select * from $user where hash_sha256 = '$hash'";
$result = mysqli_query($con, $sql); //执行sql
if ($result->num_rows > 0) {
    $file = fopen("./files/" . $hash, "rb");
    Header("Content-type: application/octet-stream");
    Header("Accept-Ranges: bytes");
    Header("Content-Disposition: attachment; filename=" . $filename);
    echo fread($file, filesize("./files/" . $hash));
    fclose($file);

    exit();

} else {
    echo "<h1>hash不合法或不存在</h1> <a href=\"index.html\">回到首页</a><br />";

}