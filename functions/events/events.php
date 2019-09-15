<?php
$data = [];
$data['api_key'] = 'HPCEIH6AUPQAETE5M4';
$data['client_secret'] = '65GUL34UOXVKXNMZ3SVRBKBMH7NO76NOUSEZGIPDOSKBDSQUNV';
$data['private_token'] = '66Q3KSWN7NCSAFJ7465E';
$data['public_token'] = 'E7CDRUPS2M4IIPNAUADR';
$data['request'] = '';

function genericEventsCurl($data){
  $curl = curl_init();
  curl_setopt_array($curl, array(
     CURLOPT_URL => $api_endpoint,
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_TIMEOUT => 30,
     CURLOPT_CUSTOMREQUEST => $data['request'],
     CURLOPT_POSTFIELDS => $data,
     CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json",
          "authorization: token ". $data['api_key']
     ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  if ($err) {
     $response = $err;
  }
}

function getEvents(){
  $request = 'GET';
  $data['api_endpoint'] = 'https://www.eventbriteapi.com/search/';
  genericEventsCurl($data);
}





























?>
