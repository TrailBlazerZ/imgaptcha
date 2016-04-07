<?php

$events = array("tiger", "car", "book"); //List of values to search
$url = "http://localhost:5000/image/";	//Api for image library

function httpGet($url)
{
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false); 
 
    $output=curl_exec($ch);	// the json response
 
    curl_close($ch);
    return $output;
}
function httpGetWithErros($url)	//handle errors
{
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
 
    $output=curl_exec($ch);
 
    if($output === false)
    {
        echo "Error Number:".curl_errno($ch)."<br>";
        echo "Error String:".curl_error($ch);
    }
    curl_close($ch);
    return $output;
}

$k = array_rand($events);	//pick up a random event
$v = $events[$k];

//echo httpGetWithErros($url.$v);
$result = json_decode(httpGet($url.$v));	//get a random image from library
//var_dump(json_decode($result, true));
$sz = array_rand($result->res);	//pick a random image from a random 'event' of image array
echo $result->res[$sz]->url;	//grab the image url

//echo $result;
?>