<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_master_model extends SERVICE_Model
{
    private $TABLENAME = "tbl_user_master";

    function __construct()
	{
		// Call the Model constructor
		parent::__construct();

    }


    public function emptyUserMasterTable()
    {
		if ($this->db->truncate($this->TABLENAME))
		{
			return true;
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}

    }

    //
	public function getTestData()
	{
		$this->db->select('*');
		$this->db->from($this->TABLENAME);

		// echo $this->db->get_compiled_select();
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

    public function selectTableTotal()
    {
        $queryResult = $this->db->get($this->TABLENAME);
        $db_error = $this->db->error();
        if($db_error['code'])
		{
			return $this->returnModelDBError($this->db->error());
		}
		else
		{
			return $this->returnModelData($queryResult->result_array());
		}
    }

    public function getUserPassowrd($params = array())
    {
        $user_uid = trim($params['user_uid']);

        $this->db->select('user_uid');
        $this->db->select('user_password');
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

    public function updateUserPassword($params = array())
    {
        $this->db->set('user_password', $params['user_password']);
        $this->db->set('update_date', 'NOW()', FALSE);
        $this->db->where('user_uid', $params['user_uid']);
        if ($this->db->update($this->TABLENAME))
		{
			return $this->returnModelDBSuccess();
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}
    }

    public function getUserEmail($params = array())
    {
        $user_uid = trim($params['user_uid']);

        $this->db->select('user_email');
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

    public function selectUserUIDToTable($params = array())
    {
        $user_uid = trim($params['user_uid']);

        $this->db->select('user_uid, user_password, user_email, state, profile_state, email_check, user_level, user_type');
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

    public function checkUserUidExits($params = array())
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
                return $this->returnModeDataNumRowType($getResult->num_rows());
            }
        }
    }

    public function selectUserUidToStateUser($params = array())
    {
        $user_uid = trim($params['user_uid']);

        $this->db->select('user_uid, user_password, user_email, state, profile_state, email_check, user_level, user_type');
        $getResult = $this->db->get_where($this->TABLENAME, array('user_uid' => $user_uid, 'state' => 'Y'));
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

    public function selectEmailToUserMaster($params = array())
    {
        $user_email = trim($params['user_email']);

        $this->db->select('user_uid, user_password, user_email, state, profile_state, email_check, user_level, user_type');
        $getResult = $this->db->get_where($this->TABLENAME, array('user_email' => $user_email));
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

    public function checkEmailExits($params = array())
    {
        $user_email = (isset($params['user_email'])) ? $params['user_email'] : '';

        if($user_email)
        {
            $getResult = $this->db->get_where($this->TABLENAME, array('user_email' => $user_email));
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

    public function checkUserNameExits($params = array())
    {
        $user_name = (isset($params['user_name'])) ? $params['user_name'] : '';

        if($user_name)
        {
            $getResult = $this->db->get_where($this->TABLENAME, array('user_name' => $user_name));
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

    public function updateUserMasterEmailCheck($params = array())
    {
        $this->db->set('state', 'Y');
        $this->db->set('email_check', 'Y');
        $this->db->set('user_level', USER_DEFAULT_AUTH_LEVEL_CODE);
        $this->db->set('update_date', 'NOW()', FALSE);
        $this->db->where('user_uid', $params['user_uid']);
        if ($this->db->update($this->TABLENAME))
		{
			return $this->returnModelDBSuccess();
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}
    }

    public function updateUserMasterProfileState($params = array())
    {
        $this->db->set('profile_state', 'Y');
        $this->db->set('update_date', 'NOW()', FALSE);
        $this->db->where('user_uid', $params['user_uid']);
        if ($this->db->update($this->TABLENAME))
		{
			return $this->returnModelDBSuccess();
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}

    }

    public function insertUserMaster($params = array())
    {
        $this->db->set('regist_date', 'NOW()', FALSE);
		if ($this->db->insert($this->TABLENAME, $params))
		{
			return $this->returnModelDBSuccess();
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}
    }

    public function updateUserMasterUserName($user_uid = NULL, $params = array())
    {

        $this->db->set('profile_state', 'Y');
        $this->db->set('update_date', 'NOW()', FALSE);
        $this->db->where('user_uid', $user_uid);
        if ($this->db->update($this->TABLENAME, $params))
		{
			return $this->returnModelDBSuccess();
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}
    }

    public function updateTable($user_uid = NULL, $params = array())
    {
        $this->db->set('profile_state', 'Y');
        $this->db->set('update_date', 'NOW()', FALSE);
        $this->db->where('user_uid', $user_uid);
        if ($this->db->update($this->TABLENAME, $params))
		{
			return $this->returnModelDBSuccess();
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
        }

    }
}
