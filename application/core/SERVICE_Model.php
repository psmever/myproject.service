<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SERVICE_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();

	}

	public function __destruct()
	{
        log_message('error', 'last_query : '.$this->db->last_query());
	}

	public function returnModelDBError($params = array())
	{
		return [
			'status' => false,
			'dberror' => $params['message']
		];
	}

    public function returnModelDBSuccess($params = array())
	{
		return [
			'status' =>true,
		];
    }

	public function returnModelData($params = array())
	{
		$resultCount = count($params);

		if($resultCount === 0)
		{
			return [
				'status' => true,
                'result' => false,
                'count' => 0,
				'data' => false
			];
		}
		else if ($resultCount === 1)
		{
			$returnData = array();
			foreach ($params[0] as $itemKey => $item)
			{
				$returnData[$itemKey] = $item;
			}
			return [
                'status' => true,
                'result' => true,
				'count' => 1,
				'data' => $returnData
			];
		}
		else if ($resultCount > 1 )
		{
			return [
                'status' => true,
                'result' => true,
				'count' => $resultCount,
				'data' => $params
			];
		}
		else
		{
			log_message('error', 'setModelReturnData : '.json_encode($params));

		}
    }

    public function returnModeDataNumRowType($params = 0)
    {
        if($params === 0)
		{
			return [
				'status' => false,
				'count' => 0,
			];
		}
		else if ($params > 0)
		{
			return [
				'status' => true,
				'count' => $params,
			];
		}
		else
		{
			log_message('error', 'setModelReturnData : '.json_encode($params));

		}
    }

}
