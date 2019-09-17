<?php
$config['email_config_old'] = array(
	'protocol' 		=> 'smtp',
	'smtp_host' 	=> 'email-smtp.us-west-2.amazonaws.com',
	'smtp_port' 	=> 587,
	'smtp_user' 	=> 'AKIAIHFY4RLY3PV7TBEA', // change it to yours
	'smtp_pass' 	=> 'BHbay+Atzb8QoYDUtO13dczv+E6J6cYlzrNLt9P7Qyms', // change it to yours
	'smtp_crypto' 	=> "tls",
	/*'charset' 	=> 'iso-8859-1',
	'wordwrap' 		=> TRUE*/
	'charset'		=>'utf-8',
	'wordwrap'		=> TRUE,
	'mailtype' 		=> 'html',
	// 'newline' 		=> "\r\n"
);	
//Added by jyothi on 16-07-2019
$config['email_config'] = array(
	'protocol' 		=> 'smtp',
	'smtp_host' 	=> 'smtp.danahermail.com',
	'smtp_port' 	=> 25,
	'smtp_user' 	=> '', // change it to yours
	'smtp_pass' 	=> '', // change it to yours
	/*'smtp_crypto' 	=> "",*/
	/*'charset' 	=> 'iso-8859-1',
	'wordwrap' 		=> TRUE*/
	'charset'		=>'utf-8',
	'wordwrap'		=> TRUE,
	'mailtype' 		=> 'html',
	
	// 'newline' 		=> "\r\n"
);
/*
$config['mail_mailer']          = 'PHPMailer';
$config['mail_debug']           = 0; // default: 0, debugging: 2, 'local'
$config['mail_debug_output']    = 'html';
$config['mail_smtp_auth']       = false;//true//false
$config['mail_smtp_secure']     = ''; // default: '' | tls | ssl |
$config['mail_charset']         = 'utf-8';
$config['mail_from'] 			= 'Lansweeper@leicabiosystems.com';//Lansweeper@leicabiosystems.com//talentserv@talentserv.co.in
$config['mail_template_folder'] = 'templates/email';
$config['mail_smtp']            = 'smtp.danahermail.com';//smtp.danahermail.com//email-smtp.us-west-2.amazonaws.com
$config['mail_port']            = '25'; // for gmail default 587 with tls//25
$config['mail_user']            = '';//AKIAJKKFD3JWWQK3SQIQ
$config['mail_pass']            = '';//AvcS+4fOuHyqFxp7UjgUDw7g1dysls1xAJV9NvT3xjHe
$config['mail_setBcc']          = false;
$config['mail_setCc']           = false;
*/



?>