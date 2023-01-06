<?php
session_start();
// error_reporting(0);
include("connect.php");
// 获取文件信息
if (isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] == true && isset($_FILES['file'])) {
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $type = $_FILES['file']['type'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $data = file_get_contents($_FILES['file']['tmp_name']);
    $hash = hash("sha256", $data);
    $path = 'files/' . $hash;

    $sql = "select * from file where hash_sha256 = '$hash'";
    $result = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($result); //返回一个数值
    if ($rows) { //0 false 1 true
        echo "上传成功！重复";
        $name_base64 = base64_encode($_SESSION["username"]);
        $result1 = mysqli_query($con, "select * from $name_base64 where hash_sha256 = '$hash' and filename = '$name'");
        $rows1 = mysqli_num_rows($result); //返回一个数值
        if (!$rows1) {
            mysqli_query($con, "insert into $name_base64 (hash_sha256,filename) values ('$hash','$name')");
        }
        mysqli_query($con, "update file set count=count+1 where hash_sha256 = $hash");

    } else {
        $name_base64 = base64_encode($_SESSION["username"]);
        mysqli_query($con, "insert into file (hash_sha256,path,count) values ('$hash','$path',1)");
        mysqli_query($con, "insert into $name_base64 (hash_sha256,filename) values ('$hash','$name')");
        // 将文件从临时目录移动到保存路径
        move_uploaded_file($tmp_name, $path);
        echo "上传成功！非重复";
    }
} else {
    echo "未登录或未经授权！";

}


?>