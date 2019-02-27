<?php
namespace AppBundle\Service;

class HttpRequestMaker
{


public function __construct()
{

}


    public function sendOrGetData($url,$data,$costum_method,$json_decode=true,$headers=array())
    {    $content ='';
        if(!is_null($data))
           $content = json_encode($data);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST , $costum_method);
        if(!is_null($data))
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ( $status != 200 ) {}
        curl_close($curl);
         if ($json_decode) 
            return json_decode($json_response, true);
        return $json_response;
    }
  

}