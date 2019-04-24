<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Imageprocess
{
	private $CI; // CI
	
	private $user_uid; // 업로드 사용자 아이디
	private $client_type; // 클라이언트 타입
	private $image_source = array(); // 아미지 원본
	
	private $image_process_result = array(); // 처리 결과
	
    public function __construct($config = array())
	{
        $this->CI =& get_instance();
        
		$this->client_type = (isset($config['client_type']) && $config['client_type']) ? trim($config['client_type']) : false;
		$this->user_uid = (isset($config['user_uid']) && $config['user_uid']) ? trim($config['user_uid']) : false;
		$this->image_source = (isset($config['image_source']) && $config['image_source']) ? $config['image_source'] : false;
        
        $this->initialize();
    }

	public function __destruct()
	{
		// TODO: Implement __destruct() method.
	}

    // 초기화
    private function initialize()
    {
	    $this->CI->load->model('User_profile_master_model');
    
    }
    
    private function useImageLibraries($libConfig = array())
    {
		$this->CI->load->library('image_lib', $libConfig);
		if(!$this->CI->image_lib->resize())
		{
			return [
				'status' => false,
				'data' => $this->CI->image_lib->display_errors()
			];
		}
		$this->CI->image_lib->clear();
		
		return [
			'status' => true
		];
	}
	
	public function updateUserProfileImage($imageName = NULL)
	{
		if(empty($imageName)) return false;
		
		return $this->CI->User_profile_master_model->updateUserProfileImage([
			'user_uid' => $this->user_uid,
			'profile_image_name' => $imageName
		]);
	}
	
  
    public function doProfileImageProcessing()
    {
    	$nowTime = time();
    	$source_image = $this->image_source['full_path'];
    	$new_image_filename = $nowTime.'_'.$this->user_uid.'_profile_image'.$this->image_source['file_ext'];
    	$new_target_directory = SITE_PROFILE_IMAGE_DIR.'/'.$this->user_uid;
    	
	    makeDirectory($new_target_directory);
    	
    	$doResult = $this->useImageLibraries([
                'image_library' => 'gd',
                'source_image' => $source_image,
                'new_image' => $new_target_directory.'/'.$new_image_filename,
                'maintain_ratio' => TRUE,
                'width' => 200,
                'height' => 200,
		]);
    	
    	if($doResult['status'] == true)
    	{
    		$this->image_process_result = [
    			'status' => true,
			    'data' => [
			    	'image_file_name' => $new_image_filename,
				    'image_url' => SITE_PROFILE_IMAGE_URL.'/'.$this->user_uid.'/'.$new_image_filename
				]
		    ];
	    }
    	else
	    {
		    $this->image_process_result = [
		    	'status' => false
		    ];
	    }
    }
    
    public function getProfileImageProcessResult()
    {
    	return $this->image_process_result;
    }
}
