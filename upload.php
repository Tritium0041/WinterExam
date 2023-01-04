<?php
if (!isset($_POST['submit'])) {
    exit("错误执行");
} //判断是否有submit操作

include("connect.php");
// 获取文件信息
if (isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] = true && isset($_FILES['file'])) {
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $type = $_FILES['file']['type'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $data = file_get_contents($_FILES['file']['tmp_name']);
    $hash = hash("sha256", $data);
    $path = 'files/' . $hash;

    $sql = "select * from file where hash_sha256 = '$hash'";
    $result = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($result);

    if ($rows) { //0 false 1 true
        echo "上传成功！";
    } else {
        $name_base64 = base64_encode($_SESSION["username"]);
        mysqli_query($con, "insert into file (hash_sha256,path) values ('$hash','$path')");
        mysqli_query($con, "insert into $name_base64 (hash_sha256,filename) values ('$hash','$name')");
        // 将文件从临时目录移动到保存路径
        move_uploaded_file($tmp_name, $path);
    }
} else {
    echo "未登录或未经授权！";

}


?>