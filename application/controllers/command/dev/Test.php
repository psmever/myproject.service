<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct($config = array())
    {
        parent::__construct();

        $this->load->model('Master_model');
        $this->load->model('Code_master_model');
        $this->load->model('User_master_model');
        $this->load->model('User_token_master_model');


        echo "\n";

    }

    public function __destruct()
    {
        echo "\n\n";
    }


    public function test()
    {
        $this->util->test();
    }

    public function randstring()
    {
        $this->load->library('email');

        echo getRandomString(100);

        echo "\n";
    }

    public function mailtest()
    {
        // $this->load->library('encrypt');
        //Load email library
        $this->load->library('email');

        //SMTP & mail configuration
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'psmever@gmail.com',
            'smtp_pass' => '!Mingun2018',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");

        //Email content
        $htmlContent = '<h1>Sending email via SMTP server</h1>';
        $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';

        $this->email->to('mingun78@castnet.co.kr');
        $this->email->from('psmever@gmail.com','myproject');
        $this->email->subject('How to send email via SMTP server in CodeIgniter');
        $this->email->message($htmlContent);

        //Send email
        $this->email->send();
        echo $this->email->print_debugger();
    }

    public function authmail()
    {
        $this->load->library('common_lib');

        $registerEmail = "psmever@gmail.com";
        $registerConfirmEmailCode = "TzCUOw3pB8ryIsJTovC4m8IGhrgDGdxje6keyIMuoSrdnXy5WxgRtndQnOASXh7z8Cm9grwJdsbvZZ19i5Nbs96GTTniMcPvrYna";

        $this->common_lib->sendRegisterVerifyEmail($registerEmail, $registerConfirmEmailCode);


        echo __FUNCTION__."......................end \n";
    }

    public function timecheck()
    {
        $nowTime = strtotime("now");
        $expiryTime = strtotime("SITE_USER_TOKEN_EXPIRE_STRTOTIME");

        $nowTime2 = time();



        echo $nowTime2."\n";
        echo $nowTime."\n";
        echo $expiryTime."\n";

//1553223281

        echo date('Y-m-d H:i:s', $nowTime);
        echo "\n";
    }

    function key_exists($user_token = '')
    {
        $this->load->model('User_token_master_model');

        $selectResult = $this->User_token_master_model->checkUserTokenExits([
            'user_token' => $user_token
        ]);


        if($selectResult['count'] == 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function genkey()
    {
        do {
            $genkey = getRandomString(200);

        } while ($this->key_exists($genkey));

        // echo $this->key_exists($genkey)."\n";



        echo "\n";
    }

    public function stringcheck()
    {
        $string1 = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX3VpZCI6ImQzMWViOGNmYTc4NmY2YjRkMDI0IiwidXNlcl90b2tlbiI6InZIS2hnNnB4Znpab0lVZ3pmaVBNNnlyYW5jM3V3SnZkVWFtamx5dkFjVThkeGtrM2hKIiwidXNlcl9sZXZlbCI6IlUwMjAxMCIsInRva2VuX3RpbWUiOjE1NTM2MTE5OTgsInRva2VuX2V4cGlyeV90aW1lIjoxNTUzNjEyNTk4fQ.9KKp7QFOGRxsXNXoJ2DyG12jTlNeWO7PMvcdL1Vtt6c';
        $string2 = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX3VpZCI6ImQzMWViOGNmYTc4NmY2YjRkMDI0IiwidXNlcl90b2tlbiI6InZIS2hnNnB4Znpab0lVZ3pmaVBNNnlyYW5jM3V3SnZkVWFtamx5dkFjVThkeGtrM2hKIiwidXNlcl9sZXZlbCI6IlUwMjAxMCIsInRva2VuX3RpbWUiOjE1NTM2MTE5OTgsInRva2VuX2V4cGlyeV90aW1lIjoxNTUzNjEyNTk4fQ.9KKp7QFOGRxsXNXoJ2DyG12jTlNeWO7PMvcdL1Vtt6c';


        $string1 = 'asd';
        $string2 = 'asd1';


        var_dump(strcmp($string1, $string2));
    }


    public function text()
    {
        $url = "htPP://daum.net";

        echo getUserProfileWebSiteItem($url);



    }
}
