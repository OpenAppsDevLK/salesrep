<?php
// Database Connection
$dbconnect = array(
    'server' => 'localhost',
    'dbuser' => 'xxxxxx',
    'dbpass' => 'xxxxxx',
    'dbname' => 'xxxxxxx'    
);

$db = new mysqli (
        $dbconnect ['server'],
        $dbconnect ['dbuser'],
        $dbconnect ['dbpass'],
        $dbconnect ['dbname']     
        
        );

if ($db->connect_errno>0){
    echo "Database Connect Error";
    exit;
}  else {
    //echo "Success";
    
}



?>
