<?php
$hostname="localhost";
$user="user";
$password="password";
$dbname="dbname";
$system_office_code="xxxx";     //รหัสสถานศึกษา
$connect=mysqli_connect($hostname,$user,$password,$dbname) or die("Could not connect MySql");
mysqli_query($connect,"SET NAMES utf8");
?> 
