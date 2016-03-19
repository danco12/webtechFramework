<?php


session_start();

require_once __DIR__.'/../../../../dano/libraries/google/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$basePath = "http://" . $_SERVER["HTTP_HOST"] . "/z3";
$client = new Google_Client();
$client->setAuthConfigFile(__DIR__.'/../../../../dano/libraries/client_secret_649875641118-nbu44jjd8kcdkqmf3gc8gashegkuegll.apps.googleusercontent.com.json');
$client->setRedirectUri('http://147.175.98.178.nip.io/z3/lib/google-api-php-client-master/oauth2callback.php');
$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));

$service = new Google_Service_Oauth2($client);
$client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    header('Location: http://147.175.98.178.nip.io/z3/lib/google-api-php-client-master/oauth2callback.php');
}

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
    $user = $service->userinfo->get();
    $_SESSION['user'] = $user->name;
    $_SESSION['token'] = $client->getAccessToken();
    $loginController = new LoginController();
    $loginController->loginUser($user->name, "google");
    $redirect_uri = $basePath.'/view/loggedIn.php';
    echo "<pre>";
var_dump($redirect_uri);
exit;
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
} else {
    $authUrl = $client->createAuthUrl();
   header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
}

// session_start(); //session start

// require_once (__DIR__.'/../../../../dano/libraries/google/vendor/autoload.php');

// //Insert your cient ID and secret 
// //You can get it from : https://console.developers.google.com/
// $client_id = '649875641118-nbu44jjd8kcdkqmf3gc8gashegkuegll.apps.googleusercontent.com'; 
// $client_secret = 'frl25IVs6wlv4QLQUkPOETem';
// $redirect_uri = 'webtech.com';

// //incase of logout request, just unset the session var
// if (isset($_GET['logout'])) {
//   unset($_SESSION['access_token']);
// }

// /************************************************
//   Make an API request on behalf of a user. In
//   this case we need to have a valid OAuth 2.0
//   token for the user, so we need to send them
//   through a login flow. To do this we need some
//   information from our API console project.
//  ************************************************/
// $client = new Google_Client();
// $client->setClientId($client_id);
// $client->setClientSecret($client_secret);
// $client->setRedirectUri($redirect_uri);
// $client->addScope("email");
// $client->addScope("profile");

// /************************************************
//   When we create the service here, we pass the
//   client to it. The client then queries the service
//   for the required scopes, and uses that when
//   generating the authentication URL later.
//  ************************************************/
// $service = new Google_Service_Oauth2($client);

// /************************************************
//   If we have a code back from the OAuth 2.0 flow,
//   we need to exchange that with the authenticate()
//   function. We store the resultant access token
//   bundle in the session, and redirect to ourself.
// */
  
// if (isset($_GET['code'])) {
//   $client->authenticate($_GET['code']);
//   $_SESSION['access_token'] = $client->getAccessToken();
//   header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
//   exit;
// }

// ***********************************************
//   If we have an access token, we can make
//   requests, else we generate an authentication URL.
//  ***********************************************
// if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
//   $client->setAccessToken($_SESSION['access_token']);
// } else {
//   $authUrl = $client->createAuthUrl();
// }


// //Display user info or display login url as per the info we have.
// echo '<div style="margin:20px">';
// if (isset($authUrl)){ 
// 	//show login url
// 	echo '<div align="center">';
// 	echo '<h3>Login with Google -- Demo</h3>';
// 	echo '<div>Please click login button to connect to Google.</div>';
// 	echo '<a class="login" href="' . $authUrl . '"><img src="images/google-login-button.png" /></a>';
// 	echo '</div>';
	
// } else {
	
// 	$user = $service->userinfo->get(); //get user info 
	
// 	// //check if user exist in database using COUNT
// 	// $result = $mysqli->query("SELECT COUNT(google_id) as usercount FROM google_users WHERE google_id=$user->id");
// 	// $user_count = $result->fetch_object()->usercount; //will return 0 if user doesn't exist
	
// 	// //show user picture
// 	// echo '<img src="'.$user->picture.'" style="float: right;margin-top: 33px;" />';
	
// 	// if($user_count) //if user already exist change greeting text to "Welcome Back"
//  //    {
//  //        echo 'Welcome back '.$user->name.'! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
//  //    }
// 	// else //else greeting text "Thanks for registering"
// 	// { 
//  //        echo 'Hi '.$user->name.', Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
// 	// 	$statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?)");
// 	// 	$statement->bind_param('issss', $user->id,  $user->name, $user->email, $user->link, $user->picture);
// 	// 	$statement->execute();
// 	// 	echo $mysqli->error;
//  //    }
	
// 	//print user details
// 	echo '<pre>';
// 	print_r($user);
// 	echo '</pre>';
// }
// echo '</div>';


?>

