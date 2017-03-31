<?php

require 'vendor/autoload.php';
use sandeepshetty\shopify_api;
include 'config.php';
session_start(); //start a session_commit()


if($db->connect_errno){
  die('Connect Error: ' . $db->connect_errno);
}

$select_settings = $db->query("SELECT * FROM tbl_appsettings WHERE id = 2");
$app_settings = $select_settings->fetchAll();


if(!empty($_GET['shop'])){ //check if the shop name is passed in the URL
  $shop = $_GET['shop']; //shop-name.myshopify.com
  
  if(isset($_GET['code'])){
  $_GET['signature']  =  $_GET['hmac'];
  if(!shopify_api\is_valid_request($_GET, $app_settings[0]['shared_secret'])){ //check if its a valid request from Shopify
        echo 'this request not from shopify please check your url';        
        die();
  }
  $code = $_GET['code'];
  $shop = $_GET['shop'];
  $api_key = $app_settings[0]['api_key'];
  $shared_secret = $app_settings[0]['shared_secret'];
  $data = shopify_api\oauth_access_token($shop, $api_key, $shared_secret, $code);
  
  echo '<pre>';
  print_r($_GET);
  print_r($data);
  echo '</pre>';
  die();
  $select_store = $db->query("SELECT store_name FROM tbl_usersettings WHERE store_name = '$shop'"); //check if the store exists
 
  if($select_store->rowCount() > 0){
      
          $_SESSION['shopify_signature'] = $_GET['signature'];
          $_SESSION['shop'] = $shop;
          header('Location: https://metafieldfy.herokuapp.com/shopify_testing/admin.php'); //redirect to the admin page
      
      
  }else{

  }

}else{     
      //convert the permissions to an array
      $permissions = json_decode($app_settings[0]['permissions'], true);
      //get the permission url
      $scope = empty($permissions) ? '' : '&scope='.implode(',', $permissions);
      $redirect_uri = empty($app_settings[0]['redirect_url']) ? '' : '&redirect_uri='.urlencode($app_settings[0]['redirect_url']);
      $permission_url = "https://".$_GET['shop']."/admin/oauth/authorize?client_id=".$app_settings[0]['api_key']."$scope$redirect_uri";
      header('Location: ' . $permission_url); //redirect to the permission url
  }
}
