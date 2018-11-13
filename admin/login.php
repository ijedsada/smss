<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<head>
<title>ระบบสนับสนุนการบริหารจัดการสถานศึกษา [ ผู้ดูแลระบบ ]</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="css/pracharath-login.css" type="text/css" />
<script language="javascript" type="text/javascript">
	function setFocus() {
		document.loginForm.username.select();
		document.loginForm.username.focus();
	}
</script>
</head>
<body onLoad="setFocus();">
<!-- Div ของ login -->
<div class="app-title1"><img src="../images/BAN-PRACHARATH-SMSS-admin.png"></div>
<div id="ctr" align="center">
	<div class="login">
		<div class="login-form">
<?php
$sql = "select  * from system_school_name";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$schoolname=$result['school_name'];
?>
		<div class="app-title"><?php echo $schoolname;?></div>
        	<form action="index.php" method="post" name="loginForm" id="loginForm">
				<div class="login-form">
				<div class="control-group">
				<input type="text" class="login-field" value="" placeholder="ป้อนชื่อผู้ใช้" id="username" name="username">
				<label class="login-field-icon fui-user" for="login-name"></label></div>
				<div class="control-group">
				<input type="password" class="login-field" value="" placeholder="ป้อนรหัสผ่าน" id="pass" name="pass">
				<label class="login-field-icon fui-lock" for="login-pass"></label>
				</div>
				<br>
	        	<div align="left"><input type="submit" name="submit" class="btn btn-primary btn-large btn-block" value="เข้าสู่ระบบ" />
        	</div>
				</form>
		</div>

		<br>
		<div class="control-group2" align='center'>แนะนำให้ใช้บราวเซอร์ Google Chrome</div>
		<div class="control-group2">
			<p>ระบบสนับสนุนการบริหารจัดการสถานศึกษา<br>
School Management Support System : SMSS</p>
    		</div>
	<div class="clr"></div>
	</div>
</div>
<!-- จบ Login -->

<noscript>
!Warning! Javascript must be enabled for proper operation of the Administrator
</noscript>
</body>
</html>