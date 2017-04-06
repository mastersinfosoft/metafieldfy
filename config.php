<?php

session_start();
$db = new PDO('mysql:host=o3iyl77734b9n3tg.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=k7n3upaig3c8oujw', 'kji1izquolj8c1vp', 'qlss2us74qn5t1qw');
if (isset($_SESSION['shop']) && $_SESSION['shop'] != '') {
    $select_admin = $db->query("SELECT * FROM tbl_usersettings WHERE store_name = '" . $_SESSION['shop'] . "'"); //check if the store exists
    $shopdata = $select_admin->fetchAll();
}

function get_all_metafields($shop, $token) {
    $url = 'https://' . $shop . '/admin/metafields.json';
    $method = 'GET';
//    $param = array('format' => 'json',
//     'address' => 'https://metafieldfy.herokuapp.com/shopify/unstall.php');
//    $param['topic'] = 'app/uninstalled';
//    $params = array('webhook'=>$param);                                                                  
//    $data_string = json_encode($params);                                                                                                                   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($s, CURLOPT_POST, false);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-Shopify-Access-Token: ' . $token));
    $result = curl_exec($ch);
    return $result;
}

/*$unstall_data = get_unstall_webhook($shopdata[0]['store_name'], $shopdata[0]['access_token']);
$unstall_data_array = json_decode($unstall_data);
if (!is_array($unstall_data_array)) {
    $delete_query = "delete from tbl_usersettings where store_name = '" . $shop . "';";
    $delete_store = $db->query($delete_query);
    header("Location: https://metafieldfy.herokuapp.com/shopify_app.php");
}
 * 
 */
    
