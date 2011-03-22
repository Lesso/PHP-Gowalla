<?php

	// require gowalla class
	require_once 'gowalla.php';

	// vars we need
	$clientId = '1e1fc56a227542b09fc7aeaa9610d651';
	$clientSecret = '6faf4ab5e0e0408a9b1c55ff90d48bf0';
	$redirectURI = 'http://phpgowalla.local/tests.php';

	// have token already?
	if(is_null($_COOKIE['gowalla_token']))
	{
		// new Gowalla object
		$gowalla = new Gowalla($clientId, $clientSecret, $redirectURI);

		// authenticate app
		$gowalla->authenticate();

		// get code
		$code = $_GET['code'];

		// request token
		$response = $gowalla->requestToken($code);

		// store token in cookie
		setcookie('gowalla_token', $response['access_token'], time()+60*60*24*30);
	}

	// new Gowalla object with token param
	$gowalla = new Gowalla($clientId, $clientSecret, $redirectURI, $_COOKIE['gowalla_token']);

	// get info about me
	var_dump($gowalla->getMe());

	// get trip list
	var_dump($gowalla->getTripList());

	// get information about a spot
	var_dump($gowalla->getSpotInfo(89067));

	// checkin at a spot
	var_dump($gowalla->doCheckin(89067, 'Worky worky', 51.078139, 3.728616, true, true));
?>