<?php

ini_set('display_errors', 'Off'); 



// ПОДКЛЮЧЕНИЕ К БД 
$serverName = "localhost\\sqlexpress, 1433"; 
$connectionInfo = array( "Database"=>"DronTaxi", "UID"=>"sa", "PWD"=>"gfhjkbr23" , 'CharacterSet' => 'UTF-8');
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn ) {
    // 
}else{
	echo '{ "errorMessage" : "Ошибка. Нет связи с базой данных"}';
    exit();	 
}


// ПОЛУЧЕНИЕ ДАННЫХ 
$request_body = file_get_contents('php://input');

if(!isset($request_body)) {
	sqlsrv_close ( $conn ) ;
	echo '{ "errorMessage" : "Доступ запрещен"}';
    exit();	 
}





//// ПРОВЕРКА ОТКРЫТЫХ СЕССИЙ
//if (isset($_COOKIE['uuid'])){
//
//	$sql ="SELECT UserID FROM [dbo].[Sessions] WHERE SessionID = '" . $_COOKIE['uuid'] ."'";	
//	
//	$result = sqlsrv_query($conn, $sql);
//	if($result) {
//
//		$id="";
//		while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
//		   $id .= trim($row['UserID']);
//		   break;
//		}
//	}
//}


$data = json_decode($request_body);
$sets= "";


$Login = strtolower( trim($data->{'Login'}));
$OldLogin = $Login;
if (isset($data->{'EMail'})) {
	
	$sql ="SELECT ID FROM [dbo].[Users] WHERE Login = '" . $data->{'EMail'} ."'";	
	
	$result = sqlsrv_query($conn, $sql);
	if($result) {
		$id="";
		while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
		   $id .= trim($row['ID']);
		   break;
		}
		if ($id != "") {
			
			sqlsrv_close ( $conn ) ;
			echo '{ "errorMessage" : "Отказано"}';
			exit();	 
		}
		
		
	}

	
	$Login = strtolower(trim($data->{'EMail'}));
	$sets .= "EMail = '". $Login  ."', Login = '". $Login  ."', ";	
}








if (isset($data->{'SurName'})) $sets .= "SurName = '". trim($data->{'SurName'}) ."', ";
if (isset($data->{'FirstName'})) $sets .= "FirstName = '". trim($data->{'FirstName'}) ."', ";
if (isset($data->{'MidName'})) $sets .= "MidName = '". trim($data->{'MidName'}) ."', ";
if (isset($data->{'Sex'})) $sets .= "Sex = ". trim($data->{'Sex'})  .", ";
if (isset($data->{'BirthDay'})) $sets .= "BirthDay = '". trim($data->{'BirthDay'})  ." 00:00:00', ";
if (isset($data->{'Phone'})) $sets .= "Phone = '". trim($data->{'Phone'})  ."', ";
if (isset($data->{'Image'})) $sets .= "Image = '". trim($data->{'Image'})  ."', ";




if (isset($data->{'Password'})) {
	$md5pass = md5(md5('drontaxi' . $Login) . $data->{'Password'});
	$sets .= "Password = '". $md5pass  ."', ";
}


if ($sets== "") {
	sqlsrv_close ( $conn ) ;
	echo '{ "errorMessage" : "Нет данных для изменения"}';
    exit();	 	
}

$sets = substr($sets, 0, strlen ($sets) -2 ); 
$sql = "UPDATE [DronTaxi].[dbo].[Users] SET $sets WHERE Login='$OldLogin'";

 sqlsrv_query($conn, $sql);

$json="";
$sql = "SELECT * FROM [DronTaxi].[dbo].[Users] WHERE Login='$Login'";
$result = sqlsrv_query($conn, $sql);

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
echo $json;
sqlsrv_close ( $conn ) ;



?>
  