<?php
require 'vendor/autoload.php';
use sandeepshetty\shopify_api;
include 'config.php';
if(!empty($_GET['shop']) && !empty($_GET['code'])){

  $shop = $_GET['shop']; //shop name
  $select_settings = $db->query("SELECT * FROM tbl_appsettings WHERE id = 2");
  $app_settings = $select_settings->fetchObject();
  
  //get permanent access token
  $access_token = shopify_api\oauth_access_token(
      $_GET['shop'], $app_settings->api_key, $app_settings->shared_secret, $_GET['code']
  );

  

  //save the shop details to the database
  $db->query("
     INSERT INTO tbl_usersettings 
     SET access_token = '$access_token',
     store_name = '$shop'
 ");

  //save the signature and shop name to the current session
  $_SESSION['shopify_signature'] = $_GET['signature'];
  $_SESSION['shop'] = $shop;

  header('Location: http://mastersinfosoft.com/cvs/shopify/admin.php');
}
