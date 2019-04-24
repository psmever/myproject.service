<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_profile_master_model extends SERVICE_Model
{
    private $TABLENAME = "tbl_user_profile_master";

    function __construct()
	{
		// Call the Model constructor
		parent::__construct();

    }

    public function getUserPersonalData($params = array())
    {
        $user_uid = (isset($params['user_uid'])) ? $params['user_uid'] : '';

        $this->db->select('user_phone_number');
        $this->db->select('user_web_site');
        $this->db->select('user_address');
        $queryResult = $this->db->get_where($this->TABLENAME, array('user_uid' => $user_uid));
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

    public function selectUserProfileMaster($params = array())
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

    public function updateUserProfileMasterState($params = array())
    {
        $this->db->set('state', 'Y');
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

    public function insertUserProfileMaster($params = array())
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

    public function updateTable($user_uid, $params = array())
    {
        $this->db->set('state', 'Y');
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
    
    public function updateUserProfileImage($params = array())
    {
	    $user_uid = (isset($params['user_uid'])) ? $params['user_uid'] : '';
	    
	    $this->db->set('profile_image_name', $params['profile_image_name']);
	    $this->db->set('update_date', 'NOW()', FALSE);
	    $this->db->where('user_uid', $user_uid);
	    if ($this->db->update($this->TABLENAME))
	    {
		    return $this->returnModelDBSuccess();
	    }
	    else
	    {
		    return $this->returnModelDBError($this->db->error());
	    }
    	
    }


}
