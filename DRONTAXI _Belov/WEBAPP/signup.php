<?php

ini_set('display_errors', 'Off'); 



// ПОДКЛЮЧЕНИЕ К БД 
$serverName = "localhost\\sqlexpress, 1433"; 
$connectionInfo = array( "Database"=>"DronTaxi", "UID"=>"sa", "PWD"=>"gfhjkbr23" , 'CharacterSet' => 'UTF-8');
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn ) {
    // echo "Connection established.<br />";
}else{
	echo '{ "errorMessage" : "Ошибка. Нет связи с базой данных"}';
    exit();	 
}


// ПОЛУЧЕНИЕ ДАННЫХ 
$request_body = file_get_contents('php://input');

if(!isset($request_body)) {
	echo '{ "errorMessage" : "Доступ запрещен"}';
	exit();
}


$data = json_decode($request_body);
$login=strtolower (trim($data->{'email'}));


$sql = "SELECT ID FROM [DronTaxi].[dbo].[Users] WHERE Login='$login'";
$result = sqlsrv_query($conn, $sql);
$checkid =0;
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
   $checkid = trim($row['ID']);
}
if ($checkid> 0){
	echo '{ "errorMessage" : "Ошибка. Пользователь с таким E-Mail уже зарегистрирован"}';
	sqlsrv_close ( $conn ) ;
	exit();
}

$md5pass = md5(md5('drontaxi' . $login) . $data->{'password'});
$surname =trim($data->{'surname'});
$name    =trim($data->{'name'});
$midname =trim($data->{'midname'});
$email   =trim($data->{'email'});

$sql = "SELECT ID FROM [DronTaxi].[dbo].[Users] ORDER BY ID DESC";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql , $params, $options );

while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
   $id=trim($row['ID']) +1;
   break;
}

$sql = "INSERT INTO [DronTaxi].[dbo].[Users] VALUES (";
$sql .= "$id, '$login', '$md5pass', CURRENT_TIMESTAMP, ";
$sql .= "'$surname', '$name', '$midname', NULL, NULL, '$email', NULL, NULL);";
//echo $sql;

$qty = 0; $idd = 0;
$stmt = sqlsrv_prepare( $conn, $sql, array( &$qty, &$idd));
if( $stmt ) sqlsrv_execute( $stmt ); 


$json ="{";
$json .= '"FirstName" : "'. $name    . '", ';
$json .= '"SurName"   : "'. $surname . '", ';
$json .= '"MidName"   : "'. $midname . '", ';
$json .= '"EMail"     : "'. $email   . '"  ';
$json .= '}';
   

sqlsrv_close ( $conn ) ;
echo $json;

?>
  