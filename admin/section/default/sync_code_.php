<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
error_reporting(0);

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รหัสเชื่อมระบบ เพื่อเชื่อมกับระบบอื่น ๆ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>เพิ่มข้อมูล</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0'>";
echo "<Tr><Td align='right'><b>รหัสโรงเรียน</b>&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='office_code' Size='30' maxlength='50' value='$system_office_code' readonly>&nbsp;* (รหัสจาก system_office_code)</Td></Tr>";
echo "<Tr><Td align='right'><b>ชื่อระบบที่จะเชื่อม</b>&nbsp;&nbsp;</Td><Td align='left'><Select name='system_name' size='1'>";
echo  "<option value ='amssplus'>AMSS++</option>" ;
echo "</select>";
echo "</Td></Tr>";
echo "<Tr><Td align='right'><b>รหัสเชื่อมระบบ</b>&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='sync_code' Size='30' maxlength='50'></Td></Tr>";
echo "<Tr><Td align='right'><b>URL ของระบบที่จะเชื่อม</b>&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='url' Size='50' maxlength='50'></Td></Tr>";
echo "<tr><td align='right'></td>";
echo "<td align='left'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
	&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='700' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>การลบรายการ จะทำให้ไม่สามารถเพิ่มรายการได้อีก จนกว่าจะลบทางฝั่ง AMSS++ ด้วย</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?file=sync_code&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?file=sync_code\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from system_sync_code where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){

$server = $_SERVER["SERVER_ADDR"]; 
$server_addr=$_SERVER["SERVER_ADDR"];  
$script_name=$_SERVER["SCRIPT_NAME"];
$script_path=explode("admin",$script_name);  
$smss_path="http://$server_addr$script_path[0]"; 

$office_code=$_POST['office_code'];
$sync_code=md5($_POST['sync_code']);
$url=$_POST['url'];
$person=$_SESSION['login_user_id'];

$time="";
$url2 ="$_POST[url]/smss/time_alert.php?serv=$server"; 
$xmlDoc = new DOMDocument();
$xmlDoc->load($url2);
$time=$xmlDoc->getElementsByTagName('time')->item(0)->nodeValue;
		
			if($time!=""){
							$url3 ="$_POST[url]/smss/insert_sync.php?office_code=$office_code&sync_code=$sync_code&url=$url&server=$server&smss_path=$smss_path&person=$person&time2=$time";   
							$xmlDoc2 = new DOMDocument();
							$xmlDoc2->load($url3);
							$status=$xmlDoc2->getElementsByTagName('status')->item(0)->nodeValue; 
							if($status==0){
							$sql = "delete from system_sync_code where  office_code='$_POST[office_code]'";
							$dbquery = mysqli_query($connect,$sql);
							
							$sql = "insert into system_sync_code (office_code, system_name,sync_code,amssplus_url) values ('$_POST[office_code]', '$_POST[system_name]','$_POST[sync_code]','$_POST[url]')";
							$dbquery = mysqli_query($connect,$sql); 
							}
							else{
										if($status==1){
										echo "<div align='center'><b><font color='#ff3333'>ไม่มีรายชื่อโรงเรียนอยู่ในบัญชีที่อนุญาตให้เชื่อมระบบ AMSS++</font></b></div>";
										}
										else if($status==2){
										echo "<div align='center'><b><font color='#ff3333'>มีการกำหนดรหัสเชื่อมต่อแล้ว  หากจะเปลี่ยนแปลงแก้ไขแจ้งผู้ดูแลระบบ AMSS++</font></b></div>";
										}
							}
			}
			else{
			echo "<div align='center'><b><font color='#ff3333'>URL ของ AMSS++ ไม่ถูกต้อง ไม่สามารถเชื่อมระบบได้  ลองใหม่อีกครั้ง</font></b></div>";
			}
}


//ส่วนแสดงผล
if(!($index==1 or $index==2)){
echo  "<table width='70%' border='0' align='center'>";
echo "<Tr><Td align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?file=sync_code&index=1\"'</Td></Tr>";
echo "</Table>";
echo  "<table width='70%' border='1' align='center' style='border-collapse: collapse'>";
$sql = "select  * from system_sync_code order by id";
$dbquery = mysqli_query($connect,$sql);
$N=1;
echo "<Tr bgcolor='#E6E6E6'><Td align='center' width='50'>ที่</Td><Td align='center'>ชื่อระบบที่เชื่อม</Td><Td align='center'>รหัสโรงเรียน</Td><Td align='center'>รหัสเชื่อมระบบ</Td><Td align='center'>URL ของระบบที่เชื่อม</Td><Td align='center' width='50'>ลบ</Td></Tr>";
while($result = mysqli_fetch_array($dbquery)){
$id=$result['id'];
echo "<Tr><Td align='center'>$N</Td><Td align='left'>$result[system_name]</Td><Td align='center'>$result[office_code]</Td><Td align='left'>$result[sync_code]</Td><Td align='left'>$result[amssplus_url]</Td><Td align='center'><a href=?file=sync_code&index=2&id=$id><img src=../images/drop.png border='0' alt='ลบ'></a></Td>
	</Tr>";
$N++;	
}	
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?file=sync_code");   
	}else if(val==1){
		if(frm1.sync_code.value == ""){
			alert("กรุณากรอกรหัสเชื่อมระบบ");
		}else if(frm1.url.value == ""){
		alert("กรุณากรอกURL");
		}else{
			callfrm("?file=sync_code&index=4"); 
		}
	}
}

</script>
