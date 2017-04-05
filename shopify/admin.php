<?php 
include '../config.php';
require '../vendor/autoload.php';
function get_unstall_webhook($shop,$token){
    $url = 'https://'.$shop.'/admin/webhooks.json';
    $method = 'GET';
    $param = array('format' => 'json',
     'address' => 'https://metafieldfy.herokuapp.com/shopify/unstall.php');
    $param['topic'] = 'app/uninstalled';
    $params = array('webhook'=>$param);                                                                  
$data_string = json_encode($params);                                                                                                                   
$ch = curl_init();               
curl_setopt($ch, CURLOPT_URL, $url);                                                       
curl_setopt($s,CURLOPT_POST,false);                                                                     
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-Shopify-Access-Token: '.$token));
$result = curl_exec($ch);
return $result;
}
$unstall_data = get_unstall_webhook($shopdata[0]['store_name'],$shopdata[0]['access_token']);
$unstall_data_array = json_decode($unstall_data);
echo '<pre>';
print_r($unstall_data);
echo '</pre>';
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
	<h2>Product Metafields for Shopify</h2>
	<div class="row">
		<div class="col-sm-3 col-md-3">
			
			<?php include 'sidebar.php';?>
		</div>
		<div class="col-sm-9 col-md-9">
		
			
		</div>
		<div></div>
	</div>
</div>
</body>
</html>