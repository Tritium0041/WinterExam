<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>我的文件</title>
</head>

<body>
    <h1>文件管理</h1>
    <hr />

    <?php
    include("connect.php");
    if (isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] == true) {
        $username_base64 = base64_encode($_SESSION["username"]);
        $sql = "select * from $username_base64";
        $result = mysqli_query($con, $sql); //执行sql
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>文件名：" . $row["filename"] . "</p><a href=\"download.php?hash=" . $row["hash_sha256"] . "&user=" . $username_base64 . "&filename=" . $row["filename"] . "\">下载文件</a><a href=\"delete.php?hash=" . $row["hash_sha256"] . "&user=" . $username_base64 . "\">删除文件</a>
                <hr />";

            }

        } else {
            echo "<p>你还没有上传文件</p>
            <hr />";

        }



    } else {
        echo "<h1>你没有登录！</h1>
        <hr />";
    }
    ?>
    <br /><a href="index.html">回到首页</a><br />
</body>

</html>