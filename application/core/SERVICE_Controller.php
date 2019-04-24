<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

class SERVICE_Controller extends REST_Controller
{
    private $ClientType;
    private $userType;
    private $Authorization;

    private $AuthLibCheck;

    private $TokenDecodeResult;
    private $TokenDecodeData;

	public function __construct()
	{
        parent::__construct();

        $this->initialize();
    }

    private function initialize()
    {

        if(strcmp($this->config->item('authorizationLibraryDenyURL'), $this->uri->slash_segment(1, 'leading').$this->uri->slash_segment(2, 'leading').$this->uri->slash_segment(3, 'leading')))
        {
            $this->AuthLibCheck = false;
        }
        else
        {
            $this->AuthLibCheck = true;
        }

        $this->ClientType = trim($this->input->get_request_header('Client-Type'));
        $this->Authorization = trim($this->input->get_request_header('Authorization'));

        if($this->ClientType == CLIENT_WEB_TYPE_CODE)
        {
            $this->userType = USER_WEB_TYPE_CODE;
        }

        switch ($this->ClientType) {
            case CLIENT_WEB_TYPE_CODE:
                $this->userType = USER_WEB_TYPE_CODE;
                break;
            case CLIENT_IOS_TYPE_CODE:
                $this->userType = USER_IOS_TYPE_CODE;
                break;
            case CLIENT_ANDROID_TYPE_CODE:
                $this->userType = USER_ANDROID_TYPE_CODE;
                break;

            default:
                # code...
                break;
        }

        if($this->AuthLibCheck == false)
        {
            $this->load->library(
                'authorization',
                [
                    'access_token' => $this->Authorization,
                    'client_type' => $this->ClientType,
                ]
            );

            $this->TokenDecodeResult = $this->authorization->getAccessTokenDecodeResult();
            $this->TokenDecodeData = $this->authorization->getAccessTokenDecodeData();
        }
    }


    public function getClientType()
    {
        return $this->ClientType;
    }

    public function getClientUserType()
    {
        return $this->userType;
    }

    public function getTokenDecodeResult()
    {
        return $this->TokenDecodeResult;
    }

    public function getTokenDecodeData()
    {
        return $this->TokenDecodeData;
    }

    public function responseOutputMaster($responseData = NULL, $responseMessage = NULL)
    {
        $payLoad = array();

        $statusPayload = [
            'status' => true
        ];

        $payLoad = array_merge($payLoad,$statusPayload);

        if($responseMessage)
        {
            $messagePayload = ['message' => $responseMessage];
            $payLoad = array_merge($payLoad,$messagePayload);
        }
        else
        {
            $messagePayload = ['message' => '정상 전송하였습니다.'];
            $payLoad = array_merge($payLoad,$messagePayload);
        }

        if($responseData)
        {
            $dataPayload = ['data' => $responseData];
            $payLoad = array_merge($payLoad,$dataPayload);
        }


        // $payLoad = convertArrayToObject($payLoad);

        REST_Controller::set_response($payLoad, REST_Controller::HTTP_OK);
    }

    public function responseErrorOutputMaster($responseMessage = NULL, $errorCode = NULL, $responseData = NULL)
    {
        $payLoad = array();

        $outPutErrorCode = '';

        if($errorCode)
        {
            $outPutErrorCode = $errorCode;
        }
        else
        {
            $outPutErrorCode = REST_Controller::HTTP_BAD_REQUEST;
        }


        $statusPayload = [
            'status' => false
        ];

        $payLoad = array_merge($payLoad,$statusPayload);

        if($responseMessage)
        {
            $messagePayload = ['message' => $responseMessage];
            $payLoad = array_merge($payLoad,$messagePayload);
        }
        else
        {
            $messagePayload = ['message' => '정상 전송하였습니다.'];
            $payLoad = array_merge($payLoad,$messagePayload);
        }

        if($responseData)
        {
            $dataPayload = ['data' => $responseData];
            $payLoad = array_merge($payLoad,$dataPayload);
        }



        REST_Controller::set_response($payLoad, $outPutErrorCode);

    }



}
