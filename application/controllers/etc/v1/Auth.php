<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends SM_Controller {

    public function __construct($config = array())
    {
        parent::__construct();

        $this->load->model('User_master_model');
        $this->load->model('User_email_auth_master_model');
    }


    public function index($params = array())
    {
        $resData = [
            'API NAME' => 'Authorize'
        ];
    }

    public function emailauth($authCode = NULL)
    {
        $emailAuthCode = trim($authCode);

        $checkResult = NULL;

        $viewData = [
            'code_check' => false,
            'code_end_check' => false,
            'auth_complate' => false,
        ];


        $selectResult = $this->User_email_auth_master_model->checkAuthCodeExits([
            'auth_code' => $emailAuthCode
        ]);

        // print_r($selectResult);exit;
        // 없는 인증 코드 일때
        if($selectResult['status'] && $selectResult['count'] == 0)
        {
            $viewData = [
                'code_check' => false
            ];

        }
        else if($selectResult['status'] && $selectResult['count'] == 1 && $selectResult['data']['state'] === 'Y') // 인증 코드는 있지만 이미 인증 받은 상태
        {
            $viewData = [
                'code_check' => true,
                'code_end_check' => false,
            ];
        }
        else if($selectResult['status'] && $selectResult['count'] == 1 && $selectResult['data']['state'] === 'N') // 인증 준비 중인 상태
        {
            $user_uid = trim($selectResult['data']['user_uid']);

            $updateResult = $this->User_email_auth_master_model->updateUserEmailAuthCodeMaster([
                'user_uid' => $user_uid,
                'auth_code' => $emailAuthCode,
            ]);

            $this->User_master_model->updateUserMasterEmailCheck([
                'user_uid' => $user_uid,
            ]);

            $viewData = [
                'code_check' => true,
                'code_end_check' => true,
                'auth_complate' => true,
            ];
        }
        else // 그밖에?
        {
            $viewData = [
                'code_check' => true,
                'code_end_check' => true,
                'auth_complate' => false,
            ];
        }

        $this->load->view('etc/v1/email_auth',$viewData);
    }

}
