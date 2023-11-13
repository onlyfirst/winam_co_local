<?php
require_once("../../../../wp-load.php");
// Check capcha
$json = array();
if (!empty($_POST['formData']['captcha'])) {
    if ($_SESSION['captcha'] != $_POST['formData']['captcha']) {
        echo 'invalid_captchat';
        die();
    }
} else {
    echo 'empty_captchat';
    die();
}


//------------------- Edit here --------------------//
$sendy_url = 'https://adobe-creative-cloud.com/sendy';
$api_key = '3l8DwIsy5qYwMA6xJYZz'; //Can be retrieved from your Sendy's main settings
//------------------ /Edit here --------------------//

//--------------------------------------------------//
$lang = $_POST['lang'] ? $_POST['lang'] : 'en';
$cartItems = ($_POST['cartItems']) ? $_POST['cartItems'] : [];
$productsIds = array_map('intval', array_column($cartItems, 'productId'));
$args = array(
    'post_type' => 'product_post',
    'posts_per_page' => -1,
    'lang' => $lang,
    'post__in' => $productsIds
);
//POST variables
$name = $_POST['formData']['name'];
$email = $_POST['formData']['email'];
$phone = urldecode($_POST['formData']['phone']);
$region = $_POST['formData']['region'];
$address = $_POST['formData']['address'];
$message = $_POST['formData']['message'];
$list = $_POST['formData']['list'];
$htmlCart = '';
query_posts($args);
$i = 0;
if (have_posts() && $cartItems) {
    while (have_posts()):
        the_post();
        $htmlCart .= '<br>- ' . __('Product name', 'winamco') . ' : ' . get_the_title() . '<br>';
        $htmlCart .= '- ' . __('Code', 'winamco') . ': ' . get_field('product_code') . '<br>';
        $htmlCart .= '- ' . __('Quantity', 'winamco') . ': ' . $cartItems[$i]['quantity'] . '<br>';
        $htmlCart .= '- ' . __('Link', 'winamco') . ': ' . get_permalink() . '<br>';
        $i++;
    endwhile;
}

//Subscribe
$postdata = http_build_query(
    array(
        'name' => $name,
        'email' => urldecode($email),
        'phone' => $phone,
        'Address' => urldecode($address),
        'list' => $list,
        'Country' => urldecode($region),
        'message' => $message,
        'Products' => $htmlCart,
        'api_key' => $api_key,
        'boolean' => 'true'
    )
);

$opts = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded;charset=utf-8', 'content' => $postdata));
$context = stream_context_create($opts);
$result = file_get_contents($sendy_url . '/subscribe', false, $context);

echo $result;
?>