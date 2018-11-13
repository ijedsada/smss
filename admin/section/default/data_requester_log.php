<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

function thai_date_4($date){
		if(!(isset($date))){
		return;
		}
$thai_month_arr=array(
	"01"=>"มค",
	"02"=>"กพ",
	"03"=>"มีค",
	"04"=>"เมย",
	"05"=>"พค",
	"06"=>"มิย",	
	"07"=>"กค",
	"08"=>"สค",
	"09"=>"กย",
	"10"=>"ตค",
	"11"=>"พย",
	"12"=>"ธค"					
);
	$f_date_2=explode(" ", $date);
	$f_date=explode("-", $f_date_2[0]);
	$f_date[2]=intval($f_date[2]);
	$thai_date_return="";
	$thai_date_return.=	$f_date[2];
	$thai_date_return.= " ".$thai_month_arr[$f_date[1]]." ";
	$thai_date_return.=	$f_date[0]+543;
	$thai_date_return.=	" ".$f_date_2[1]." น.";
	if($date!=""){
	return $thai_date_return;
	}
	else{
	$thai_date_return="";
	return $thai_date_return;
	}
}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายงานการให้บริการข้อมูลของSMSS</strong></font></td></tr>";
echo "</table>";
}


//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?file=data_requester_log&index=3\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?file=data_requester_log\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from system_export_log";
$dbquery = mysqli_query($connect,$sql);
}


//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7))){

	//ส่วนของการแยกหน้า
$pagelen=50;  // 1_กำหนดแถวต่อหน้า
$url_link="file=data_requester_log";  // 2_กำหนดลิงค์
$sql = "select * from system_export_log"; // 3_กำหนด sql

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery);  
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

	echo  "<table width='65%' border='0' align='center'>";
	echo "<Tr><Td colspan='7' align='left'><INPUT TYPE='button' name='smb' value='ลบข้อมูลทั้งหมด' onclick='location.href=\"?file=data_requester_log&index=2\"'</Td></Tr>";
	echo "</Table>";
	echo  "<table width='65%' border='1' align='center' style='border-collapse: collapse'>";
	echo "<Tr bgcolor='#E6E6E6'><Td align='center' width='50'>ที่</Td><Td align='center' width='150'>วัน เวลา</Td><Td align='center'>ชื่อ (Username)</Td><Td align='center' width='150'>computer ip</Td><Td align='center' width='200'>ข้อมูล</Td></Tr>";
	
	$sql = "select * from system_export_log left join system_export_requester on system_export_log.requester=system_export_requester.requester left join system_export_list on system_export_log.data=	system_export_list.data_name order by system_export_log.id limit $start,$pagelen";
	$dbquery = mysqli_query($connect,$sql);

	$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
	$M=1;

	While ($result = mysqli_fetch_array($dbquery))
		{
			$id = $result['id'];
			$computer_ip= $result['computer_ip'];
			$thai_requester = $result['thai_requester'];
			$login_time= $result['login_time'];
			$thai_dataname= $result['thai_dataname'];
			
			if(($M%2) == 0)
				$color="#FFFFC";
				else  	$color="#FFFFFF";
			echo "<Tr bgcolor=$color><Td align='center'>$N</Td><Td align='left'>";
			echo thai_date_4($login_time);
			echo "</Td><Td align='left'>$thai_requester</Td><Td align='left'>$computer_ip</Td><Td align='left'>$thai_dataname</Td>";
		echo "</Tr>";
	$M++;
	$N++;  //*เกี่ยวข้องกับการแยกหน้า
		}
	echo "</Table>";
	}
	

?>
