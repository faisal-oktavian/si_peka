<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	// $config['charset'] = 'utf-8';
	// $config['newline'] = "\r\n";
	// $config['mailtype'] = 'html';
	// $config['protocol'] = 'smtp';
	// // $config['smtp_host'] = 'ssl://smtp.gmail.com';
	// // $config['smtp_port'] = '465';
	// // $config['smtp_user'] = 'emailadvise47@gmail.com';
	// // $config['smtp_pass'] = 'adviseemail47';

	// $config['smtp_host'] = 'smtp.gmail.com';
	// $config['smtp_port'] = '587';
    // $config['smtp_crypto'] = 'tls';
	// $config['smtp_user'] = 'noreply@fagroup.id';
	// $config['smtp_pass'] = 'j4d3333p|21!ntdo.tiD%%$#&';


	$config = array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.gmail.com',
		'smtp_port' => 465,
		'smtp_user' => 'printsoftprogrammer@gmail.com',
		// 'smtp_pass' => 'lupakatasandi97',
		'smtp_pass' => 'm w y z x y j c k c f e t i c q', // isinya: OTP email survei kepuasan pasien rssg
		'mailtype'  => 'html',
		'charset'   => 'utf-8',
		'wordwrap'  => TRUE
	);