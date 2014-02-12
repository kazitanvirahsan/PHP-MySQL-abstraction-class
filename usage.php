<?php
include_once('database.class.php');

/*define db parameter array */
$dbparams = array(
    'server'=> 'localhost',
    'username' => 'XXXX',
    'password' => 'XXXX',
    'database' => 'XXXX'
);

// define number of records per page
$recordsPerPage = 80;
$startRecords = 1;

// get the current page
if(isset($_GET['s']) && is_numeric($_GET['s'])) {
    /* current page */
    $s = $_GET['s'];
    //calculate the start record/ offset for sql query
    $startRecords = $s * $recordsPerPage ;
}

$dbobj = Database::Instance($dbparams);
// define sql query
$sql = "Select * from city LIMIT {$startRecords} , {$recordsPerPage}";
$records = $dbobj->fetchAll($sql);