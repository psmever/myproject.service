<?php defined('BASEPATH') OR exit('No direct script access allowed');

class View_master_model extends SERVICE_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();

    }

    public function selectTotalUserInfo($params = array())
    {
        $getResult = $this->db->get('view_user_info');
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
