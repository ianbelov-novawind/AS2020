<?php

ini_set('display_errors', 'Off'); 


// ПОЛУЧЕНИЕ ДАННЫХ 
$request_body = file_get_contents('php://input');

if(!isset($request_body)) {
	die("Access Denied");
	exit;
}



$data = json_decode($request_body);



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



// ПРОВЕРКА ОТКРЫТЫХ СЕССИЙ
if (isset($_COOKIE['uuid'])){
	$id="";
	$sql ="SELECT UserID FROM [dbo].[Sessions] WHERE SessionID = '" . $_COOKIE['uuid'] ."'";	
	
	$result = sqlsrv_query($conn, $sql);
	if($result) {

		
		while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
		   $id = trim($row['UserID']);
		   break;
		}
	}
}


$number=1;
$sql = "SELECT Number FROM [DronTaxi].[dbo].[Orders] ORDER BY Number DESC";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql , $params, $options );

while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
   $number=trim($row['Number']) +1;
   break;
}



	$StartPoint=trim($data->{'StartPoint'});
	$EndPoint=trim($data->{'EndPoint'});
	$V= $data->{'Vehicle'};
	
	$sql = "INSERT INTO [DronTaxi].[dbo].[Orders] VALUES (  $number, CURRENT_TIMESTAMP, $id, NULL, '$StartPoint', '$EndPoint', 1, 1,  NULL, NULL, NULL, NULL)" ;
	
	$qty = 0; $idd = 0;
	$stmt = sqlsrv_prepare( $conn, $sql, array( &$qty, &$idd));
	if( $stmt ) sqlsrv_execute( $stmt ); 

	
sqlsrv_close ( $conn ) ;
exit();


?>
 