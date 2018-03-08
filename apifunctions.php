#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function searchLocation($location){
  ini_set("allow_url_fopen", 1);
  define(MCRYPT_RIJNDAEL_256,false);
  //$uid = $_GET['uid'];
  $url = "https://api.betterdoctor.com/2016-03-01/doctors?location=$location&skip=0&limit=10&user_key=d6fb865f0d167679bbe87e722ea09bdc";
  //echo $url;
  //echo $json;
  $data = file_get_contents($url);
  echo $data;
  $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");


  $encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB);

  $val = base64_encode($encrypt);
  echo $val;
  return $val;
}

function search($uid){
  ini_set("allow_url_fopen", 1);
  //$uid = $_GET['uid'];
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
}
function doctorSpeciality($location, $speciality){

  ini_set("allow_url_fopen", 1);
  //$uid = $_GET['uid'];
  $url = "https://api.betterdoctor.com/2016-03-01/doctors?specialty_uid=$speciality&location=$location&skip=0&limit=10&user_key=d6fb865f0d167679bbe87e722ea09bdc";
  //echo $url;
  //echo $json;
  $data = file_get_contents($url);
  echo $data;
  $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");


  $encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB);

  $val = base64_encode($encrypt);
  echo $val;
  return $val;
}
function doctorInsurance($location, $insurance){

  ini_set("allow_url_fopen", 1);
  //$uid = $_GET['uid'];
  $url = "https://api.betterdoctor.com/2016-03-01/doctors?insurance_uid=$insurance&location=$location&skip=0&limit=10&user_key=d6fb865f0d167679bbe87e722ea09bdc";
  //echo $url;
  //echo $json;
  $data = file_get_contents($url);
  echo $data;
  $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");


  $encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB);

  $val = base64_encode($encrypt);
  echo $val;
  return $val;
}




function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "location":
      return searchLocation($request['location']);
    case "uid":
      return search($request['uid']);
    case "speciality":
      return doctorSpeciality($request['location'],$request['speciality']);
      case "insurance":
        return doctorInsurance($request['location'],$request['insurance']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}


$server = new rabbitMQServer("testRabbitMQ.ini","apiServer");


$server->process_requests('requestProcessor');
exit();
?>
