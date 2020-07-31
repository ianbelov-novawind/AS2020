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


// ПОЛУЧЕНИЕ ДАННЫХ 
$request_body = file_get_contents('php://input');

if(!isset($request_body)) {
	die("Access Denied");
	exit;
}


$data = json_decode($request_body);


// ХЭШ ПАРОЛЯ
$login=strtolower(trim($data->{'user'}));
$md5pass = md5(md5('drontaxi' . $login) . $data->{'password'});


// ВЫПОЛНЕНИЕ ЗАПРОСА
$sql = "SELECT * FROM [DronTaxi].[dbo].[Users] WHERE [EMail] = '$login' AND [Password] = '$md5pass'";
$result = sqlsrv_query($conn, $sql);
if($result) {
	// OK  
} else {
	print_r("Access Denied");
	sqlsrv_close ( $conn ) ;
	exit();
}

//
//echo $sql;
//sqlsrv_close ( $conn ) ;
//exit();


#Fetching Data by array
$json="";
 $id =0;

while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

   $id = trim($row['ID']);

   $json .="{";
   $json .= '"FirstName" : "'.trim($row['FirstName']).'", ';
   $json .= '"SurName" : "'.trim($row['SurName']).'", ';
   $json .= '"MidName" : "'.trim($row['MidName']).'", ';
   if ($row['BirthDay'] != "") $json .= '"BirthDay" : "'. $row['BirthDay']->format('Y-m-d') . '", ';
   $json .= '"Sex" : "'.trim($row['Sex']).'", ';
   $json .= '"EMail" : "'.trim($row['EMail']).'", ';
   $json .= '"Phone" : "'.trim($row['Phone']).'", ';
   $json .= '"Image" : "'.trim($row['Image']).'" ';
   $json .= '}';
   
   break;
}


if (isset($_COOKIE['uuid'])){

	$sql = "INSERT INTO [DronTaxi].[dbo].[Sessions] VALUES ( '".$_COOKIE['uuid']."',$id, CURRENT_TIMESTAMP);" ;
	
	$qty = 0; $idd = 0;
	$stmt = sqlsrv_prepare( $conn, $sql, array( &$qty, &$idd));
	if( $stmt ) sqlsrv_execute( $stmt ); 
	
}

echo $json;
sqlsrv_close ( $conn ) ;

?>
  