<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*
|--------------------------------------------------------------------------
| SITE Directory URL Define
|--------------------------------------------------------------------------
*/

defined('SITE_RESOURCE_URL')							            OR define('SITE_RESOURCE_URL', APP_BASE_URL.'/resource');

defined('SITE_UPLOAD_DIR')							                OR define('SITE_UPLOAD_DIR', APP_DOCUMENT_ROOT.'/upload');
defined('SITE_UPLOAD_URL')							                OR define('SITE_UPLOAD_URL', APP_BASE_URL.'/upload');

defined('SITE_IMAGE_DIR')							                OR define('SITE_IMAGE_DIR', APP_DOCUMENT_ROOT.'/image');
defined('SITE_IMAGE_URL')							                OR define('SITE_IMAGE_URL', APP_BASE_URL.'/image');

defined('SITE_PROFILE_IMAGE_DIR')							        OR define('SITE_PROFILE_IMAGE_DIR', SITE_IMAGE_DIR.'/profile');
defined('SITE_PROFILE_IMAGE_URL')							        OR define('SITE_PROFILE_IMAGE_URL', SITE_IMAGE_URL.'/profile');

defined('SITE_POST_IMAGE_DIR')							            OR define('SITE_POST_IMAGE_DIR', SITE_IMAGE_DIR.'/post');
defined('SITE_POST_IMAGE_URL')							            OR define('SITE_POST_IMAGE_URL', SITE_IMAGE_URL.'/post');

defined('SITE_DEFAULT_PROFILE_IMAGE_URL')                           OR define('SITE_DEFAULT_PROFILE_IMAGE_URL', SITE_RESOURCE_URL.'/img/default_profile.png');
/*
|--------------------------------------------------------------------------
| SITE Define
|--------------------------------------------------------------------------
*/

defined('SITE_NAME')							                    OR define('SITE_NAME', 'myproject'); // 싸이트 명

defined('SITE_PASSWORD_DEFAULT')							        OR define('SITE_PASSWORD_DEFAULT', 'myproject_'); // password_hash KEY
defined('SITE_TOKEN_KEY')      								        OR define('SITE_TOKEN_KEY', 'vyqJuA/qNwkttc5dW1u1mWaV7vAiHuqTp9kVzgLT'); // JWT Key
defined('SITE_TOKEN_ALGORITHM')      						        OR define('SITE_TOKEN_ALGORITHM', 'HS256'); // JWT encode decode Algorithm
defined('SITE_TOKEN_EXPIRE_STRTOTIME') 						        OR define('SITE_TOKEN_EXPIRE_STRTOTIME', '+1 minutes');

defined('SITE_USER_TOKEN_EXPIRE_STRTOTIME') 						OR define('SITE_USER_TOKEN_EXPIRE_STRTOTIME', '+120 minutes'); // 사용자 토큰 만료 시간
defined('SITE_AACCESS_TOKEN_EXPIRE_STRTOTIME') 						OR define('SITE_AACCESS_TOKEN_EXPIRE_STRTOTIME', '+1 minutes'); // 엑세스 토큰 만료 시간

defined('SITE_RAND_CODE_LENGTH')      						        OR define('SITE_RAND_CODE_LENGTH', '50'); // 랜덤 코드 길이

defined('USER_WEB_TYPE_CODE')      						            OR define('USER_WEB_TYPE_CODE', 'U01010'); // 웹 가입 회원 타입 코드
defined('USER_IOS_TYPE_CODE')      						            OR define('USER_IOS_TYPE_CODE', 'U01020'); // 웹 가입 회원 타입 코드
defined('USER_ANDROID_TYPE_CODE')      						        OR define('USER_ANDROID_TYPE_CODE', 'U01030'); // 웹 가입 회원 타입 코드

defined('CLIENT_WEB_TYPE_CODE')      						        OR define('CLIENT_WEB_TYPE_CODE', 'C01010'); // 웹 가입 회원 타입 코드
defined('CLIENT_IOS_TYPE_CODE')      						        OR define('CLIENT_IOS_TYPE_CODE', 'C01020'); // 사용자 기본 가입 레벨 코드
defined('CLIENT_ANDROID_TYPE_CODE')      						    OR define('CLIENT_ANDROID_TYPE_CODE', 'C01030'); // 사용자 기본 가입 레벨 코드

defined('USER_DEFAULT_LEVEL_CODE')      						    OR define('USER_DEFAULT_LEVEL_CODE', 'U02001'); // 사용자 기본 가입 레벨 코드
defined('USER_DEFAULT_AUTH_LEVEL_CODE')      						OR define('USER_DEFAULT_AUTH_LEVEL_CODE', 'U02010'); // 사용자 기본 가입 레벨 코드

defined('SITE_SMTP_EMAIL_ADDRESS')      						    OR define('SITE_SMTP_EMAIL_ADDRESS', 'psmever@gmail.com'); // 싸이트 SMTP 이메일 주소
defined('SITE_SMTP_EMAIL_PASSWORD')      						    OR define('SITE_SMTP_EMAIL_PASSWORD', '!Mingun2018'); // 싸이트 SMTP 이메일 패스워드

defined('DEFAULT_PROFILE_IMAGE_URL')      						    OR define('DEFAULT_PROFILE_IMAGE_URL', '/resource/img/default_profile.png'); // 싸이트 SMTP 이메일 패스워드
