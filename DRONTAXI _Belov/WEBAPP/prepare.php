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


// ПРОВЕРКА ОТКРЫТЫХ СЕССИЙ
if (isset($_COOKIE['uuid'])){

	$sql ="SELECT Users.ID";
	$sql .="      ,Users.Login";
	$sql .="      ,Users.Password";
	$sql .="      ,Users.RegDate";
	$sql .="      ,Users.SurName";
	$sql .="      ,Users.FirstName";
	$sql .="      ,Users.MidName";
	$sql .="      ,Users.BirthDay";
	$sql .="      ,Users.Sex";
	$sql .="      ,Users.EMail";
	$sql .="      ,Users.Image";
	$sql .="      ,Users.Phone";
	$sql .="  FROM [dbo].[Users] AS Users";
	$sql .="  inner join [dbo].[Sessions] as Sess on Sess.UserID = Users.ID AND Sess.SessionID = '" . $_COOKIE['uuid'] ."'";	
	
	
	$result = sqlsrv_query($conn, $sql);

	if($result) {

		$json="";
		while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

		   $json .="{";
		   $json .= '"FirstName" : "'.trim($row['FirstName']).'", ';
		   $json .= '"SurName" : "'.trim($row['SurName']).'", ';
		   $json .= '"MidName" : "'.trim($row['MidName']).'", ';
		if ($row['BirthDay'] != "") $json .= '"BirthDay" : "'. $row['BirthDay']->format('Y-m-d') . '", ';
		   $json .= '"Sex" : "'.trim($row['Sex']).'", ';
		   $json .= '"EMail" : "'.trim($row['EMail']).'", ';
		   $json .= '"Phone" : "'.trim($row['Phone']).'",';
		   $json .= '"Image" : "'.trim($row['Image']).'" ';
		   $json .= '}';
		   
		   break;
		}
		echo $json;	
	}
}

sqlsrv_close ( $conn ) ;
exit();


?>
 