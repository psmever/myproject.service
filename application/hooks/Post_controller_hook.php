<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_controller_hook {

    private $CI;
    private $Authorization;
    private $ClientType;

    private $GLOBAL_VARS;

    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
    }

    public function startHook()
    {
        $this->endHook();
    }

    private function endHook()
    {

    }

}

?>