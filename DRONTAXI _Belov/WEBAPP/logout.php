<?php

ini_set('display_errors', 'Off'); 
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



if (isset($_COOKIE['uuid'])){	
	
	$sql = "DELETE FROM [DronTaxi].[dbo].[Sessions] WHERE SessionID = '".$_COOKIE['uuid']."';" ;
	$qty = 0; $id = 0;
	$stmt = sqlsrv_prepare( $conn, $sql, array( &$qty, &$id));
	if( $stmt ) sqlsrv_execute( $stmt ); 
	
}


sqlsrv_close ( $conn ) ;



?>
  