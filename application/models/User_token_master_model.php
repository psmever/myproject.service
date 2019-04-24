<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_token_master_model extends SERVICE_Model
{
    private $TABLENAME = "tbl_user_token_master";

    function __construct()
	{
		// Call the Model constructor
		parent::__construct();

    }

    public function checkUserTokenExits($params = array())
    {
        $user_token = (isset($params['user_token'])) ? $params['user_token'] : '';
        $client_type = (isset($params['client_type'])) ? $params['client_type'] : '';

        if($user_token && $client_type)
        {
            $getResult = $this->db->get_where($this->TABLENAME, array('user_token' => $user_token, 'client_type' => $client_type));
            $db_error = $this->db->error();

            if($db_error['code'])
            {
                return $this->returnModelDBError($this->db->error());
            }
            else
            {
                return $this->returnModeDataNumRowType($getResult->num_rows());
            }
        }
    }

    public function checkUserTokenExits2($params = array())
    {
        $user_uid = (isset($params['user_uid'])) ? $params['user_uid'] : '';
        $client_type = (isset($params['client_type'])) ? $params['client_type'] : '';
        $user_token = (isset($params['user_token'])) ? $params['user_token'] : '';

        if($user_token && $client_type && $user_token)
        {
            $getResult = $this->db->get_where($this->TABLENAME, array('user_uid' => $user_uid, 'client_type' => $client_type, 'user_token' => $user_token));
            $db_error = $this->db->error();

            if($db_error['code'])
            {
                return $this->returnModelDBError($this->db->error());
            }
            else
            {
                return $this->returnModeDataNumRowType($getResult->num_rows());
            }
        }
    }

    public function selectUserTokenMaster($params = array())
    {
        $user_uid = (isset($params['user_uid'])) ? $params['user_uid'] : '';

        if($user_uid)
        {
            $getResult = $this->db->get_where($this->TABLENAME, array('user_uid' => $user_uid));
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

    public function selectTokenToTable($params = array())
    {
        $user_token = (isset($params['user_token'])) ? $params['user_token'] : '';

        if($user_token)
        {
            $getResult = $this->db->get_where($this->TABLENAME, array('user_token' =>$user_token));
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

    public function updateUserTokenMaster($params = array())
    {
        $this->db->set('user_token', $params['user_token']);
        $this->db->set('user_token', $params['user_token']);
        $this->db->set('token_time', $params['token_time']);
        $this->db->set('expires_time', $params['expires_time']);
        $this->db->set('ip_address', $params['ip_address']);
        $this->db->set('update_date', 'NOW()', FALSE);
        $this->db->where('user_uid', $params['user_uid']);
        $this->db->where('client_type', $params['client_type']);
        if ($this->db->update($this->TABLENAME))
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

    public function insertUserTokenMaster($params = array())
    {
        $this->db->set('regist_date', 'NOW()', FALSE);
		if ($this->db->insert($this->TABLENAME, $params))
		{
			return $this->returnModelData(array(
					[
						'user_uid' => $this->db->insert_id()
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
