<?php
    // require_once __ROOT__.'/config/devel.php';
    function generateJWT($payload){
        $header = array(
            "alg"=>APP_CONFIG["jwt_alg"],
            "type"=>"JWT"
        );
        $headerJwt = base64_encode(json_encode($header));
        $payloadJwt = base64_encode(json_encode($payload));
        $signature = hash_hmac(APP_CONFIG["jwt_alg"], $headerJwt.".".$payloadJwt, APP_CONFIG["jwt_key"]);
        $JWT = $headerJwt.".".$payloadJwt.".".$signature;
        return array("token"=>$JWT);
    }

    function getJwtData($jwt){
        $splittedJwt = explode(".", $jwt);
        $payload = json_decode(base64_decode($splittedJwt[1]));
        return $payload;
    }

    function verifyJWT($jwt){
        $splittedJwt = explode(".", $jwt);
        $header = json_decode(base64_decode($splittedJwt[0]));
        $payload = json_decode(base64_decode($splittedJwt[1]));
        $signature = $splittedJwt[2];
        if ( ($signature == hash_hmac($header->alg, $splittedJwt[0].".".$splittedJwt[1], APP_CONFIG["jwt_key"])) && (time() <= $payload->exp)){
            return $payload->user_id;
        };
    }

    function generateRandomString($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

?>