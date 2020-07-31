<?php

ini_set('display_errors', 'Off'); 




// ПОЛУЧЕНИЕ ДАННЫХ 
$request_body = file_get_contents('php://input');

if(!isset($request_body)) {
	die("Access Denied");
	exit;
}



// ПОДКЛЮЧЕНИЕ К БД 
$serverName = "localhost\\sqlexpress, 1433"; 
$connectionInfo = array( "Database"=>"DronTaxi", "UID"=>"sa", "PWD"=>"gfhjkbr23" , 'CharacterSet' => 'UTF-8');
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn ) {
    // echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     exit();	 
}




$data = json_decode($request_body);
$login=strtolower(trim($data->{'login'}));


$sql ="SELECT ID FROM [dbo].[Users] WHERE Login = '" . $login ."'";	
	
$result = sqlsrv_query($conn, $sql);
$id="";
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
   $id .= trim($row['ID']);
   break;
}	

	
	$sql ="SELECT Number,DateTime, StartPoint, EndPoint, StatusID FROM [dbo].[Orders] WHERE CustUserID = '" . $id ."'";	
	$result = sqlsrv_query($conn, $sql);
	
	$json="[ " ;
	while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

	   $json .="{";
	   $json .= '"Number" : '.trim($row['Number']).', ';
	   $json .= '"StartPoint" : "'.trim($row['StartPoint']).'", ';
	   $json .= '"EndPoint" : "'.trim($row['EndPoint']).'", ';
	   $json .= '"StatusID" : "'.trim($row['StatusID']).'", ';
	   $json .= '"DateTime" : "'. $row['DateTime']->format('Y-m-d h:m:s') . '"';
	   $json .= '},';
	   
	   //break;
	}
	$json = substr($json, 0, strlen ($json) -1 ); 
    $json .= ']';

echo $json;

sqlsrv_close ( $conn ) ;
exit();


?>
 