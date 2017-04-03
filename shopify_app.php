<?php
session_start();
require 'vendor/autoload.php';
use sandeepshetty\shopify_api;
include 'config.php';
 //start a session_commit()


if($db->connect_errno){
  die('Connect Error: ' . $db->connect_errno);
}

$select_settings = $db->query("SELECT * FROM tbl_appsettings WHERE id = 2");
$app_settings = $select_settings->fetchAll();



if(!empty($_GET['shop'])){ //check if the shop name is passed in the URL
  $shop = $_GET['shop']; //shop-name.myshopify.com
  
  if(isset($_GET['code'])){
  $hmacSignature = "code=".$_GET['code']."&shop=".$_GET['shop']."&timestamp=".$_GET['timestamp'];
 $clientSharedSecret = $app_settings[0]['shared_secret'];
  $calculatedHmac = hash_hmac('sha256', $hmacSignature, $clientSharedSecret);

  if($_GET['hmac']  != $calculatedHmac){ //check if its a valid request from Shopify
        echo 'this request not from shopify please check your url';        
        die();
  }
  $code = $_GET['code'];
  $shop = $_GET['shop'];
  $api_key = $app_settings[0]['api_key'];
  $shared_secret = $app_settings[0]['shared_secret'];
  $data = shopify_api\oauth_access_token($shop, $api_key, $shared_secret, $code);
  $delete_query = "delete from tbl_usersettings where store_name = '".$shop."';";
  $delete_store = $db->query($delete_query);
  $insert_query = "insert into tbl_usersettings (access_token, store_name, code) values('".$data."', '".$shop."','".$code."')";
  $insert_store = $db->query($insert_query);
  $responce = call_unbstall($shop,$data);
  print_r($responce);
  die();
  $_SESSION['shop'] = $shop;
  header('Location: https://metafieldfy.herokuapp.com/shopify/admin.php'); //redirect to the admin page
  die();

}else{     
      $select_store = $db->query("SELECT store_name FROM tbl_usersettings WHERE store_name = '".$shop."'"); //check if the store exists
 
      if($select_store->rowCount() > 0){
          
              //$_SESSION['shopify_signature'] = $_GET['signature'];
              $_SESSION['shop'] = $shop;
              header('Location: https://metafieldfy.herokuapp.com/shopify/admin.php'); //redirect to the admin page
          
          
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
}

function call_unbstall($shop,$data){
///admin/webhooks.json
  $url = 'https://'.$shop.'/admin/webhooks.json';
  $method = 'POST';
  $param = array('format' => "json",
     'address' => "https://metafieldfy.herokuapp.com/shopify/unstall.php");
  $param['topic'] = 'app/uninstalled';
  $params = array('webook'=>$param);
  $query = in_array($method, array('GET','DELETE')) ? $params : array();
  $payload = in_array($method, array('POST','PUT')) ? stripslashes(json_encode($params)) : array();

  $request_headers = array();
  array_push($request_headers, "X-Shopify-Access-Token: $data");

  if (in_array($method, array('POST','PUT'))) array_push($request_headers, "Content-Type: application/json; charset=utf-8");
   print_r($params); print_r($request_headers);
  return $responce = shopify_api\_api($method, $url, $query, $payload, $request_headers, &$response_headers=array());


}