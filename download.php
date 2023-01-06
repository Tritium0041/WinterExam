<?php
session_start();
include("connect.php");
if (!isset($_SESSION["isLogin"])) {
    echo "未经授权";
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
    echo "hash不合法或不存在";

}