<?php

function chat( WP_REST_Request $request){

    $challenge = isset($request['hub_challenge']) ? $request['hub_challenge'] : '';
    $verify_token = isset($request['hub_verify_token']) ? $request['hub_verify_token'] : 'no_token';
    // Set this Verify Token Value on your Facebook App
    if ($verify_token === 'EAAU1eRaaYtwBAGAa7aRUVEhF6RZAecKAAG2835o3OvCAybu4oCyOsZCKwHObGJ4WozGZBWRrkL0zusenoSJYhqr3lveK5I84QdYhkCVSrGNFyRYdmF6ni68oUZCZBKqqkj2BLOaLuqXZAsCpBLm2isccuDOOPjCazvokxrXvRx6gZDZD') {
      echo $challenge;
    }

    $input = json_decode( file_get_contents('php://input'), true );
    // Get the Senders Graph ID
    file_put_contents( get_home_path().'messages.txt', file_get_contents('php://input'));
    $sender = $input['entry'][0]['messaging'][0]['sender']['id'];
    // Get the returned message
    $message = $input['entry'][0]['messaging'][0]['message']['text'];
    //API Url and Access Token, generate this token value on your Facebook App Page
    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAU1eRaaYtwBAGAa7aRUVEhF6RZAecKAAG2835o3OvCAybu4oCyOsZCKwHObGJ4WozGZBWRrkL0zusenoSJYhqr3lveK5I84QdYhkCVSrGNFyRYdmF6ni68oUZCZBKqqkj2BLOaLuqXZAsCpBLm2isccuDOOPjCazvokxrXvRx6gZDZD';
    //Initiate cURL.
    $ch = curl_init($url);
    //The JSON data.
    $jsonData = '{
        "recipient":{
            "id":"' . $sender . '"
        },
        "message":{
            "text":"Hi, If you are looking for a job. visit: https://jobmemployph.tk/"
        }
    }';
    //Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);
    //Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    //Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    //Execute the request but first check if the message is not empty.
    if(!empty($input['entry'][0]['messaging'][0]['message'])){
      $result = curl_exec($ch);
    }
}


?>
