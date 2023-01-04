<?php
session_start();
/*
*版权信息请勿修改
*作者:阿豆子(QQ:1355967533)
*项目开始时间2020/5/2
*源码禁止商用
*/
if($_GET['id']=='upload'){
echo '<html><head><meta charset="utf-8"><link rel="icon" href="http://p.qlogo.cn/gh/952553758/952553758_1/0"><title>上传音频-音乐网盘</title></head><body>
<form action="?id=upload&ids=sc" method="post" enctype="multipart/form-data">
<p>请选择要上传的音频文件:<br><input type="file" name="myFile"></p>
<input type="submit" value="上传">
</form>
<br><a href="?">返回首页</a><br></body></html>';
if($_GET['ids']=='sc'){
$wenjian = $_FILES['myFile']['name'];
$lj = $_FILES['myFile']['tmp_name'];
date_default_timezone_set('Asia/Shanghai');
$time = date("Y年m月d日-H时i分s秒"); 
@copy($lj, 'music/'.base64_encode("[$time]".$wenjian));
}
}else if($_GET['id']=='music'){
$ml=dirname(__FILE__).'/music'; 
$musics = scandir($ml);
if($_GET['ids']=='bf'){
echo '<html><head><meta charset="utf-8"><link rel="icon" href="http://p.qlogo.cn/gh/952553758/952553758_1/0"><title>查看文件-音乐网盘</title></head><body>';
echo '
<audio controls="controls">
  <source src="'.'music/'.$_GET['musicid'].'" type="audio/mpeg">
  <source src="'.'music/'.$_GET['musicid'].'" type="audio/ogg">
Your browser does not support the audio element.
</audio>
';
}
foreach ($musics as $music) {
if($music=='.' or $music=='..'){
}else{
 
echo "<hr>".base64_decode($music)."｜<a href=".'"'."?id=music&ids=bf&musicid=$music".'"'.'>播放</a> <a href='.'"'."?id=delete&delete=$music".'"'.'>删除</a>';
}
}
echo '<br><a href="?">返回首页</a><br>';
}else if($_GET['id']=='admin'){
if($_SESSION['身份认证']=='ture'){
echo '<html><head><meta charset="utf-8"><link rel="icon" href="http://p.qlogo.cn/gh/952553758/952553758_1/0"><title>您已登陆过</title></head><body><br>登陆状态：已登陆<br></body></html>';
}else{
echo '<html><head><meta charset="utf-8"><link rel="icon" href="http://p.qlogo.cn/gh/952553758/952553758_1/0"><title>管理员登陆-音乐网盘</title></head><body>
<form name="form" method="post" action="?id=admin&admin=login">
<p>管理员账号：<input type="text" name="username" required placeholder="管理员账号"></p>
<p>管理员密码：<input type="passwordr" name="password" required placeholder="管理员密码"></p>
<input type="submit" value="提交">
</form>';
if($_GET['admin']=='login'){
if( $_POST['username']=='adouzi' && $_POST['password']=='adouzi'){
$_SESSION['身份认证']='ture';
echo '<br>管理员登陆成功！<br>';
}else{
echo '<br>管理员登陆失败！<br>';
}
}
}
echo '<br><a href="?">返回首页</a><br></body></html>';
}else if($_GET['id']=='delete'){
echo '<html><head><meta charset="utf-8"><link rel="icon" href="http://p.qlogo.cn/gh/952553758/952553758_1/0"><title>删除-音乐网盘</title></head><body>';
if($_SESSION['身份认证']=='ture'){
unlink('music/'.$_GET['delete']);
echo '<br>删除成功<br>';
}else{
echo '<br>你无权操作<br>';
}
echo '<a href="?">返回首页</a></body></html>';
}else if($_GET['id']=='xy'){
echo '
<html><head><meta charset="utf-8"><link rel="icon" href="http://p.qlogo.cn/gh/952553758/952553758_1/0"><title>用户协议-音乐网盘</title></head><body>
<h1>用户协议请自行编写(好吧，我承认是我懒)</h1>
<hr>
<h2>欢迎使用php音乐网盘</h2>
<p>您使用该网盘则默认您同意用户协议</p>
<hr><center><p>音乐网盘程序2.0<br>by 阿豆子</p></center>
</body></html>
';
}else{
echo '<html><head><meta charset="utf-8"><link rel="icon" href="http://p.qlogo.cn/gh/952553758/952553758_1/0"><title>音乐网盘-首页</title></head><body>
<h1>首页</h1><hr>
<a href="?id=upload">上传音频</a><br>
<a href="?id=music">查看音频</a><br>
<a href="?id=admin">管理后台</a><br>
<a href="?id=xy">用户协议</a><br>
</body></html>
';
}
?>