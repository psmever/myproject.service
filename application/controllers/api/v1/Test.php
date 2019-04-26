<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
use \Firebase\JWT\JWT;

class Test extends REST_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        //$this->load->view('welcome_message');
        $this->load->database();



        $query = $this->db->query('SELECT * FROM myproject.tbl_user_master ');
        $row = $query->row_array();

        print_r($row);
    }

    public function index_get()
    {
        $indexData = [
            'url' => 'http://myproject/service',
            'cliect IP' => $_SERVER['REMOTE_ADDR']
        ];

        $this->response($indexData, REST_Controller::HTTP_OK);

    }

    public function error_get()
    {
        $indexData = [
            'url' => 'http://myproject/service',
            'cliect IP' => $_SERVER['REMOTE_ADDR']
        ];

        $this->response($indexData, REST_Controller::HTTP_BAD_REQUEST);

    }
    
    public function dir_get()
    {
	    var_dump(APP_BASE_URL);
	    var_dump(SITE_UPLOAD_DIR);
	    var_dump(SITE_UPLOAD_URL);
	    var_dump(SITE_IMAGE_DIR);
	    var_dump(SITE_IMAGE_URL);
	    var_dump(SITE_PROFILE_IMAGE_DIR);
	    var_dump(SITE_PROFILE_IMAGE_URL);
	    var_dump(SITE_POST_IMAGE_DIR);
	    var_dump(SITE_POST_IMAGE_URL);
	    var_dump(SITE_RESOURCE_URL);
	    var_dump(SITE_DEFAULT_PROFILE_IMAGE_URL);
    }
    public function userid_get()
    {
        $registerUser_uid_type1 = uniqid();
        $registerUser_uid_type2 = uniqid (rand(), true);
        $registerUser_uid_type3 = md5(uniqid(rand(), true));


        // $resultItem = [
        //     'type1' => var_dump($registerUser_uid_type1),
        //     'type2' => var_dump($registerUser_uid_type2),
        //     'type3' => var_dump($registerUser_uid_type3),
        // ];
        // $this->response($resultItem, REST_Controller::HTTP_OK);


        var_dump($registerUser_uid_type1);
        var_dump($registerUser_uid_type2);
        var_dump($registerUser_uid_type3);

    }

    public function userlist_get()
    {
        $this->load->model('View_master_model');

        $selectResult = $this->View_master_model->selectTotalUserInfo();

        REST_Controller::set_response([
            'message' => '정상 전송 하였습니다.',
			'result' => $selectResult
        ], REST_Controller::HTTP_OK);
        return;

    }

    public function helper_get()
    {

        echo var_dump(getRandomString());

    }

    public function ip_get()
    {
        echo $this->input->ip_address();
        $this->server('REMOTE_ADDR');
    }


    public function token_get()
    {
        // 토큰 생성
        $this->load->library('authorization', [
            'option' => 'newToken',
            'user_uid' => 'fa8cc0b3ceb1082819f0'
        ]);


        $this->authorization->getNewToken();
    }

    function convertTimeToString($timestamp = NULL)
    {
        if(!ctype_digit($timestamp))
        {
            $timestamp = strtotime($timestamp);
        }

        $diff = time() - $timestamp;
        if($diff == 0)
        {
            return 'now';
        }
        elseif($diff > 0)
        {
            $day_diff = floor($diff / 86400);
            if($day_diff == 0)
            {
                if($diff < 60) return 'just now';
                if($diff < 120) return '1 minute ago';
                if($diff < 3600) return floor($diff / 60) . ' minutes ago';
                if($diff < 7200) return '1 hour ago';
                if($diff < 86400) return floor($diff / 3600) . ' hours ago';
            }
            if($day_diff == 1) { return 'Yesterday'; }
            if($day_diff < 7) { return $day_diff . ' days ago'; }
            if($day_diff < 31) { return ceil($day_diff / 7) . ' weeks ago'; }
            if($day_diff < 60) { return 'last month'; }

            return date('F Y', $timestamp);
        }
        else
        {
            $diff = abs($diff);
            $day_diff = floor($diff / 86400);
            if($day_diff == 0)
            {
                if($diff < 120) { return 'in a minute'; }
                if($diff < 3600) { return 'in ' . floor($diff / 60) . ' minutes'; }
                if($diff < 7200) { return 'in an hour'; }
                if($diff < 86400) { return 'in ' . floor($diff / 3600) . ' hours'; }
            }
            if($day_diff == 1) { return 'Tomorrow'; }
            if($day_diff < 4) { return date('l', $timestamp); }
            if($day_diff < 7 + (7 - date('w'))) { return 'next week'; }
            if(ceil($day_diff / 7) < 4) { return 'in ' . ceil($day_diff / 7) . ' weeks'; }
            if(date('n', $timestamp) == date('n') + 1) { return 'next month'; }

            return date('F Y', $timestamp);
        }
    }

    function telNumberAddHyphen($telnumber = NULL)
    {
        if($telnumber == false) return false;

        $tel = preg_replace("/[^0-9]/", "", $telnumber);    // 숫자 이외 제거
        if (substr($tel,0,2)=='02')
        {
            return preg_replace("/([0-9]{2})([0-9]{3,4})([0-9]{4})$/", "\\1 - \\2 - \\3", $tel);
        }
        else if (strlen($tel)=='8' && (substr($tel,0,2)=='15' || substr($tel,0,2)=='16' || substr($tel,0,2)=='18'))
        {
            // 지능망 번호이면
            return preg_replace("/([0-9]{4})([0-9]{4})$/", "\\1 - \\2", $tel);
        }
        else
        {
            return preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1 - \\2 - \\3", $tel);
        }
    }

    public function toy_get()
    {
//	    var_dump(base_url());
//
//	    var_dump($this->config->item('site_default_url'));
//	    var_dump($this->config->site_url());
//
	    
	    var_dump(APP_BASE_URL);
	    var_dump(APP_IMAGE_BASE_URL);
	    var_dump(FCPATH);
	
	

    }
    
    
    public function server_get()
    {
    	echo "server111";
    }

}
