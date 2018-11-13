<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
date_default_timezone_set('Asia/Bangkok');
$alert=0;
$system_alert_num=0;
$alert_content="";
$system_alert_ar = array();

//** start alert for teacher
if($_SESSION['login_status']<=4){

//หาผู้อำนวยการโรงเรียน
$sql = "select * from person_main where position_code='1' and status='0' order by id desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$boss='';
if($dbquery){ 
$result = mysqli_fetch_array($dbquery);
$boss=$result['person_id'];
}

//หาผู้รักษาราชการแทน
$today=date("Y-m-d");
$sql = "select * from delegate_main where person_id='$_SESSION[login_user_id]' and start<='$today' and finish>='$today' ";
$dbquery = mysqli_query($connect,$sql);
$delegate=0;
if($dbquery){
$num_rows = mysqli_num_rows($dbquery);
	if($num_rows>=1){
	$delegate=1;
	}
}

//เวลาของการเตือนภายใน 15 วัน
$now=time();
$time_ago=$now-1296000;
$alert_dayago=date("Y-m-d H:i:s",$time_ago);

//เตือนขออนุญาตไปราชการรอความเห็นชอบ
$sql_permission_alert = "select permission_main.id from permission_main left join permission_person_set on  permission_main.person_id=permission_person_set.person_id where (permission_person_set.comment_person ='$_SESSION[login_user_id]') and (permission_main.grant_x is null) and (permission_main.comment_person is null)";
$dbquery_permission_alert = mysqli_query($connect,$sql_permission_alert);
if($dbquery_permission_alert){
		$permission_alert_num=mysqli_num_rows($dbquery_permission_alert);	
		if($permission_alert_num>=1){
		$alert=1;
		$system_alert_num=$system_alert_num+1;
		$alert_content="<a href='?option=permission&task=main/basic_comment'>มีผู้ขออนุญาตไปราชการรอความเห็นชอบ</a>";
		$system_alert_ar[$system_alert_num]=$alert_content;
		}
}

$now=time();
$time_onedayago=$now-86400;
$onedayago=date("Y-m-d H:i:s",$time_onedayago); // ใช้กับalert ขออนุญาตไปราชการและการลา

if($delegate==1){
			//เตือนอนุญาตไปราชการรออนุมัติ กรณีรักษาราชการแทน
			$sql_permission_alert2 = "select permission_main.id from permission_main left join permission_person_set on  permission_main.person_id=permission_person_set.person_id where (permission_main.grant_person_selected ='$_SESSION[login_user_id]' or permission_person_set.grant_person ='$_SESSION[login_user_id]' or permission_main.grant_person_selected='$boss' or permission_person_set.grant_person='$boss') and (permission_main.rec_date<'$onedayago' or permission_person_set.comment_person is null or permission_person_set.comment_person='' or permission_main.no_comment='1' or permission_main.comment_person is not null) and (permission_main.grant_person is null)";
			$dbquery_permission_alert2 = mysqli_query($connect,$sql_permission_alert2);
			$permission_alert2_num=""; //กำหนดตัวแปร
			if($dbquery_permission_alert2){
					$permission_alert2_num=mysqli_num_rows($dbquery_permission_alert2);	
					if($permission_alert2_num>=1){
					$alert=1;
					$system_alert_num=$system_alert_num+1;
					$alert_content="<a href='?option=permission&task=main/grant'>มีผู้ขออนุญาตไปราชการรอการอนุมัติ</a>";
					$system_alert_ar[$system_alert_num]=$alert_content;
					}
			}
}
else{
			//เตือนอนุญาตไปราชการรออนุมัติ(สำหรับผู้ถูกเลือกให้อนุมัติ)
			$sql_permission_alert2 = "select permission_main.id from permission_main left join permission_person_set on  permission_main.person_id=permission_person_set.person_id where (permission_main.grant_person_selected ='$_SESSION[login_user_id]' or permission_person_set.grant_person ='$_SESSION[login_user_id]') and (permission_main.rec_date<'$onedayago' or permission_person_set.comment_person is null or permission_person_set.comment_person='' or permission_main.no_comment='1' or permission_main.comment_person is not null) and (permission_main.grant_person is null)";
			$dbquery_permission_alert2 = mysqli_query($connect,$sql_permission_alert2);
			$permission_alert2_num=""; //กำหนดตัวแปร
			if($dbquery_permission_alert2){
					$permission_alert2_num=mysqli_num_rows($dbquery_permission_alert2);	
					if($permission_alert2_num>=1){
					$alert=1;
					$system_alert_num=$system_alert_num+1;
					$alert_content="<a href='?option=permission&task=main/grant'>มีผู้ขออนุญาตไปราชการรอการอนุมัติ</a>";
					$system_alert_ar[$system_alert_num]=$alert_content;
					}
			}
}  

////////////////////////////////////////////////////////////
//เตือนลาของผู้เห็นชอบ
$sql_la_alert = "select la_main.id from la_main left join la_person_set on  la_main.person_id=la_person_set.person_id where (la_person_set.comment_person ='$_SESSION[login_user_id]') and (la_main.group_sign is null) and (la_main.commander_sign is null)";

$dbquery_la_alert = mysqli_query($connect,$sql_la_alert );
if($dbquery_la_alert){
		$la_alert_num=mysqli_num_rows($dbquery_la_alert);	
		if($la_alert_num>=1){
		$alert=1;
		$system_alert_num=$system_alert_num+1;
		$alert_content="<a href='?option=la&task=main/basic_comment'>มีผู้ขออนุญาตลารอความเห็นชอบ</a>";
		$system_alert_ar[$system_alert_num]=$alert_content;
		}
}

if($delegate==1){
			//เตือนการลารออนุมัติ กรณีรักษาราชการแทน
			$sql_la_alert2 = "select la_main.id from la_main left join la_person_set on  la_main.person_id=la_person_set.person_id where (la_main.grant_p_selected ='$_SESSION[login_user_id]' or la_person_set.grant_person ='$_SESSION[login_user_id]' or la_main.grant_p_selected ='$boss' or la_person_set.grant_person ='$boss') and (la_main.rec_date<'$onedayago' or la_person_set.comment_person is null or la_person_set.comment_person='' or la_main.no_comment='1' or la_main.group_sign is not null) and (la_main.commander_sign is null)";
			$dbquery_la_alert2 = mysqli_query($connect,$sql_la_alert2);
			$la_alert2_num=""; // กำหนดตัวแปร
			if($dbquery_la_alert2){
					$la_alert2_num=mysqli_num_rows($dbquery_la_alert2);	
					if($la_alert2_num>=1){
					$alert=1;
					$system_alert_num=$system_alert_num+1;
					$alert_content="<a href='?option=la&task=main/grant'>มีผู้ขออนุญาตลารอการอนุมัติ</a>";
					$system_alert_ar[$system_alert_num]=$alert_content;
					}
			}
}
else{
			//เตือนการลารออนุมัติ
			$sql_la_alert2 = "select la_main.id from la_main left join la_person_set on  la_main.person_id=la_person_set.person_id where (la_main.grant_p_selected ='$_SESSION[login_user_id]' or la_person_set.grant_person ='$_SESSION[login_user_id]') and (la_main.rec_date<'$onedayago' or la_person_set.comment_person is null or la_person_set.comment_person='' or la_main.no_comment='1' or la_main.group_sign is not null) and (la_main.commander_sign is null)";
			$dbquery_la_alert2 = mysqli_query($connect,$sql_la_alert2);
			$la_alert2_num=""; // กำหนดตัวแปร
			if($dbquery_la_alert2){
					$la_alert2_num=mysqli_num_rows($dbquery_la_alert2);	
					if($la_alert2_num>=1){
					$alert=1;
					$system_alert_num=$system_alert_num+1;
					$alert_content="<a href='?option=la&task=main/grant'>มีผู้ขออนุญาตลารอการอนุมัติ</a>";
					$system_alert_ar[$system_alert_num]=$alert_content;
					}
			}
} 

//เตือนขอยกเลิกวันลาของผู้เห็นชอบ
$sql_la_alert4 = "select la_cancel.id from la_cancel left join la_person_set on  la_cancel.person_id=la_person_set.person_id where (la_person_set.comment_person ='$_SESSION[login_user_id]') and (la_cancel.group_sign is null) and (la_cancel.commander_sign is null) ";

$dbquery_la_alert4 = mysqli_query($connect,$sql_la_alert4 );
if($dbquery_la_alert4){
		$la_alert4_num=mysqli_num_rows($dbquery_la_alert4);	
		if($la_alert4_num>=1){
		$alert=1;
		$system_alert_num=$system_alert_num+1;
		$alert_content="<a href='?option=la&task=main/cancel_basic_comment'>มีผู้ขออนุญาตยกเลิกวันลารอความเห็นชอบ</a>";
		$system_alert_ar[$system_alert_num]=$alert_content;
		}
}

if($delegate==1){
			//เตือนการขอยกเลิกวันลารออนุมัติ กรณีรักษาราชการแทน
			$sql_la_alert5 = "select la_cancel.id from la_cancel left join la_person_set on  la_cancel.person_id=la_person_set.person_id where (la_cancel.grant_p_selected='$_SESSION[login_user_id]' or la_person_set.grant_person='$_SESSION[login_user_id]' or la_cancel.grant_p_selected='$boss' or la_person_set.grant_person='$boss') and (la_cancel.rec_date<'$onedayago' or la_person_set.comment_person is null or la_person_set.comment_person='' or la_cancel.no_comment='1' or la_cancel.group_sign is not null) and (la_cancel.commander_sign is null)";
			$dbquery_la_alert5 = mysqli_query($connect,$sql_la_alert5);
			$la_alert5_num=""; //กำหนดตัวแปร
			if($dbquery_la_alert5){
					$la_alert5_num=mysqli_num_rows($dbquery_la_alert5);	
					if($la_alert5_num>=1){
					$alert=1;
					$system_alert_num=$system_alert_num+1;
					$alert_content="<a href='?option=la&task=main/cancel_grant'>มีผู้ขออนุญาตยกเลิกวันลารอการอนุมัติ</a>";
					$system_alert_ar[$system_alert_num]=$alert_content;
					}
			}
}
else{
			//เตือนการขอยกเลิกวันลารออนุมัติ
			$sql_la_alert5 = "select la_cancel.id from la_cancel left join la_person_set on  la_cancel.person_id=la_person_set.person_id where (la_cancel.grant_p_selected='$_SESSION[login_user_id]' or la_person_set.grant_person='$_SESSION[login_user_id]') and (la_cancel.rec_date<'$onedayago' or la_person_set.comment_person is null or la_person_set.comment_person='' or la_cancel.no_comment='1' or la_cancel.group_sign is not null) and (la_cancel.commander_sign is null)";
			$dbquery_la_alert5 = mysqli_query($connect,$sql_la_alert5);
			$la_alert5_num=""; //กำหนดตัวแปร
			if($dbquery_la_alert5){
					$la_alert5_num=mysqli_num_rows($dbquery_la_alert5);	
					if($la_alert5_num>=1){
					$alert=1;
					$system_alert_num=$system_alert_num+1;
					$alert_content="<a href='?option=la&task=main/cancel_grant'>มีผู้ขออนุญาตยกเลิกวันลารอการอนุมัติ</a>";
					$system_alert_ar[$system_alert_num]=$alert_content;
					}
			}
}

////////////////////////////////////////////////////////////
//เตือนmail
$sql_mail_alert = "select  mail_main.ms_id from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$_SESSION[login_user_id]' and mail_sendto_answer.answer<'1' ";
$dbquery_mail_alert = mysqli_query($connect,$sql_mail_alert );
if($dbquery_mail_alert){
		$mail_num=mysqli_num_rows($dbquery_mail_alert);	
		if($mail_num>=1){
		$alert=1;
		$system_alert_num=$system_alert_num+1;
				if($_SESSION['user_os']=='mobile'){
				$alert_content="<a href='?option=mail&task=main/receive_mobile'>มีจดหมายยังไม่ได้รับ</a>";
				}
				else{
				$alert_content="<a href='?option=mail&task=main/receive'>มีจดหมายยังไม่ได้รับ</a>";
				}
		$system_alert_ar[$system_alert_num]=$alert_content;
		}
}

////////////////////////////////////////////////////////////

//เตือนระบบส่งหนังสือราชการ
//ส่วนบุคคล
$sql_book_alert = "select id from book_sendto_answer left join book_main on book_sendto_answer.ref_id=book_main.ref_id where book_sendto_answer.send_to='$_SESSION[login_user_id]' and book_sendto_answer.answer is null and book_main.send_date>'$alert_dayago' ";
$dbquery_book_alert = mysqli_query($connect,$sql_book_alert );
if($dbquery_book_alert){
		$book_num=mysqli_num_rows($dbquery_book_alert);	
		if($book_num>=1){
		$alert=1;
		$system_alert_num=$system_alert_num+1;
				if($_SESSION['user_os']=='mobile'){
				$alert_content="<a href='?option=book&task=main/receive_mobile'>มีหนังสือราชการยังไม่ได้รับ</a>";
				}
				else{
				$alert_content="<a href='?option=book&task=main/receive'>มีหนังสือราชการยังไม่ได้รับ</a>";
				}
		$system_alert_ar[$system_alert_num]=$alert_content;
		}
}

//สารบรรณกลุ่ม
$sql_permission_book2 = "select  p2  from  book_permission2 where person_id='$_SESSION[login_user_id]'";
$dbquery_permission_book2 = mysqli_query($connect,$sql_permission_book2);
if($dbquery_permission_book2){
$result_permission_book2 = mysqli_fetch_array($dbquery_permission_book2);
$p2=$result_permission_book2['p2']	;	
$sql_book_alert = "select id from book_sendto_answer left join book_main on book_sendto_answer.ref_id=book_main.ref_id where book_sendto_answer.send_to='$p2' and book_sendto_answer.answer is null and book_main.send_date>'$alert_dayago' ";
$dbquery_book_alert = mysqli_query($connect,$sql_book_alert );
		if($dbquery_book_alert){
		$book_num=mysqli_num_rows($dbquery_book_alert);
					if($book_num>=1){
					$alert=1;
					$system_alert_num=$system_alert_num+1;
					$alert_content="<a href='?option=book&task=main/receive'>มีหนังสือราชการส่งเข้ากลุ่มที่ยังไม่ได้รับ</a>";
					$system_alert_ar[$system_alert_num]=$alert_content;
					}
		}			
}
//////////////////////////////////////////

// Amss++ alert
//เตือนหนังสือสพท  และจดหมายสพท.
$sql = "select * from system_sync_code where system_name='amssplus'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$office_code=$result['office_code'];
$sync_code=md5($result['sync_code']);
$url=$result['amssplus_url'];
$user=$_SESSION['login_user_id'];

if($url!=""){
			$sql_permission_book = "select  p1  from  book_permission where person_id='$_SESSION[login_user_id]'";
			$dbquery_permission_book = mysqli_query($connect,$sql_permission_book);
			$result_permission_book = mysqli_fetch_array($dbquery_permission_book);
			if(($result_permission_book) or ($_SESSION['login_status']==2)){
			$book_salaban=1;
			}
			else{
			$book_salaban=0;
			}

			$url ="$url/alert/smss_book_alert.php?remote_school=$system_office_code&remote_user=$user&book_salaban=$book_salaban";
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($url);
			$book_alert=base64_decode($xmlDoc->getElementsByTagName('book_alert')->item(0)->nodeValue);
			$mail_alert=base64_decode($xmlDoc->getElementsByTagName('mail_alert')->item(0)->nodeValue);
			
			if($book_alert==1){
			$alert=1;
			$system_alert_num=$system_alert_num+1;
					$alert_content="<a href='?option=book&task=main/receive'>มีหนังสือราชจากสพท.ยังไม่ได้รับ</a>";
			$system_alert_ar[$system_alert_num]=$alert_content;
			}
			
			if($mail_alert==1){
			$alert=1;
			$system_alert_num=$system_alert_num+1;
					$alert_content="<a href='?option=amss_mail&task=main/receive'>มีจดหมายจากสพท.ยังไม่ได้รับ</a>";
			$system_alert_ar[$system_alert_num]=$alert_content;
			}
}
////////////////////////////////

}
//**end alert  for teacher
?>