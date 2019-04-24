<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct($config = array())
    {
        parent::__construct();

        $this->load->model('Master_model');
        $this->load->model('Code_master_model');
        $this->load->model('User_master_model');
        $this->load->model('User_email_auth_master_model');
        $this->load->model('User_profile_master_model');
        $this->load->model('View_master_model');
    }

    function setUserProfileState($user_uid='')
    {
        $updateResult = $this->User_profile_master_model->updateUserProfileMasterState([
            'user_uid'=> $user_uid
        ]);
    }

    function setUserMasterProfileState($user_uid='')
    {
        $updateResult = $this->User_master_model->updateUserMasterProfileState([
            'user_uid'=> $user_uid
        ]);
    }

    function doEmailAuth($authCode = '')
    {
        $emailAuthCode = trim($authCode);
        $selectResult = $this->User_email_auth_master_model->checkAuthCodeExits([
            'auth_code' => $emailAuthCode
        ]);
        $user_uid = trim($selectResult['data']['user_uid']);

        $updateResult1 = $this->User_email_auth_master_model->updateUserEmailAuthCodeMaster([
            'user_uid' => $user_uid,
            'auth_code' => $emailAuthCode,
        ]);

        $updateResult2 = $this->User_master_model->updateUserMasterEmailCheck([
            'user_uid' => $user_uid,
        ]);

        // $this->setUserProfileState($user_uid);
        // $this->setUserMasterProfileState($user_uid);
    }

    function getViewUserInfo()
    {
        return $this->View_master_model->selectTotalUserInfo();
    }

    public function emailauth($authCode = '')
    {
        $emailAuthCode = trim($authCode);

        $this->doEmailAuth($emailAuthCode);
    }

    public function totaluserinfo()
    {
        $getResult = $this->getViewUserInfo();

        print_r($getResult);
    }

    public function aemail($param = '')
    {
        // $auth_email = trim($param);
        $auth_email = 'psmever@gmail.com';

        $selectResult = $this->User_master_model->selectEmailToUserMaster([
            'user_email' => $auth_email
        ]);

        $user_uid = $selectResult['data']['user_uid'];

        $authResult = $this->User_email_auth_master_model->selectUserUidToTable([
            'user_uid' => $user_uid
        ]);

        $emailAuthCode = trim($authResult['data']['auth_code']);

        $this->doEmailAuth($emailAuthCode);
    }

    public function tmpuserinsert()
    {
        // $this->Master_model->foreign_key_checks_false();
        // $this->User_master_model->emptyUserMasterTable();
        // $this->Master_model->foreign_key_checks_true();

        $max = 5;

        for ($i=0; $i < $max; $i++)
        {
            $randomString = getRandomString(6);

            $user_id = getRandomUserUid();
            $user_email = $randomString.'@gmail.com';
            $user_name = $randomString;

            $insertResult = $this->User_master_model->insertUserMaster([
                'user_uid' => $user_id,
                'user_type' => 'U02010',
                'user_level' => USER_DEFAULT_LEVEL_CODE,
                'user_email' => $user_email,
                'user_name' => $user_name,
                'user_gender' => 'S01010',
                'user_password' => getPasswordHash('1212'),
                'state' => 'Y',
                'email_check' => 'Y',
                'profile_state' => 'Y',
                'update_date' => date('Y-m-d H:i:s')
            ]);

            $this->Master_model->insertRegisterIpLog([
                'user_uid' => $user_id,
                'ip_address' => rand(0,255).".".rand(0,255).".".rand(0,255).".".rand(0,255),
            ]);

            $this->User_profile_master_model->insertUserProfileMaster([
                'user_uid' => $user_id,
                'state' => 'Y',
                'update_date' => date('Y-m-d H:i:s')
            ]);

            $emailAuthCode = getRandomString(100);
            $this->User_email_auth_master_model->insertUserEmailAuthMaster([
                'user_uid' => $user_id,
                'auth_code' =>$emailAuthCode,
                'state' => 'Y',
                'auth_date' => date('Y-m-d H:i:s')
            ]);

            if($insertResult['status'] == true) {
                echo $user_id."..........ok............\n";
            }
            else{
                echo $user_id."..........bad............\n";
            }

        }
    }


}
