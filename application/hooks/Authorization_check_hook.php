<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authorization_check_hook {

    private $CI;
    private $Authorization;
    private $ClientType;

    private $GLOBAL_VARS;

    function __construct()
    {
        $this->CI =& get_instance();
    }

    public function startHook()
    {
        // $this->checkAuthorizationToken();
        //

        $this->setHeaderInfo();


        $this->endHook();
    }

    private function setHeaderInfo()
    {
        $this->ClientType = trim($this->CI->input->get_request_header('Client-Type'));

    }

    private function endHook()
    {

    }

    private function checkAuthorizationToken()
    {
        // $this->Authorization = trim($this->CI->input->get_request_header('Authorization'));

        if(!empty($this->Authorization))
        {
            // $this->CI->load->library(
            //     'authorization',
            //     [
            //         'command' => 'refreshToken',
            //         'nowToken' => $this->Authorization
            //     ]
            // );

            // $libCheckResult = $this->CI->authorization->checkResult();
            // if($libCheckResult['state'] == true)
            // {
            //     //
            //     $this->CI->authorization->saveNewToken();
            // }
            // else
            // {
            //     //
            //     echo $libCheckResult['result'];
            // }
            // $this->CI->authorization->saveNewToken();

            // print_r($libResult);

            // $nowTokenData = $this->CI->authorization->getNowTokenDecode();
            // $newTokenData = $this->CI->authorization->getNewTokenInfo();

            // $newToken = $this->CI->authorization->getNewToken();
            // $newTokenTime = $this->CI->authorization->getNewTokenTime();
            // $newTokenExpiryTime = $this->CI->authorization->getNewTokenExpiryTime();


            // getNowTokenDecode
            // echo $newToken;
            // print_r($nowTokenData);
            // print_r($newTokenData);

            // print_r($newTokenExpiryTime);

        }
        else
        {

        }
    }




}

?>