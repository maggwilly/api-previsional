<?php
namespace AppBundle\Service;
use AppBundle\Entity\Commande;
class PayementService
{
   
    private  $merchant_key='027d30fb';
    private  $currency='XAF';
    private  $id_prefix='CMD.CM.';
    private  $return_url='http://...';
    private  $cancel_url='http://...';
    private  $base_url='https://...';

const AUTORISATION_HEADERS=array(
    "accept: application/json",
    "authorization: Bearer 8kW8oVO3k67JfO2Jg2poabX4oGXa",
    "cache-control: no-cache",
    "content-type: application/json"
  );
const OM_PAY_URL ="https://api.orange.com/orange-money-webpay/cm/v1/webpayment";
const OM_TOKEN_URL = "https://api.orange.com/oauth/v2/token";

public function __construct()
{
}

public function getToken()
    {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt_array($curl, array(
  CURLOPT_URL => self::OM_TOKEN_URL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 120,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "grant_type=client_credentials",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic R3ltM0ZBMkdQSkhrTVRYTE1ySFFNd3Yxd0E5RWdHQnc6djFBZlVZNEZMME00dEV5aw=="
  ),
));

$json_response = curl_exec($curl);
$response = json_decode($json_response, true);
  return $response;
}



public function getPaimentCredentials(Commande $commande)
  {
$data = array(
  'merchant_key' =>$this->merchant_key ,
  'currency' =>$this->currency,
  'order_id' =>$this->id_prefix.$commande->getUId() ,
  'amount' =>$commande->getAmount(),
  'lang' =>'fr',
  'reference' =>'previsional',
  'notif_url' =>$this->base_url.$commande->getId()."/confirm/json",
  'return_url' =>$this->base_url.$commande->getId()."/return/json",
  'cancel_url' =>$this->base_url.$commande->getId()."/cancel/json"
  );
  $content = json_encode($data);
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt_array($curl, array(
  CURLOPT_URL => self::OM_PAY_URL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 120,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $content,
  CURLOPT_HTTPHEADER => self::AUTORISATION_HEADERS
));
;

$json_response = curl_exec($curl);
$json_response = json_decode($json_response, true);
  return  $json_response;
}

}