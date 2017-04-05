<?php
session_start();
$db = new PDO('mysql:host=o3iyl77734b9n3tg.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=k7n3upaig3c8oujw', 'kji1izquolj8c1vp', 'qlss2us74qn5t1qw');
if(isset($_SESSION['shop']) && $_SESSION['shop'] != ''){
$select_admin = $db->query("SELECT * FROM tbl_usersettings WHERE store_name = '".$_SESSION['shop']."'"); //check if the store exists
$shopdata =  $select_admin->fetchAll();
echo '<pre>';
print_r($shopdata[0]['access_token']);
echo '</pre>';
}

    
