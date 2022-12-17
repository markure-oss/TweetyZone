<?php 
define("DB_HOST", "localhost");
define("DB_NAME","twitter");
define("DB_USER","tweety2");
define("DB_PASS","123456");



// SMTP
define("M_HOST", "smtp.gmail.com");
define("M_USERNAME", "moilelezz1234@gmail.com");
define("M_PASSWORD", "kanfuxouialqignb");
define("M_SMTPSECURE", "tls");
define("M_PORT", "587");

$public_end = strpos($_SERVER['SCRIPT_NAME'], "/frontend") + 8;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
// echo $public_end;
// echo $doc_root;

define("WWW_ROOT", $doc_root);


?>