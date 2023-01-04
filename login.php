<?PHP
header("Content-Type: text/html; charset=utf8");
session_start();
if (!isset($_POST["submit"])) {
    exit("错误执行");
} //检测是否有submit操作 

include('connect.php'); //链接数据库
$name = base64_encode($_POST['name']); //post获得用户名表单值
$password = hash("sha256", $_POST['password']); //post获得用户密码单值

if ($name && $password) { //如果用户名和密码都不为空
    $sql = "select * from user where username_base64 = '$name' and pwd_sha256='$password'"; //检测数据库是否有对应的username和password的sql
    $result = mysqli_query($con, $sql); //执行sql
    $rows = mysqli_num_rows($result); //返回一个数值
    if ($rows) { //0 false 1 true
        if (base64_decode($name) == "admin") {
            $_SESSION["admin"] = true;
        }
        $_SESSION["isLogin"] = true;
        $_SESSION["username"] = base64_decode($name);
        header("refresh:0;url=welcome.html"); //如果成功跳转至welcome.html页面
        exit;
    } else {
        echo "用户名或密码错误";
        echo "
                    <script>
                            setTimeout(function(){window.location.href='login.html';},1000);
                    </script>

                "; //如果错误使用js 1秒后跳转到登录页面重试;
    }


} else { //如果用户名或密码有空
    echo "表单填写不完整";
    echo "
                      <script>
                            setTimeout(function(){window.location.href='login.html';},1000);
                      </script>";

    //如果错误使用js 1秒后跳转到登录页面重试;
}

mysqli_close($con); //关闭数据库
?>