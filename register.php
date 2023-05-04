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
    color:white;
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
if ($rows) { //0 false 1h1 true
    echo "<h2>注册失败！用户名已被注册</h2>";
    echo "
                    <script>
                            setTimeout(function(){window.location.href='register.html';},1000);
                    </script>

                ";
} else {
    $q = "insert into user(username_base64,pwd_sha256) values ('$name','$password')"; //向数据库插入表单传来的值的sql
    $reslut = mysqli_query($con, $q); //执行sql
    mysqli_query($con, "create table `$name` (`file_id` INT auto_increment not null primary key,`hash_sha256` char(64) not null,`filename` varchar(255) not null);");
    echo "<h1>注册成功</h1> <a href=\"index.html\">回到首页</a>"; //成功输出注册成功
}


mysqli_close($con); //关闭数据库

?>