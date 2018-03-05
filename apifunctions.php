#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function searchLocation($location){
  ini_set("allow_url_fopen", 1);
  //$uid = $_GET['uid'];
  $url = "https://api.betterdoctor.com/2016-03-01/doctors?location=$location&skip=0&limit=10&user_key=d6fb865f0d167679bbe87e722ea09bdc";
  //echo $url;
  //echo $json;
  $data = file_get_contents($url);
  echo $data;
  return $data;
}

function search($uid){
  ini_set("allow_url_fopen", 1);
  //$uid = $_GET['uid'];
  $url = "https://api.betterdoctor.com/2016-03-01/doctors/$uid?user_key=d6fb865f0d167679bbe87e722ea09bdc";
  //echo $url;
  //echo $json;
  $data = file_get_contents($url);
  echo $data;
  return $data;
}
function doctorPractices($practices,$location,$limit){

  ini_set("allow_url_fopen", 1);
  //$uid = $_GET['uid'];
  $url = "https://api.betterdoctor.com/2016-03-01/practices?name=$practices&location=$location&skip=0&limit=$limit&user_key=d6fb865f0d167679bbe87e722ea09bdc";
  //echo $url;
  //echo $json;
  $data = file_get_contents($url);
  echo $data;
  return $data;
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
    case "search":
      return search($request['uid']);
    case "practices":
      return doctorPractices($request['practices'],$request['location'],$request['limit']);

  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","apiServer");

$server->process_requests('requestProcessor');
exit();
?>
