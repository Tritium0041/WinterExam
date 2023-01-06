<?php
session_start();
error_log(0);
include("connect.php");
if (!isset($_SESSION["isLogin"])) {
    echo "未经授权<br /><a href=\"index.html\">回到首页</a><br />";
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
echo "删除完成<br /><a href=\"index.html\">回到首页</a><br />";