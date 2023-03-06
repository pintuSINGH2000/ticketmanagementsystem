
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TicketSystem extends CI_Controller{
    private $CI;

    public function __construct()
    {
        parent::__construct();
    }
    function abc(){
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://weatherapi-com.p.rapidapi.com/current.json?q=".$GLOBALS['city'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: ".$GLOBALS['host'],
                "X-RapidAPI-Key: " .$GLOBALS['key']
            ],
        ]);
        
        $manage = curl_exec($curl);
        $response = json_decode($manage, true);
        $err = curl_error($curl);
        
        curl_close($curl);
        $temp=array(
            'userid'=> $GLOBALS['password'],
            'temp' => $response['current']['temp_c']
        );
            $this->load->model('Data');
            $result=$this->Data->updateTime($temp);
    }
        
}
   
?>