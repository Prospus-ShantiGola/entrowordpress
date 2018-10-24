<?php
function callWebApi($api,$postvars)
{
    //$postvars = '';
    $hdrarray=array('X-com-zoho-subscriptions-organizationid: 53121860', 'Authorization: Zoho-authtoken 42943dbb5e10abf43892ef7756b56f62');
    $url                = $api;
    $ch                 = curl_init();  
    curl_setopt($ch,CURLOPT_URL,$url);
    //curl_setopt($ch,CURLOPT_POST,1);
    //curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrarray);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
    curl_setopt($ch,CURLOPT_TIMEOUT, 20);
    echo 'aaaa'.$response = curl_exec($ch);
    
    $http_status        = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    
    
    curl_close ($ch);
    
    return $response; 
}

$returnResponce     =   array();
$data               =   array('display_name'=>'Bowman Furniture', 'first_name'=>"Benjamin",'last_name'=>'George','email'=>'benjamin.george@bowmanfurniture.com');
$options            =   http_build_query($data);
$apiPtah            =   'https://subscriptions.zoho.com/api/v1/customers';

/*echo $apiPtah;
die;
echo "<pre>";
print_r($data);
die;*/

$returnResponce     =   callWebApi($apiPtah,json_encode($data));

echo "<pre>";
print_r($returnResponce);
die;
?>