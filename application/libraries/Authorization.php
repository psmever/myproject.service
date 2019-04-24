<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Authorization
{
	private $CI; // CI

    private $libCommand; // 라이브러리 분기

    private $client_type; // 클라이언트 타입
    private $user_uid; // 사용자 UID
    private $access_token; // access token
    private $userData; // 사용자 데이터
    private $userTokenData; // 사용자 토큰 데이터
    private $userToken; // 사용자 로그인 토큰...

    private $newAccessToken; // 생성한 accessToken Data

    private $accessTokenDecodeData; // access token decode 결과

    private $nowTime; // 현재 시간
    private $userTokenExpiresTime; // 사용자 토큰(로그인 토큰) 만료 시간
    private $accessTokenExpiresTime; // 엑세스 토큰 만료 시간
    private $client_ip; // 클라아언트 아이피

    private $userTokenExpiresResult; // 사용자 토큰(로그인 토큰) 만료 시간 체크 결과
    private $accessTokenExpiresResult; // 엑세스 토큰 만료 시간 체크 결과

    private $accessTokenMode;
    private $accessTokenRefreshState;


    public function __construct($config = array())
	{
        $this->CI =& get_instance();

        $this->libCommand = (isset($config['command']) && $config['command']) ? trim($config['command']) : false;
        $this->client_ip = $this->CI->input->ip_address();

        $this->client_type = (isset($config['client_type']) && $config['client_type']) ? trim($config['client_type']) : false;
        $this->user_uid = (isset($config['user_uid']) && $config['user_uid']) ? trim($config['user_uid']) : false;

        $this->accessToken = (isset($config['access_token']) && $config['access_token']) ? trim($config['access_token']) : false;

        $this->initialize();
    }

	public function __destruct()
	{
		// TODO: Implement __destruct() method.
	}

    // 초기화
    private function initialize()
    {
        $this->accessTokenMode = "new"; // 기본 new 로 설정

        $this->CI->load->model('User_master_model');
        $this->CI->load->model('User_token_master_model');

        $this->nowTime = strtotime("now"); // 현재 시간
        $this->userTokenExpiresTime = strtotime(SITE_USER_TOKEN_EXPIRE_STRTOTIME); // 사용자 토큰 만료 시간
        $this->accessTokenExpiresTime = strtotime(SITE_AACCESS_TOKEN_EXPIRE_STRTOTIME); // 엑세스 토큰 만료 시간

        // var_dump($this->nowTime);

        if($this->user_uid)
        {
            $this->UserData = $this->_setUserInfo($this->user_uid); // 사용자 정보 set
        }

        if($this->accessToken)
        {
            $this->accessTokenMode = "refresh";
            $this->accessTokenDecodeData = $this->_convertAccessToken($this->accessToken);
        }
    }

    // 사용자 정보 저장
    private function _setUserInfo($user_uid = NULL)
    {
        $userData = false;

        $selectResult = $this->CI->User_master_model->selectUserUidToStateUser([
            'user_uid' => $user_uid
        ]);

        if($selectResult['status'] == true && $selectResult['result'] == true)
        {
            $userData = $selectResult['data'];
        }

        return $userData;
    }

    // 사용자 토큰 정보 조회
    private function _setUserTokenData($user_uid = NULL)
    {
        $selectResult = $this->CI->User_token_master_model->selectUserTokenMaster([
            'user_uid' => $user_uid
        ]);

        if($selectResult['result'] == true)
        {
            return $selectResult['data'];

        }
        else
        {
            return false;
        }
    }

    // 사용자 토큰 만료시간 체크
    private function _checkTokenExpiresTime($checktime = NULL)
    {
        $expires_time = (isset($checktime) && $checktime) ? (int)trim($checktime) : false;

        if( $this->nowTime > $expires_time || empty($expires_time))
        {
            // 만료
            return false;
        }
        else
        {
            // 만료전
            return true;
        }
    }

    // 토큰 있는지 검사
    private function _checkTokenExits($temp_token_string = NULL)
    {
        $selectResult = $this->CI->User_token_master_model->checkUserTokenExits([
            'user_token' => $temp_token_string
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

    // 토큰 새로 발행
    private function _getNewUserToken()
    {
        do {
            $tokenString = getRandomString(50);

        } while ($this->_checkTokenExits($tokenString));

        return $tokenString;
    }

    // 사용자 토큰 인서트
    private function _insertUserToken($newToken = NULL)
    {
        $user_uid = trim($this->user_uid);
        $client_type = trim($this->client_type);
        $user_token = trim($newToken);
        $token_time = trim($this->nowTime);
        $expires_time = trim($this->userTokenExpiresTime);
        $ip_address = trim($this->client_ip);

        $insertResult = $this->CI->User_token_master_model->insertUserTokenMaster([
            'user_uid' => $user_uid,
            'client_type' => $client_type,
            'user_token' => $user_token,
            'token_time' => $token_time,
            'expires_time' => $expires_time,
            'ip_address' => $ip_address,
        ]);

        if($insertResult['result'] == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // 사용자 토큰 업데이트
    private function _updateUserToken($newToken = NULL)
    {
        $user_uid = trim($this->user_uid);
        $client_type = trim($this->client_type);
        $user_token = trim($newToken);
        $token_time = trim($this->nowTime);
        $expires_time = trim($this->userTokenExpiresTime);
        $ip_address = trim($this->client_ip);

        $updateResult = $this->CI->User_token_master_model->updateUserTokenMaster([
            'client_type' => $client_type,
            'user_token' => $user_token,
            'token_time' => $token_time,
            'expires_time' => $expires_time,
            'ip_address' => $ip_address,
            'user_uid' => $user_uid
        ]);

        if($updateResult['result'] == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // user_token 저장
    private function _saveNewToken($newUserToken = NULL)
    {
        if($this->userTokenData == false)
        {
            $this->_insertUserToken($newUserToken);
        }
        else
        {
            $this->_updateUserToken($newUserToken);
        }

        // 토큰 데이터 업데이트
        $this->userTokenData = $this->_setUserTokenData($this->user_uid);
    }

    // 로그인 토큰 발행
    private function _doNewUserToken()
    {
        $this->userTokenData = $this->_setUserTokenData($this->user_uid);

        $userTokenExpiresResult = $this->_checkTokenExpiresTime($this->userTokenData['expires_time']);

        if($userTokenExpiresResult == false)
        {
            // 새로 발행
            $newUserToken = $this->_getNewUserToken();
            $saveResult = $this->_saveNewToken($newUserToken);
        }

        // $userToken
        $this->userToken = ( isset($newUserToken) && $newUserToken ) ? $newUserToken : $this->userTokenData['user_token'];

        return true;
    }

    // accesstoken 생성
    private function _generateAccessToken($tokenData = NULL)
    {
        return JWT::encode($tokenData, SITE_TOKEN_KEY, SITE_TOKEN_ALGORITHM);
    }

    // accesstoken decode
    private function _convertAccessToken($accessToken)
    {
        try {

            $decodeData = JWT::decode($accessToken, SITE_TOKEN_KEY,array(SITE_TOKEN_ALGORITHM));

        } catch (\Throwable $th) {
            $decodeData = false;
        }

        return $decodeData;
    }

    // accesstoken 데이타 set
    private function _setAccessTokenData($tokenData = NULL)
    {
        $user_uid = trim($tokenData['user_uid']);
        $user_token = trim($tokenData['user_token']);
        $expireTime = (isset($tokenData['expireTime']) && $tokenData['expireTime']) ? trim($tokenData['expireTime']) : false;
        $client_type = trim($this->client_type);

        if($this->accessTokenMode == 'refresh')
        {
            $user_access_token_expires_time = $expireTime;
        }
        else
        {
            $user_access_token_expires_time = $this->accessTokenExpiresTime;
        }

        $this->newAccessToken = $this->_generateAccessToken([
            'user_uid' => $user_uid,
            'client_type' => $client_type,
            'user_token' => $user_token,
            'expires_time' => $user_access_token_expires_time,
        ]);
    }

    // access token 발행
    private function _doNewAccessToken()
    {
        $this->_setAccessTokenData($this->userTokenData);
    }

    // accesstoken decord 결과
    private function _doAccessTokenDecodeResult()
    {
        if($this->accessTokenDecodeData == false) return false; // 디코딩 못했을 경우
        if(strcmp($this->client_type, $this->accessTokenDecodeData->client_type) == true) return false; // client type 이 다를 경우

        return true;
    }

    // 사용자 토큰 검사
    private function _checkUserTokenExits($user_uid = NULL, $client_type = NULL, $user_token = NULL)
    {
        $selectResult = $this->CI->User_token_master_model->checkUserTokenExits2([
            'user_uid' => $user_uid,
            'client_type' => $client_type,
            'user_token' => $user_token,
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

    // access token 발행
    private function _doRefreshAccessToken()
    {
        $tokenData = $this->accessTokenDecodeData;
        // var_dump($tokenData);

        $user_uid = $tokenData->user_uid;
        $expireTime = $tokenData->expires_time;
        $client_type = $tokenData->client_type;
        $user_token = $tokenData->user_token;

        $this->user_uid = $user_uid;

        $expireTimeResult = $this->_checkTokenExpiresTime($expireTime);
        if($expireTimeResult == false)
        {
            // 만료
            // var_dump('만료');

            $result = $this->_checkUserTokenExits($user_uid, $client_type, $user_token);
            if($result == false)
            {
                return [
                    'state' => false,
                    'refresh' => false, // 만료 후 재발행
                    'result' => '0001',
                ];
            }

            $userSetResult = $this->_setUserInfo($user_uid); // 사용자 정보 set
            if($userSetResult == false)
            {
                return [
                    'state' => false,
                    'refresh' => false, // 만료 후 재발행
                    'result' => '0002',
                ];
            }

            $this->userData = $userSetResult;

            $newTokenResult = $this->_doNewUserToken();
            $result = $this->_doNewAccessToken();

            return [
                'state' => true,
                'refresh' => true, // 만료 후 재발행
                'newAccessToken' => $this->newAccessToken
            ];
        }
        else
        {
            $this->_setAccessTokenData([
                'user_uid' => $user_uid,
                'user_token' => $user_token,
                'expireTime' => $expireTime // accessToken 만 재발행 할경우 expireTime 초기화 안되게...
            ]);

            return [
                'state' => true,
                'refresh' => false, // acctoken 만 재발행
                'newAccessToken' => $this->newAccessToken
            ];
        }

        // _checkTokenExpiresTime
    }

    // 로그인 토큰 발행
    public function initNewUserLoginToken()
    {
        $result = $this->_doNewUserToken();
    }

    // 사용자 로그인 토큰 반환
    public function getUserLoginToken()
    {
        return $this->userToken;
    }

    // accessToken 생성
    public function initNewAccessToken()
    {
        $result = $this->_doNewAccessToken();
    }

    // 신규 accesstoken 반환
    public function getNewAccessToken()
    {
        return $this->newAccessToken;
    }

    // accesstoken decode 결과
    public function getAccessTokenDecodeResult()
    {
        return $this->_doAccessTokenDecodeResult();
    }

    // access token 검사
    public function initRefreshAccessToken()
    {
        $result = $this->_doRefreshAccessToken();

        if($result['state'] == false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function getAccessTokenDecodeData()
    {
        return $this->accessTokenDecodeData;
    }

}
