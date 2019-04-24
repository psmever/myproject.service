<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pre_controller_hook {

    private $CI;
    private $Authorization;
    private $ClientType;

    private $GLOBAL_VARS;

    function __construct()
    {
        $this->CI =& get_instance();
    }

    public function startHook()
    {
        $this->setHeaderInfo();


        $this->endHook();
    }

    private function setHeaderInfo()
    {
    }

    private function endHook()
    {

    }

}

?>