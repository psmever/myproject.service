<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Db extends CI_Controller {

    public function __construct($config = array())
    {
        parent::__construct();

        $this->load->model('Master_model');
        $this->load->model('Code_master_model');
        $this->load->model('User_master_model');
        $this->load->model('User_email_auth_master_model');
        $this->load->model('User_profile_master_model');
    }

    public function test()
    {
        echo "Test Ok....................\n";;
    }
    public function table_reset()
    {
        $this->Master_model->emptyAllTable();
        $this->code_reset();
    }

    public function code_reset()
    {
        $this->Master_model->foreign_key_checks_false();
        $this->Code_master_model->emptyCodeMstTable();
        $this->Master_model->foreign_key_checks_true();

        $codeGroupList = [
            ['code_id' => 'U01', 'code_name' => '사용자 구분', 'code_comment' => ''],
            ['code_id' => 'U02', 'code_name' => '사용자 레벨', 'code_comment' => ''],
            ['code_id' => 'S01', 'code_name' => '성별', 'code_comment' => ''],
	        ['code_id' => 'S02', 'code_name' => '유저 업로드', 'code_comment' => ''],
            ['code_id' => 'C01', 'code_name' => '클라이언트 타입', 'code_comment' => ' API 요청시 해당 클라이언트 타입'],
            // ['code_id' => 'S02', 'code_name' => 'Group2', 'code_comment' => '테스트 코드 \n입니다.1'],
        ];

        $codeListArray = [
            'U01' => [
                ['code_id' => '010', 'code_name' => 'web', 'code_comment' => '웹 가입 사용자' ],
                ['code_id' => '020', 'code_name' => 'iOS', 'code_comment' => 'iOS 가입 사용자'],
                ['code_id' => '030', 'code_name' => 'android', 'code_comment' => 'android 가입 사용자'],
            ],
            'U02' => [
                ['code_id' => '001', 'code_name' => '대기 사용자', 'code_comment' => '최초 가입 상태' ],
                ['code_id' => '010', 'code_name' => '일반 사용자', 'code_comment' => '인증 완료' ],
                ['code_id' => '099', 'code_name' => '일반 관리자', 'code_comment' => '보통 관리자' ],
                ['code_id' => '999', 'code_name' => '최고 관리자', 'code_comment' => '싸이트 관리자' ],
            ],
            'S01' => [
                ['code_id' => '010', 'code_name' => '남자', 'code_comment' => '성별' ],
                ['code_id' => '020', 'code_name' => '여자', 'code_comment' => '성별'],
            ],
	        'S02' => [
		        ['code_id' => '010', 'code_name' => 'profile image', 'code_comment' => '프로필 사진 업로드' ],
		        ['code_id' => '020', 'code_name' => 'post image', 'code_comment' => 'post 사진 업로드' ],
	        ],
            'C01' => [
                ['code_id' => '010', 'code_name' => 'web', 'code_comment' => '웹 클라이언트' ],
                ['code_id' => '020', 'code_name' => 'iOS', 'code_comment' => 'iOS 클라이언트'],
                ['code_id' => '030', 'code_name' => 'android', 'code_comment' => 'android 클라이언트'],
            ],

        ];


        foreach ($codeGroupList as $ckey => $value) {
            $code_id = trim($value['code_id']);
            $code_name = trim($value['code_name']);
            $code_comment = trim($value['code_comment']);

            $this->Code_master_model->insertCodeMstInfo([
                'code_id' => $code_id,
                'group_id' => '',
                'code_name' => $code_name,
                'code_comment' => $code_comment,
            ]);
        }


        foreach ($codeListArray as $group_id => $arrayValue)
        {
            foreach ($arrayValue as $ckey => $value) {
                $code_id = trim($value['code_id']);
                $group_id = trim($group_id);
                $code_name = trim($value['code_name']);
                $code_comment = trim($value['code_comment']);

                $this->Code_master_model->insertCodeMstInfo([
                    'code_id' => $group_id.$code_id,
                    'group_id' => $group_id,
                    'code_name' => $code_name,
                    'code_comment' => $code_comment
                ]);
            }

        }
        echo "\nend...........\n";
    }



}
