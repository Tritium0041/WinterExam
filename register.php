<?php
header("Content-Type: text/html; charset=utf8");

if (!isset($_POST['submit'])) {
    exit("错误执行");
} //判断是否有submit操作

include('connect.php'); //链接数据库
$name = base64_encode($_POST['name']); //post获得用户名表单值
$password = hash("sha256", $_POST['password']); //post获得用户密码单值


$sql = "select * from user where username_base64 = '$name'"; //检测数据库是否有对应的username和password的sql
$result = mysqli_query($con, $sql); //执行sql
$rows = mysqli_num_rows($result); //返回一个数值
if ($rows) { //0 false 1 true
    echo "注册失败！用户名已被注册";
    echo "
                    <script>
                            setTimeout(function(){window.location.href='register.html';},1000);
                    </script>

                ";
} else {
    $q = "insert into user(username_base64,pwd_sha256) values ('$name','$password')"; //向数据库插入表单传来的值的sql
    $reslut = mysqli_query($con, $q); //执行sql
    mysqli_query($con, "create table `$name` (`file_id` INT auto_increment not null primary key,`hash-sha256` char(64) not null,`filename` varchar(100) not null);");
    echo "注册成功"; //成功输出注册成功
}


mysqli_close($con); //关闭数据库

?>