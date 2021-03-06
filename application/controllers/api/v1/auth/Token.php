<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Token extends SERVICE_Controller {

    public function __construct($config = array())
    {
        parent::__construct();

        log_message('debug', json_encode($this->post()));
    }

    public function __destruct()
    {
        parent::__destruct(); // TODO: Change the autogenerated stub
    }


    public function access_token_post()
    {
        $access_token = trim($this->post('access_token'));

        if(empty($access_token))
        {
            parent::responseErrorOutputMaster(
                '토큰 정보가 없습니다.'
            );
            return;
        }

        $this->load->library(
            'authorization',
            [
                'access_token' => $access_token,
                'client_type' => parent::getClientType(),
            ]
        );

        $tokenDecordResult = $this->authorization->getAccessTokenDecodeResult();

        if($tokenDecordResult == false)
        {
            parent::responseErrorOutputMaster(
                '정상 적인 토큰이 아닙니다.'
            );
            return;
        }

        $refreshResult = $this->authorization->initRefreshAccessToken();

        if($refreshResult == false)
        {
            parent::responseErrorOutputMaster(
                '정상 적인 토큰이 아닙니다.'
            );
            return;
        }

        $accessToken = $this->authorization->getNewAccessToken();
        parent::responseOutputMaster(
            [
                'old_access_token' => $access_token,
                'access_token' => $accessToken,
            ],
            '정상 전송 하였습니다.'
        );
    }
}
