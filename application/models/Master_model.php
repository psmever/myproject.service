<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends SERVICE_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();

    }

    public function foreign_key_checks_false()
    {
        if ($this->db->simple_query('SET FOREIGN_KEY_CHECKS = 0'))
		{
			return true;
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}

    }

    public function foreign_key_checks_true()
    {
        if ($this->db->simple_query('SET FOREIGN_KEY_CHECKS = 1'))
		{
			return true;
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}

    }

    public function emptyAllTable()
    {
        $this->db->simple_query('SET FOREIGN_KEY_CHECKS = 0');

        $this->db->truncate('tbl_code_master');
        $this->db->truncate('tbl_user_email_auth_master');
        $this->db->truncate('tbl_user_master');
        $this->db->truncate('tbl_user_profile_master');
        $this->db->truncate('tbl_user_regist_ip_log_master');
        $this->db->truncate('tbl_user_token_master');
        $this->db->truncate('tbl_user_login_log_master');

        $this->db->simple_query('SET FOREIGN_KEY_CHECKS = 1');
    }

    // test table
	public function getTestData()
	{
		$this->db->select('*');
		$this->db->from('test`');

//		echo $this->db->get_compiled_select();
		$getResult = $this->db->get();
		$db_error = $this->db->error();

		if($db_error['code'])
		{
            echo "error";
			return $this->setModelDBError($this->db->error());
		}
		else
		{
            echo "ok";
			return $this->setModelReturnData($getResult->result_array());
		}
    }

    // 회원 가입시 ip 로그
    public function insertRegisterIpLog($params = array())
    {
        $this->db->set('regist_date', 'NOW()', FALSE);
		if ($this->db->insert('tbl_user_regist_ip_log_master', $params))
		{
			return $this->returnModelData(array(
					[
						'user_id' => $this->db->insert_id()
					]
				)
			);
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}
    }

    // 로그인 로그
    public function insertUserLoginLog($params = array())
    {
        $this->db->set('regist_date', 'NOW()', FALSE);
		if ($this->db->insert('tbl_user_login_log_master', $params))
		{
			return $this->returnModelData(array(
					[
						'user_id' => $this->db->insert_id()
					]
				)
			);
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}
    }
	
	// 사용자 업로드 로그
	public function insertUserUploadLog($params = array())
	{
		$this->db->set('regist_date', 'NOW()', FALSE);
		if ($this->db->insert('tbl_user_upload_log_master', $params))
		{
			return $this->returnModelData(array(
					[
						'user_id' => $this->db->insert_id()
					]
				)
			);
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}
	}

    // 사용자 기본 정보
    public function getUserBasicInfo($params = array())
    {
        $user_uid = (isset($params['user_uid'])) ? $params['user_uid'] : '';

        $this->db->select('tbl_user_master.user_uid');
        $this->db->select('tbl_user_master.user_name');
        $this->db->select('tbl_user_profile_master.user_gender');
        $this->db->select('tbl_user_profile_master.user_web_site');
        $this->db->select('tbl_user_profile_master.user_intro');
        $this->db->select('tbl_user_profile_master.user_birthday');
        $this->db->from('tbl_user_master');
        $this->db->join('tbl_user_profile_master', 'tbl_user_master.user_uid = tbl_user_profile_master.user_uid');
        $this->db->where('tbl_user_master.user_uid', $user_uid);
        $getResult = $this->db->get();
        $db_error = $this->db->error();

        if($db_error['code'])
        {
            return $this->returnModelDBError($this->db->error());
        }
        else
        {
            return $this->returnModelData($getResult->result_array());
        }
    }

    // 사용자 프로필 정보
    public function getUserProfileInfo($params = array())
    {
        $user_uid = (isset($params['user_uid'])) ? $params['user_uid'] : '';

        $this->db->select('tbl_user_master.user_uid');
        $this->db->select('tbl_user_master.user_name');
        $this->db->select('tbl_user_profile_master.profile_image_name');
	    $this->db->select('tbl_user_profile_master.user_birthday');
        $this->db->select('tbl_user_profile_master.user_gender');
        $this->db->select('FUNCTION_CODENAME(tbl_user_profile_master.user_gender) as user_gender_name');
        $this->db->select('tbl_user_profile_master.user_birthday');
        $this->db->select('tbl_user_profile_master.user_web_site');
        $this->db->select('tbl_user_profile_master.regist_date');
        $this->db->select('tbl_user_master.user_email');
        $this->db->select('tbl_user_profile_master.user_phone_number');
        $this->db->select('tbl_user_profile_master.user_address');
        $this->db->select('tbl_user_profile_master.user_intro');
        $this->db->from('tbl_user_master');
        $this->db->join('tbl_user_profile_master', 'tbl_user_master.user_uid = tbl_user_profile_master.user_uid');
        $this->db->where('tbl_user_master.user_uid', $user_uid);
        $getResult = $this->db->get();
        $db_error = $this->db->error();

        if($db_error['code'])
        {
            return $this->returnModelDBError($this->db->error());
        }
        else
        {
            return $this->returnModelData($getResult->result_array());
        }
    }

    public function getUserLastLoginDate($params = array())
    {
        $user_uid = (isset($params['user_uid'])) ? trim($params['user_uid']) : '';
        $client_type = (isset($params['client_type'])) ? trim($params['client_type']) : '';

        // $this->db->select('DATE_FORMAT(regist_date, \'%Y. %m.%d\') as regist_date');
        $this->db->select('regist_date');
        $this->db->order_by('regist_date', 'DESC');
        $this->db->limit(1);
        $getResult = $this->db->get_where('tbl_user_login_log_master', array(
            'user_uid' => $user_uid,
            'client_type' => $client_type,
        ));
        $db_error = $this->db->error();

        if($db_error['code'])
        {
            return $this->returnModelDBError($this->db->error());
        }
        else
        {
            return $this->returnModelData($getResult->result_array());
        }

    }

}
