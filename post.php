<?php

// if ( !defined('ABSPATH') )
// 	die();

if ( !session_id() )

	session_start();

	

if (isset( $_POST['wpsys'])) {



	$domain = $_POST['wpsys'];



	//Convert $_POST to $_SESSION

	foreach ( $_POST as $key => $value) {

		if ( !empty($value) ) {

		$_SESSION[$key] = $value;

		}

	}

	

	header("Location: $domain");

	exit;



} else { header("HTTP/1.0 404 Not Found"); exit; }



/*EOF*/
