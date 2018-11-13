<?php
/** ensure this file is being included by a parent file */
//defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$user_agent = $_SERVER['HTTP_USER_AGENT'];
function getOS() {
    global $user_agent;
    $os_platform    =   "desktop";
    $os_array       =   array(
							'/windows nt 10.0/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
				if(($os_platform=='Android') or ($os_platform=='BlackBerry') or ($os_platform=='iPhone') or ($os_platform=='iPad')){
				$os_platform="mobile";
				}
				else{
				$os_platform="desktop";
				}
        }
    }
    return $os_platform;
}
$user_os = getOS();

$sql = "select  * from system_school_name";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$schoolname=$result['school_name'];

include "version.php";

?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name = "viewport" content = "width = device-width">
  <title>ระบบสนับสนุนการบริหารจัดการสถานศึกษา (S M S S) [Flat Login Form 3.0]</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="css/style.css">

<script language="javascript" type="text/javascript">
	function setFocus() {
		document.loginForm.username.select();
		document.loginForm.username.focus();
	}
</script>
</head>

<body onLoad="setFocus();">

<!-- Form Mixin-->
<!-- Input Mixin-->
<!-- Button Mixin-->
<!-- Pen Title-->
<div class="pen-title">
  <h1>S M S S</h1>
  <span>ระบบสนับสนุนการบริหารจัดการสถานศึกษา<br />
    School Management Support System v.<?php echo $code_version;?></span>
</div>
<!-- Form Module-->
<div class="module form-module">
  <div class="toggle"><i class="fa fa-times fa-pencil"></i>
    <div class="tooltip">Click Me</div>
  </div>
  <div class="form">
	<h2><?php echo $schoolname;?></h2>
    <h2>Login to your account</h2>
    <form action="index.php" method="post" name="loginForm" id="loginForm">
		<input type="text" placeholder="ป้อนชื่อผู้ใช้" id="username" name="username"/>
		<input type="password" placeholder="ป้อนรหัสผ่าน" id="pass" name="pass"/>
		<!--input id="remember_me" name="remember_me" value="remember-me" type="checkbox" />
		<label for="remember_me">คลิ๊กเพื่อจดจำรหัสผ่าน</label-->
		<input name="user_os" type="hidden" value="<?php echo $user_os ?>">
		<!--button>Login</button-->
		<input name="user_os" type="hidden" value="<?php echo $user_os ?>">
		<input type="submit" name="login_submit" class="button" value="Login" />
    </form>
  </div>
<div class="cta">แนะนำให้ใช้บราวเซอร์ Google Chrome</div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>


    <script src="js/index.js"></script>
<!-- จบ Login -->
<noscript>
!Warning! Javascript must be enabled for proper operation of the Administrator
</noscript>
</body>
</html>
