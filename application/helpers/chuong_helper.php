<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function cpre( $arr )
{
	echo '<pre>';print_r($arr);echo '</pre>';
}

function cdie( $str = '<h2>default cdie function.</h2>')
{
	die($str);
}





function validateDate($date, $format = 'Y-m-d')
{
	$d = DateTime::createFromFormat( $format, $date );
	return $d && $d->format($format) == $date;
}

function obaju_url($str = '')
{
	return base_url('public/obaju/'.$str);
}

function dire_url($str = '')
{
	return base_url('public/direClassic/'.$str);
}


?>