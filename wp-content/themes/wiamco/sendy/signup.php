<?php
//------------------- Edit here --------------------//
$sendy_url = 'https://adobe-creative-cloud.com/sendy';
$api_key = '3l8DwIsy5qYwMA6xJYZz'; //Can be retrieved from your Sendy's main settings
//------------------ /Edit here --------------------//

//--------------------------------------------------//
//POST variables
$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['Mobile'];
$list = $_POST['list'];

//subscribe
$postdata = http_build_query(
	array(
		'name' => $name,
		'email' => $email,
		'list' => $list,
		'api_key' => $api_key,
		'boolean' => 'true'
	)
);
$opts = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));
$context = stream_context_create($opts);
$result = file_get_contents($sendy_url . '/subscribe', false, $context);

echo $result;
?>