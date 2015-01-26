#!/usr/bin/env php
<?php

require getenv('HOME') . '/.composer/vendor/autoload.php';

// Command Line Parameters
$backupMailSubject = $argv[1];
$backupMailBody = $argv[2];
$backupFile = $argv[3];

$configFile = getenv('HOME') . '/.backup_mail';
$content = file_get_contents($configFile);
$parts = explode(':', $content);

$backupMailAddress = $parts[0];
$backupMailPassword = $parts[1];

$mailer = new Nette\Mail\SmtpMailer(array(
  'host' => 'smtp.gmail.com',
  'username' => $backupMailAddress,
  'password' => $backupMailPassword,
  'secure' => 'ssl',
));

$message = new Nette\Mail\Message();
$message
  ->setFrom($backupMailAddress)
  ->addTo($backupMailAddress)
  ->setSubject($backupMailSubject)
  ->setBody($backupMailBody)
  ->addAttachment($backupFile);
$mailer->send($message);
