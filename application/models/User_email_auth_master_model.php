<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_email_auth_master_model extends SERVICE_Model
{
    function __construct()
	{
		// Call the Model constructor
		parent::__construct();

    }


    public function emptyTable()
    {
		if ($this->db->truncate('tbl_user_email_auth_master'))
		{
			return true;
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}
    }

    public function selectUserUidToTable($params = array())
    {
        $uesr_uid = (isset($params['user_uid'])) ? $params['user_uid'] : '';

        if($uesr_uid)
        {
            $getResult = $this->db->get_where('tbl_user_email_auth_master', array('user_uid' => $uesr_uid));
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

    public function checkAuthCodeExits($params = array())
    {
        $auth_code = (isset($params['auth_code'])) ? $params['auth_code'] : '';

        if($auth_code)
        {
            $getResult = $this->db->get_where('tbl_user_email_auth_master', array('auth_code' => $auth_code));
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

    public function updateUserEmailAuthCodeMaster($params = array())
    {
        $this->db->set('state', 'Y');
        $this->db->set('auth_date', 'NOW()', FALSE);
        $this->db->where('user_uid', $params['user_uid']);
        $this->db->where('auth_code', $params['auth_code']);
        if ($this->db->update('tbl_user_email_auth_master'))
		{
			return $this->returnModelDBSuccess();
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}
    }


    public function insertUserEmailAuthMaster($params = array())
    {
        $this->db->set('regist_date', 'NOW()', FALSE);
		if ($this->db->insert('tbl_user_email_auth_master', $params))
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


}
