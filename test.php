<?php
echo 'test first app for shopify';
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
echo '<pre>';
echo 'hi';
print_r($url);
include 'config.php';
$query = "CREATE TABLE IF NOT EXISTS `tbl_appsettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(300) DEFAULT NULL,
  `redirect_url` varchar(300) DEFAULT NULL,
  `permissions` text,
  `shared_secret` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;"
$select_settings = $db->query($query);
echo 'hi';

?>