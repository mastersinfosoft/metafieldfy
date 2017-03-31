<?php

require 'vendor/autoload.php';
use sandeepshetty\shopify_api;
include 'config.php';
session_start(); //start a session



if($db->connect_errno){
  die('Connect Error: ' . $db->connect_errno);
}

$select_settings = $db->query("SELECT * FROM tbl_appsettings WHERE id = 2");
$app_settings = $select_settings->fetchAll();

if(!empty($_GET['shop'])){ //check if the shop name is passed in the URL
  $shop = $_GET['shop']; //shop-name.myshopify.com

  $select_store = $db->query("SELECT store_name FROM tbl_usersettings WHERE store_name = '$shop'"); //check if the store exists
  print_r($select_store);
  if($select_store->rowCount() > 0){
      
      if(shopify_api\is_valid_request($_GET, $app_settings->shared_secret)){ //check if its a valid request from Shopify        
          $_SESSION['shopify_signature'] = $_GET['signature'];
          $_SESSION['shop'] = $shop;
          header('Location: http://localhost/shopify_testing/admin.php'); //redirect to the admin page
      }
      
  }else{     
      //convert the permissions to an array
      print_r($app_settings);
      $permissions = json_decode($app_settings->permissions, true);
      //get the permission url
      
      $scope = empty($permissions) ? '' : '&scope='.implode(',', $permissions);
    $redirect_uri = empty($app_settings['redirect_url']) ? '' : '&redirect_uri='.urlencode($app_settings['redirect_url']);
    return "https://".$_GET['shop']."/admin/oauth/authorize?client_id=".$app_settings['api_key']."$scope$redirect_uri";
      //echo $permission_url .= '&redirect_uri=' . $app_settings['redirect_url'];
      die();
      header('Location: ' . $permission_url); //redirect to the permission url
  }
}
