<?php
if(isset($_GET['index'])){
$index=$_GET['index'];
}else{
	$index="";
}
$module_file_path="./modules/amssplus/main/iframe.php";
require_once("$module_file_path");
?>

