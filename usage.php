<?php

// includes database classes
include('database.class.php');
// get a database instance
$db = Database::Instance();
// select query
$recs = $db->fetchAll('Select * from users where user_id=:user_id');
// print recordset
print_r($recs);
// select query
$recs = $db->fetchAll('Select * from users where user_id=:user_id' , array(':user_id'=> '2'));
// print recordset
print_r($recs);
    
