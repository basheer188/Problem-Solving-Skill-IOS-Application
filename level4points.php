<?php
require_once('session.php');
require_once('dbh.php');
$username=$_GET['username'];
$loginqry = "SELECT username, level4 FROM user_info WHERE username='$username'";

$qry = mysqli_query($conn, $loginqry);

if(mysqli_num_rows($qry) > 0){
	
	$i =0;
	while($row = mysqli_fetch_assoc($qry)){
	$student[$i]['username'] = $row['username'];
	$student[$i]['level4'] = $row['level4'];
	
	$i = $i+1;
	}
	$response['status'] = true;
	$response['message']= "Login Successfully";
	$response['data'] = $student;	
}
else{
	$response['status'] = false;
	$response['message']= "No Data";	
}
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);
?>