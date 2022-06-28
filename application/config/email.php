<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp.hostinger.com', 
    'smtp_port' => 465,
    'smtp_user' => 'academico@empiresoftgroup.online',
    'smtp_pass' => 'C@nvas2022',
    'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'utf-8', //iso-8859-1
    'wordwrap' => TRUE
);