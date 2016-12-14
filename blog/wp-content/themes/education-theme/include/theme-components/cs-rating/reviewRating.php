<?php 
/**
 * Review Rating
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	
	echo  $_POST['rate'];
	die;
	$json	= array();
	if ( isset ( $_POST['rate'] ) && $_POST['rate'] != '' ) {
		$json['type']	= 'success';
		$json['datar']	= $_POST['rate'];
	} else {
		$json['type']	= 'error';
		$json['datar']	= '0';
	}
	echo json_encode( $json );
	die;
	
	
