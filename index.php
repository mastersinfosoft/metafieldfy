<?php
echo 'test first app for shopify';
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
echo '<pre>';
print_r($url);
?>