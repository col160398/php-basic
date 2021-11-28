<?php

session_start();

// $DB_host = "117.3.172.231";
// $DB_user = "amnote";
// $DB_pass = "amnote123";
// $DB_name = "db_intership_lap3";
$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "";
$DB_name = "db_example";



try
{
     $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
     echo $e->getMessage();
}


include_once 'actionClass.php';
$user = new USER($DB_con);
$product = new PRODUCT($DB_con);
$coupon = new COUPON($DB_con);
$category = new CATEGORY($DB_con);