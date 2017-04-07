<?php 
include '../config.php';
require '../vendor/autoload.php';

$unstall_data = get_unstall_webhook($shopdata[0]['store_name'], $shopdata[0]['access_token']);
$unstall_data_array = (array)json_decode($unstall_data);
//if (!is_array($unstall_data_array)) {
//    $delete_query = "delete from tbl_usersettings where store_name = '" . $shop . "';";
//    $delete_store = $db->query($delete_query);
//    header("Location: https://metafieldfy.herokuapp.com/shopify_app.php");
//}
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
		<?php 
                $all_metafields = get_all_metafields($shopdata[0]['store_name'], $shopdata[0]['access_token']);
                //echo '<pre>';
                //print_r($all_metafields);
                //print_r($unstall_data_array);
                //print_r(register_unstall_webhook($shopdata[0]['store_name'], $shopdata[0]['access_token']));
                //echo '</pre>';
                
                ?>
                    <h1>Welcome to Metafieldfy</h1>
                    <p>Create information as you want</p>
                    <button type="button" class="btn btn-success">Hire Us</button>
		</div>
		<div></div>
	</div>
</div>
</body>
</html>