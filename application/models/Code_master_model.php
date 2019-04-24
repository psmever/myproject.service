<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Code_master_model extends SERVICE_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();

    }

    // 코드 테이블 초기화
    public function emptyCodeMstTable()
    {
		if ($this->db->truncate('tbl_code_master'))
		{
			return true;
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}

    }

    // 코드 정보 저장
	public function insertCodeMstInfo($params = array())
	{
		$this->db->set('regist_date', 'NOW()', FALSE);
		$this->db->set('update_date', 'NOW()', FALSE);
		if ($this->db->insert('tbl_code_master', $params))
		{
            // echo $this->db->last_query();
			return true;
		}
		else
		{
			return $this->returnModelDBError($this->db->error());
		}
    }


    public function selectCodeMstInfo($params = array())
	{
		$this->db->select('code_id');
		$this->db->select('code_name');
		$this->db->from('tbl_code_master');

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

    public function selectTable($params = array())
	{
		$this->db->select('code_id');
		$this->db->select('group_id');
		$this->db->select('code_name');
		$this->db->select('code_comment');
        $this->db->from('tbl_code_master');
        $this->db->where('state', 'Y');

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
}
