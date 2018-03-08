<?php
ini_set("allow_url_fopen", 1);
$uid = '109a2742bdd0e9708bdb85cf4e09d0dd';
$url = "https://api.betterdoctor.com/2016-03-01/doctors/$uid?user_key=d6fb865f0d167679bbe87e722ea09bdc";
//echo $url;
//echo $json;
$data = file_get_contents($url);
echo $data;
$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");


$encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB);

$val = base64_encode($encrypt);
echo $val;
return $val;

 ?>
