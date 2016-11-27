<?php
/*
Project: Facebook Remote Login
Author: Miraz Mac(Unsocial Boy)
Author URI: https://mirazmac.info
Description: Remote Login to Facebook with the power of cURL.
*/

//Enter Your Facebook Account Details - Don't worry it's safe
$login_email = 'plyffblog@gmail.com';
$login_pass = '0856782537cs1';

//Simple cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://m.facebook.com/login.php');
curl_setopt($ch, CURLOPT_POSTFIELDS,'charset_test=€,´,€,´,水,Д,Є&email='.urlencode($login_email).'&pass='.urlencode($login_pass).'&login=Login');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset: utf-8',
'Accept-Language: en-us,en;q=0.7,bn-bd;q=0.3',
'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5')); 
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd () . '/mirazmac_cookie.txt' ); // The cookie file
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd () . '/mirazmac_cookie.txt' );   // cookie jar
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
curl_setopt($ch, CURLOPT_REFERER, "http://m.facebook.com");
$fbMain = curl_exec($ch) or die(curl_error($ch)); 

//Blocking Direct Access to file
if (eregi("fb.php", $_SERVER['PHP_SELF'])) {   die("<p><h2>Access Denied!</h2><h4>You don't have right permission to access this file directly.<br/>Contact MiraZ Mac for more information.</h4></p>"); }
?>