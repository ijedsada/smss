<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if(!isset($_SESSION['amssplus_sync'])){
$_SESSION['amssplus_sync']=1;
}

echo "<iframe src='$_SESSION[amssplus_url]/smss_index.php' height='700' width='100%'></iframe>";

?>