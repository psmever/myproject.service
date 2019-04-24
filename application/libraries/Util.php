<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Util
{
	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();

	}

	public function __destruct()
	{
		// TODO: Implement __destruct() method.
    }

    public function test()
    {
        echo __FUNCTION__."\n";
    }

    function sendRegisterVerifyEmail($user_email = '', $authCode = '')
    {
        //Load email library
        $this->CI->load->library('email');

        //SMTP & mail configuration
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => SITE_SMTP_EMAIL_ADDRESS,
            'smtp_pass' => SITE_SMTP_EMAIL_PASSWORD,
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->CI->email->initialize($config);
        $this->CI->email->set_newline("\r\n");

        //Email content
        $view_data['confirm_url'] = base_url()."etc/v1/auth/emailauth/".urlencode($authCode);
        $emailMessage = $this->CI->load->view('template/register_send_mail', $view_data, true);

        $this->CI->email->to($user_email);
        $this->CI->email->from(SITE_SMTP_EMAIL_ADDRESS,SITE_NAME);
        $this->CI->email->subject('안녕하세요 이메일 인증해 주세요!');
        $this->CI->email->message($emailMessage);

        if($this->CI->email->send())
        {
            return true;
        }
        else
        {
            // echo $this->CI->email->print_debugger();

            return false;
        }
    }

}

?>