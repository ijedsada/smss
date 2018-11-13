<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr bgcolor="#000033">
	<td height="40" colspan="6" class="logo" nowrap="nowrap">&nbsp;SMSS</td>
	</tr>
	<tr bgcolor="#26354A"><td colspan="6" align="center" class="tagline">
<?php	
echo $_SESSION['school_name'];
?>	
	</td></tr>
	<tr bgcolor="#26354A"><td colspan="6" align="right" class="user"><font color="#FFFFFF">
<?php 
if(isset($_SESSION['login_user_id'])){
echo "$_SESSION[login_name]&nbsp;$_SESSION[login_surname]";
		if($_SESSION['login_status']==5){
		echo "<script>alert('การ Login ด้วยเลขประจำตัวประชาชน เพื่อไปกำหนด Username และ Password กรุณาไปที่หน้าเว็บปกติ [SMSS for Desktop]');</script>\n";
		}
echo "&nbsp;&nbsp;";
echo "<a href=logout.php>[ออก]</a>";
}
?>
 </font></td></tr>
	
<?php 	
################การแจ้งเตือน
if(isset($alert)){	
if(($alert==1) and ($_SESSION['login_status']<5)){
?>
	<link rel="stylesheet" href="./jquery/themes/ui-lightness/jquery.ui.all.css">
	<script src="./jquery/jquery-1.5.1.js"></script>
	<script src="./jquery/external/jquery.bgiframe-2.1.2.js"></script>
	<script src="./jquery/ui/jquery.ui.core.js"></script>
	<script src="./jquery/ui/jquery.ui.widget.js"></script>
	<script src="./jquery/ui/jquery.ui.mouse.js"></script>
	<script src="./jquery/ui/jquery.ui.draggable.js"></script>
	<script src="./jquery/ui/jquery.ui.position.js"></script>
	<script src="./jquery/ui/jquery.ui.resizable.js"></script>
	<script src="./jquery/ui/jquery.ui.dialog.js"></script>

	<script>
	// increase the default animation speed to exaggerate the effect
	$.fx.speeds._default = 300;
	$(function() {
		$( "#dialog" ).dialog({
			height: 400,
			width: 320,
			minHeight: 400,
			minWidth: 320,
			autoOpen: true,
			show: "blind",
			hide: "explode",
				modal: true,
				resizable: false});
		});
	</script>
<div id="dialog" title="การแจ้งเตือน">
<?php 
$arr_length=count($system_alert_ar);
if($arr_length>=1){
		$M=1;
		for($x=1;$x<=$arr_length;$x++){			
					if(($M%2) == 0)
					$color="#E5E5FF";
					else  	$color="#FFFFFF";
		echo "<font  size=2>$M. $system_alert_ar[$x]</font><br />";
		$M++;
		}		
}
else{
echo "<div align='center'>";
			echo "<font color='#006666' size='3'><strong>ไม่มีข้อความแจ้งเตือน</strong>";			
echo "</div>";
}
?>
</div>
<?php		
}
}
################สิ้นสุดการแจ้งเตือน
	if($_GET['option']!=""){
	echo "<tr bgcolor='#FFCC00'>";
	echo "<td colspan='6'>";
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr bgcolor='#6699FF'>";
	echo "<td align='left' nowrap='nowrap' class=stylemenu height='24'>&nbsp;&nbsp;&nbsp;";
	echo $_SESSION['module_name_'.$_GET['option']];
	echo "</td><td align='right'>";
	echo "<span id='Aclock' ></span>";
	echo "&nbsp;&nbsp;&nbsp;";
date_default_timezone_set('Asia/Bangkok');
	echo "</td></tr>";
	echo "</table>";
	echo "</td></tr>";
	}
	else{
	require_once("menu_mobile.php");
	}
	  ?>
	<tr>
	<td colspan="6">
	<!-- Content -->
	
		<?php require_once("".$MODPATHFILE."");?>
	
	<!-- End Content -->
	</td>
	</tr>
</table>
