<?php
$db = new Mysqli;
$db = mysqli_init();
$db->ssl_set('key.pem', 'cert.pem', 'ca.pem', null, null);
$db->real_connect(("us-cdbr-iron-east-03.cleardb.net", "b3bd7eeacd8f20", "71ea49b9", "heroku_30e732ce0560b1b");
