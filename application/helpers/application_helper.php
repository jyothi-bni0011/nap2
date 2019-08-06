<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('array_ids'))
{
	function array_ids( $arrays, $key_name ) {

		if( ! is_array($arrays) ) {
			return [];
		}

		$data = [];
		foreach($arrays as $array) 
		{
			$data[] = array_key_exists($key_name, $array)? $array->{$key_name}:[];
		}

		return $data;

	}
}

if ( ! function_exists('map_id_key'))
{
	function map_id_key( $arrays, $key_name ) 
	{

		if( ! is_array($arrays) ) {
			return [];
		}

		$data = [];
		foreach($arrays as $array) 
		{
			$data[$array->{$key_name}][] = $array;
		}

		return $data;

	}
}

if ( ! function_exists('error_message'))
{
	function error_message($message='')
	{
		return sprintf('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>%s</div>', $message);
	}
}

if ( ! function_exists('success_message'))
{
	function success_message($message='')
	{
		return sprintf('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>%s</div>', $message);
	}
}