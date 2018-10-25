<?php

include_once('./classes/DataLoad.php');

$q=$_GET["q"];

$data=new DataLoad();

$data->laadWerknemers();
$werknemers=$data->getWerknemers();
$response=[];

foreach ($werknemers as &$werknemer) {
  if(strpos(strtolower($werknemer['naam']),strtolower($q))!==false){
    array_push($response,$werknemer);
  }
}

echo json_encode($response);

?>