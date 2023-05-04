<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的文件</title>
    <link rel="shortcut icon" href="./imgs/icon.png" type="image/x-icon">  
    <link rel="stylesheet" href="css/reset.css">
    <style>
   html{
        background: linear-gradient(to left top,rgb(232, 236, 238),rgb(39, 180, 236));
        height: 100vh;
    } 
    .home{
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
    .home:hover{
    background-color: rgb(52, 201, 7);
    border:0.01vw rgb(52, 201, 7) solid;

    }
    h1,h2{
    color: white;
    font-size: 2vw;
    text-align: center;
    height: 10vw;
    line-height: 10vw;
    }
    h2{
        font-size: 1.5vw;
        color:rgb(250, 72, 72)
    }
    .title{
        margin-left: 1vw;
        margin-top: 1vw;
       display: flex;
    }
    .title img{
        width: 3vw;
        height: 3vw;
    }
    .titlemain{
        color: white;
        height: 3vw;
       line-height: 3vw;
       margin-left: 1vw;
    }
    .act{
        display: flex;
    }
    a{
        width: 8vw;
        height: 2vw;
        border:0.01vw solid white;
        line-height: 2vw;
        text-align: center;
        margin-left: 1vw;
        margin-top: 0.8vw;
        border-radius: 1vw;
        color: white;
    }
    a:hover{
    background-color: rgb(52, 201, 7);
    border:0.01vw rgb(52, 201, 7) solid;
    }
    .delete:hover{
    background-color: rgb(239, 76, 76);
    border: 1px rgb(239, 76, 76)  solid;
    }
    </style>
</head>

<body>
    <h1>文件管理</h1>

    <?php
    include("connect.php");
    if (isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] == true) {
        $username_base64 = base64_encode($_SESSION["username"]);
        $sql = "select * from $username_base64";
        $result = mysqli_query($con, $sql); //执行sql
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class=\"title\">
                <img src=\"./imgs/files.png\">   <div class=\"titlemain\">文件名：" . $row["filename"] . "</div>
                </div>
                <div class=\"act\">
                <a href=\"download.php?hash=" . $row["hash_sha256"] . "&user=" . $username_base64 . "&filename=" . $row["filename"] . "\">下载文件</a>
                <a href=\"delete.php?hash=" . $row["hash_sha256"] . "&user=" . $username_base64 . "\" class=\"delete\">删除文件</a>
                </div>";
            }

        } else {
            echo "<h2>你还没有上传文件</h2>";

        }



    } else {
        echo "<h2>你没有登录</h2>";
    }
    ?>
    <br /><a href="index.html" class="home">回到首页</a><br />
</body>

</html>