<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>หน่วยงานใช้ข้อมูล</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>เพิ่มข้อมูล</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='60%' Border='0'>";
echo "<Tr><Td align='right' width='50%'>ชื่อหน่วยงานผู้ขอข้อมูล(ไทย)&nbsp;&nbsp;</Td><Td align='left' width='50%'><Input Type='Text' Name='thai_requester' Size='30'></Td></Tr>";
echo "<Tr><Td align='right' width='50%'>ip ของเครื่องComputer&nbsp;&nbsp;</Td><Td align='left' width='50%'><Input Type='Text' Name='requester_server_id' Size='20'> *ว่างไว้ได้ จะหมายถึงเครื่องใดก็ได้</Td></Tr>";
echo "<Tr><Td align='right' width='50%'>Username(English)&nbsp;&nbsp;</Td><Td align='left' width='50%'><Input Type='Text' Name='requester' Size='20'></Td></Tr>";
echo "<Tr><Td align='right' width='50%'>Password&nbsp;&nbsp;</Td><Td align='left' width='50%'><Input Type='Text' Name='requester_password' Size='20'></Td></Tr>";
echo "<tr><td align='right'>อนุญาต&nbsp;&nbsp;</td>";
echo "<td align='left'>ใช่<input  type='radio' name='status' value='1' checked>&nbsp;&nbsp;ไม่ใช่<input  type='radio' name='status' value='0'></td></tr>";

//option
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>รายการ</B>: &nbsp;</legend>";
echo "<table>";
$sql = "select * from system_export_list order by id";
$dbquery = mysqli_query($connect,$sql);
$N=1;
While($result = mysqli_fetch_array($dbquery)){
echo"<tr><td>&nbsp;&nbsp;&nbsp;&nbsp</td><td align='left'>$N $result[thai_dataname]</td><td align='left'>&nbsp;&nbsp;อนุญาต&nbsp;&nbsp;</td>";
echo "<td align='left'>ใช่<input type='radio' name='permission$result[data_name]' value='1' checked>&nbsp;&nbsp;ไม่ใช่<input type='radio' name='permission$result[data_name]' value='0'></td></tr>";
echo "<Input Type=Hidden Name='data_name[$N]' Value='$result[data_name]'>";
$N++;
}
echo "</table>";
echo "</fieldset>";
echo "</td></tr>";
//end option

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
	&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?file=data_requester&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?file=data_requester&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "select * from system_export_requester where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

$sql = "delete from system_export_permission where requester='$ref_result[requester]'";
$dbquery = mysqli_query($connect,$sql);
$sql = "delete from system_export_requester where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into system_export_requester(requester,thai_requester,requester_server_id,requester_password,status,rec_date,officer) values ('$_POST[requester]','$_POST[thai_requester]','$_POST[requester_server_id]','$_POST[requester_password]','$_POST[status]','$rec_date','$_SESSION[login_user_id]')";
$dbquery = mysqli_query($connect,$sql);
	for($i=1;$i<=count($_POST['data_name']);$i++){
	$data_name=$_POST['data_name'][$i];
	$status="permission".$data_name;
	$sql = "insert into system_export_permission(requester,data_name,status) values ('$_POST[requester]','$data_name','$_POST[$status]')";
	$dbquery = mysqli_query($connect,$sql);
	}
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>แก้ไข</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0'>";

$sql = "select * from system_export_requester where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo "<Tr><Td align='right' width='50%'>ชื่อหน่วยงานผู้ใช้ข้อมูล&nbsp;&nbsp;</Td><Td align='left' width='50%'>$ref_result[thai_requester]</Td></Tr>";
echo "<Tr><Td align='right' width='50%'>Username(English)&nbsp;&nbsp;</Td><Td align='left' width='50%'>$ref_result[requester]</Td></Tr>";

if($ref_result['status']==1){
$check1="checked";
$check2="";
}
else{
$check1="";
$check2="checked";
}
echo "<tr><td align='right'>อนุญาต&nbsp;&nbsp;</td>";
echo "<td align='left'>ใช่<input  type='radio' name='status' value='1' $check1>&nbsp;&nbsp;ไม่ใช่<input  type='radio' name='status' value='0' $check2></td></tr>";

//option
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>รายการ</B>: &nbsp;</legend>";
echo "<table>";

$sql = "select * from system_export_list order by id ";
$dbquery = mysqli_query($connect,$sql);
$N=1;
While($result = mysqli_fetch_array($dbquery)){

		$sql2 = "select * from system_export_permission where requester='$ref_result[requester]' and data_name='$result[data_name]' and status='1'";
		$dbquery2 = mysqli_query($connect,$sql2);
		$row_num=mysqli_num_rows($dbquery2);

		if($row_num>=1){
		$check1="checked";
		$check2="";
		}
		else{
		$check1="";
		$check2="checked";
		}

echo"<tr><td>&nbsp;&nbsp;&nbsp;&nbsp</td><td align='left'>$N $result[thai_dataname]</td><td align='left'>&nbsp;&nbsp;อนุญาต&nbsp;&nbsp;</td>";
echo "<td align='left'>ใช่<input type='radio' name='permission$result[data_name]' value='1' $check1>&nbsp;&nbsp;ไม่ใช่<input type='radio' name='permission$result[data_name]' value='0' $check2></td></tr>";
echo "<Input Type=Hidden Name='data_name[$N]' Value='$result[data_name]'>";
$N++;
}
echo "</table>";
echo "</fieldset>";
echo "</td></tr>";
//end option

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='requester' Value='$ref_result[requester]'>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if($index==6){
$rec_date = date("Y-m-d");
$sql = "update system_export_requester set 
status='$_POST[status]', 
rec_date='$rec_date', 
officer='$_SESSION[login_user_id]' 
where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);

	for($i=1;$i<=count($_POST['data_name']);$i++){
	$data_name=$_POST['data_name'][$i];
	$status="permission".$data_name;

		//ตรวจการมีรายการอยู่
		$sql2 = "select * from system_export_permission where requester='$_POST[requester]' and data_name='$data_name'";
		$dbquery2 = mysqli_query($connect,$sql2);
		$row_num=mysqli_num_rows($dbquery2);

		if($row_num>=1){
		$sql = "update system_export_permission set 
		status='$_POST[$status]'
		where requester='$_POST[requester]' and data_name='$data_name'";
		$dbquery = mysqli_query($connect,$sql);
		}
		else{
		$sql = "insert into system_export_permission(requester,data_name,status) values ('$_POST[requester]','$data_name','$_POST[$status]')";
		$dbquery = mysqli_query($connect,$sql);
		}
	}
}


//ส่วนแสดงรายละเอียด
if ($index==7){
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>รายละเอียด</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='65%' Border= '0'>";
echo "<Tr ><Td colspan='2' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?file=data_requester&page=$_GET[page]\"'></Td></Tr>";
$sql = "select * from system_export_requester where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo "<Tr><Td align='right' width='50%'>ชื่อหน่วยงาน&nbsp;&nbsp;</Td><Td align='left' width='50%'><Input Type='Text' Name='thai_requester' Size='30' value='$ref_result[thai_requester]' readonly></Td></Tr>";
echo "<Tr><Td align='right' width='50%'>Username&nbsp;&nbsp;</Td><Td align='left' width='50%'><Input Type='Text' Name='requester' Size='20' value='$ref_result[requester]' readonly></Td></Tr>";

if($ref_result['status']==1){
$check1="checked";
$check2="";
}
else{
$check1="";
$check2="checked";
}
echo "<tr><td align='right'>อนุญาต&nbsp;&nbsp;</td>";
echo "<td align='left'>ใช่<input  type='radio' name='status' value='1' $check1>&nbsp;&nbsp;ไม่ใช่<input  type='radio' name='status' value='0' $check2></td></tr>";

//option
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>รายการ</B>: &nbsp;</legend>";
echo "<table>";
$sql = "select * from system_export_permission left join system_export_list on system_export_permission.data_name=system_export_list.data_name where system_export_permission.requester='$ref_result[requester]' order by system_export_list.id";
$dbquery = mysqli_query($connect,$sql);
$N=1;
While($result = mysqli_fetch_array($dbquery)){

	if($result['status']==1){
	$check1="checked";
	$check2="";
	}
	else{
	$check1="";
	$check2="checked";
	}

echo"<tr><td>&nbsp;&nbsp;&nbsp;&nbsp</td><td align='left'>$N $result[thai_dataname]</td><td align='left'>&nbsp;&nbsp;อนุญาต&nbsp;&nbsp;</td>";
echo "<td align='left'>ใช่<input type='radio' name='permission$result[data_name]' value='1' $check1>&nbsp;&nbsp;ไม่ใช่<input type='radio' name='permission$result[data_name]' value='0' $check2></td></tr>";
$N++;
}
echo "</table>";
echo "</fieldset>";
echo "</td></tr>";
//end option

echo "</Table>";
}


//ส่วนปรับปรุงการอนุญาต
if ($index==8){
	if($_GET['status']==1){
	$status=0;
	}
	else{
	$status=1;
	}
$sql = "update system_export_requester set status='$status' where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
}


//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7))){

	//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="file=data_requester";  // 2_กำหนดลิงค์
$sql = "select * from system_export_requester"; // 3_กำหนด sql

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );  
$totalpages=ceil($num_rows/$pagelen);

if(isset($_REQUEST['page']))
	{
	$page=$_REQUEST['page'];
	}else{$page="";}

	if($page==""){
	$page=$totalpages;
			if($page<2){
			$page=1;
			}
	}
	else{
			if($totalpages<$_REQUEST['page']){
			$page=$totalpages;
						if($page<1){
						$page=1;
						}
			}
			else{
			$page=$_REQUEST['page'];
			}
	}

	$start=($page-1)*$pagelen;

	if(($totalpages>1) and ($totalpages<16)){
	echo "<div align=center>";
	echo "หน้า	";
				for($i=1; $i<=$totalpages; $i++)	{
						if($i==$page){
						echo "[<b><font size=+1 color=#990000>$i</font></b>]";
						}
						else {
						echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
						}
				}
	echo "</div>";
	}			
	if($totalpages>15){
				if($page <=8){
				$e_page=15;
				$s_page=1;
				}
				if($page>8){
						if($totalpages-$page>=7){
						$e_page=$page+7;
						$s_page=$page-7;
						}
						else{
						$e_page=$totalpages;
						$s_page=$totalpages-15;
						}
				}
				echo "<div align=center>";
				if($page!=1){
				$f_page1=$page-1;
				echo "<<a href=$PHP_SELF?$url_link&page=1>หน้าแรก </a>";
				echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>หน้าก่อน </a>";
				}
				else {
				echo "หน้า	";
				}					
				for($i=$s_page; $i<=$e_page; $i++){
						if($i==$page){
						echo "[<b><font size=+1 color=#990000>$i</font></b>]";
						}
						else {
						echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
						}
				}
				if($page<$totalpages)	{
				$f_page2=$page+1;
				echo "<a href=$PHP_SELF?$url_link&page=$f_page2> หน้าถัดไป</a>>>";
				echo "<a href=$PHP_SELF?$url_link&page=$totalpages> หน้าสุดท้าย</a>>";
				}
				echo " <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
				echo "<option  value=\"\">หน้า</option>";
					for($p=1;$p<=$totalpages;$p++){
					echo "<option  value=\"?$url_link&page=$p\">$p</option>";
					}
				echo "</select>";
	echo "</div>";  
	}					
	//จบแยกหน้า

	echo "<br>";
	$sql = "select * from system_export_requester order by id limit $start,$pagelen";
	$dbquery = mysqli_query($connect,$sql);
	echo  "<table width='60%' border='1' align='center' style='border-collapse: collapse'>";
	echo "<Tr bgcolor='#E6E6E6'><Td  align='center' width='50'>ที่</Td><Td align='center'>ชื่อ</Td><Td  align='center' width='50'>การ<br>อนุญาต</Td><Td align='center' width='50'>ราย<br>ละเอียด</Td><Td align='center' width='50'>แก้ไข</Td></Tr>";

	$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
	$M=1;

	While ($result = mysqli_fetch_array($dbquery))
		{
			$id = $result['id'];
			$requester= $result['requester'];
			$thai_requester = $result['thai_requester'];
			$requester_server_id= $result['requester_server_id'];
			$status= $result['status'];
			
			if($status==1){
			$active_pic="<img src=../images/yes.png border='0'>";
			}
			else{
			$active_pic="<img src=../images/no.png border='0'>";
			}
			if(($M%2) == 0)
				$color="#FFFFC";
				else  	$color="#FFFFFF";
			echo "<Tr bgcolor=$color><Td align='center'>$N</Td><Td align='left'>$thai_requester ($requester)</Td><Td align='center'><a href=?file=data_requester&index=8&id=$id&status=$status&page=$page>$active_pic</a></Td>";
			
			echo "<Td align='center'><a href=?file=data_requester&index=7&id=$id&page=$page><img src=../images/b_browse.png border='0' alt='รายละเอียด'></a></Td>";
			
			echo "<Td align='center'><a href=?file=data_requester&index=5&id=$id&page=$page><img src=../images/edit.png border='0' alt='แก้ไข'></a></Td>
		</Tr>";
	$M++;
	$N++;  //*เกี่ยวข้องกับการแยกหน้า
		}
	echo "</Table>";
	}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?file=data_requester");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.thai_requester.value==""){
		alert("กรุณากรอกชื่อหน่วยงานเป็นภาษาไทย");
		}else if(frm1.requester.value == ""){
		alert("Username");
		}else if(frm1.requester_password.value==""){
		alert("กรุณากรอกPassword");
		}else{
		callfrm("?file=data_requester&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?file=data_requester");   // page ย้อนกลับ 
	}else if(val==1){
		callfrm("?file=data_requester&index=6");   //page ประมวลผล
	}
}
</script>
