<?php
session_start();
require_once "smss_connect.php";	

if(isset($_SESSION['amssplus_sync'])){
echo "<iframe src='$_SESSION[amssplus_url]/logout2.php' height='0' width='0%'></iframe>";
$redirect=1;
}
else{
$redirect=0;
}

session_unset();
session_destroy();

if($redirect==1){
?>
<script type="text/JavaScript">
setTimeout("location.href = 'index.php';",2000);
</script>
<?php
}
else{
echo "<script>document.location.href='index.php';</script>\n";
}
?>