<?php
header('Content-type: text/html');
header('Access-Control-Allow-Origin: * ');  //I have also tried the * wildcard and get the same response
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');



require_once('linkedin_3.2.0.class.php');

$API_CONFIG = array(
    'appKey' => '86p7hc0any64sm',
    'appSecret' => 'UWR1TiVxRQZspxFK',
    'callbackUrl' => NULL
);
define('CONNECTION_COUNT', 20);
define('PORT_HTTP', '80');
define('PORT_HTTP_SSL', '443');
define('UPDATE_COUNT', 10);

$val = file_get_contents("php://input");
$data=json_decode($val);
//print_r($data);
$linkval = $data -> linkval;
$contentofpost = $data -> content;
$image = $data -> image;
$title = $data -> title;
$logid = $data -> id;

$arr1['oauth_token'] =  $data ->linkoauth_token;
$arr1['oauth_token_secret'] = $data ->linkoauth_token_secret;

$OBJ_linkedin = new LinkedIn($API_CONFIG);
$OBJ_linkedin->setTokenAccess($arr1);


$content = array();

/*if(!empty($_POST['scomment'])) {
    $content['comment'] = $_POST['scomment'];
}
if(!empty($_POST['stitle'])) {
    $content['title'] = $_POST['stitle'];
}
if(!empty($_POST['surl'])) {
    $content['submitted-url'] = $_POST['surl'];
}
if(!empty($_POST['simgurl'])) {
   $content['submitted-image-url'] = $_POST['simgurl'];

}
if(!empty($_POST['sdescription'])) {
    $content['description'] = $_POST['sdescription'];
}*/


/*$content['comment'] = 'this is the comment';
$content['title'] = 'this is the title';
$content['description'] = 'this is the sdescription';
$content['submitted-url'] = 'https://stackoverflow.com/questions/37806237/getting-s-412-precondition-failed-invalid-arguments-error-in-linkedin-share-api';
$content['submitted-image-url'] = 'https://www.cleverfiles.com/howto/wp-content/uploads/2016/08/mini.jpg';*/

$content['comment'] = $contentofpost;
$content['title'] = $title;
$content['description'] = '';
$content['submitted-url'] = $linkval;
$content['submitted-image-url'] = $image;


if(!empty($_POST['sprivate'])) {
    $private = TRUE;
} else {
    $private = FALSE;
}
$private = TRUE;

$response = $OBJ_linkedin->share('new', $content, $private);
print_r($response);


?>