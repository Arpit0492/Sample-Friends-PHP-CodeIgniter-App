<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['email'] = Array(
    'protocol' => 'sendmail',
    'mailpath' => '/usr/sbin/sendmail',
    'mailtype'  => 'html',
    'charset'   => 'utf-8',
    'wordwrap' => TRUE,
);

$is_local = getenv('LOCAL');
if (isset($is_local) && $is_local) {
  $config['email'] = Array(
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_port' => 465,
      'smtp_user' => 'airflash.co@gmail.com',
      'smtp_pass' => '!Asdf1234',
      'mailtype'  => 'html',
      'charset'   => 'utf-8',
      'wordwrap' => TRUE,
  );
}
