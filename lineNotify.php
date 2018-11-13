<?php
date_default_timezone_set('Asia/Bangkok');
require_once "../../../smss_connect.php";	

$LineAuthenCode ="b6tQnB9Y1isiNOuy0gk58StPscEQrYMVNSMHEmZ7a29"; //ใส่ line authen code

$s_id = $_REQUEST['s_id'];

if($s_id == "saraban"){
	$receiverName = "สารบรรณกลาง";
}else{

	$sql_work_group = mysqli_query($connect,"SELECT * FROM  system_workgroup where workgroup = '$s_id'");
	if(mysqli_num_rows($sql_work_group)>0){
		$row_work_group= mysqli_fetch_array($sql_work_group);		
		$receiverName = $row_work_group['workgroup_desc'];
	}else{
		$sql_person = mysqli_query($connect,"SELECT * FROM  person_main where person_id ='$s_id'") ;
		$row_person = mysqli_fetch_array($sql_person);
		$receiverName = $row_person['name']." ".$row_person['surname'];
	}
}

$message = "มีหนังสือราชการส่งถึง $receiverName ครับ";

$chOne = curl_init();
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
// SSL USE
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
//POST
curl_setopt( $chOne, CURLOPT_POST, 1);
// Message
//curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
// follow redirects
//curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
//ADD header array
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '. $LineAuthenCode, );  // หลังคำว่า Bearer ใส่ line authen code ไป
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
//RETURN
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $chOne );
//Check error
if(curl_error($chOne)) { 
	echo 'error:' . curl_error($chOne); 
}else { 
	$result_ = json_decode($result, true);
//echo "status : ".$result_['status']; echo "message : ". $result_['message']; 
}
//Close connect
curl_close( $chOne );

?>
