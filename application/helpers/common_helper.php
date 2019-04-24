<?php defined('BASEPATH') OR exit('No direct script access allowed');


//랜덤한 사용자 아이디 생성
function getRandomUserUid()
{
    return bin2hex(random_bytes(10));
}

// 패스워드 해시
function getPasswordHash($plaintext = '')
{
	return password_hash(SITE_PASSWORD_DEFAULT . $plaintext, PASSWORD_DEFAULT);
}

// 해스워드 해시 체크
function getPasswordVerify($password = '', $hash_text = '')
{
	return password_verify(SITE_PASSWORD_DEFAULT . $password, $hash_text);
}

// 특수 기호 포함 랜덤한 문자열 반환
function getRandCode($length = SITE_RAND_CODE_LENGTH)
{
	return base64_encode(openssl_random_pseudo_bytes($length));
}

// 특수 기호 포함 랜덤한 문자열 반환
function getRandString()
{
	return hash('sha256', mt_rand());
}

// permitted_chars 이용 랜덤한 문자열 반환
function getRandomString($strength = 16)
{
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $input_length = strlen($permitted_chars);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;

}

// 이메일 형식 체크
function userEmailValidCheck($email_string = '')
{
    if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email_string))
    {
        return false;
    }
    else
    {
        return true;
    }
}

// 사용자 이름 첫번째 단어 체크
function userNameFirstWordCheck($user_name_string = '')
{
    if(!preg_match("/^[a-z]/i", $user_name_string)) {
        return false;
    }
    else
    {
        return true;
    }
}

// 사용자 이름 형식 체크
function userNameValidCheck($user_name_string = '')
{
    if(!preg_match("/^[a-z0-9_-]{3,16}$/" , $user_name_string)){

        return false;
    }
    else
    {
        return true;
    }
}

// 패스워드 체크
function userPasswordValidCheck($password_string = '')
{
    if(!preg_match('/^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/' , $password_string))
    {
        return false;
    }
    else
    {
        return true;
    }
}

// 배열을 object 타입으로
function convertArrayToObject($defs)
{
    $innerfunc = function ($a) use ( &$innerfunc )
    {
        return (is_array($a)) ? (object) array_map($innerfunc, $a) : $a;
    };

    return (object) array_map($innerfunc, $defs);
}


// 생년월일 표시 1
function convertBirthNumberToBirthDayType1($birthNumber = NULL)
{
    return substr($birthNumber, 0, 4).'. '.substr($birthNumber, 4, 2).'. '.substr($birthNumber, 6, 2);
}

// 생년월일 분리 배열 반환
function convertBirthNumberToBirthDay($birthNumber = NULL)
{
    return [
        'y' => substr($birthNumber, 0, 4),
        'm' => substr($birthNumber, 4, 2),
        'd' => substr($birthNumber, 6, 2)
    ];
}

// mysql datetime convert
function convertMysqlDateTimeType1($mysqlDateTime = NULL)
{
    return strtotime($mysqlDateTime);
}
function convertMysqlDateTimeType2($mysqlDateTime = NULL)
{
    return date('Y. m. d', strtotime($mysqlDateTime));
}

// timestamp 를 문자열 시간형식으로 반환
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

// 전화번호에 하이픈 추가
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

// br, 엔터에 p 테그 추가
function textLineAddPtag($plain_text)
{
    if(empty($plain_text)) return false;

    $tmp_plain_text = trim($plain_text);

    $tmp_plain_text = nl2br($tmp_plain_text);
    $tmp_plain_text = explode("<br />",$tmp_plain_text);

    $tmp_out_put_text = "";

    foreach($tmp_plain_text as $arrayValue)
    {
        $lineText = trim($arrayValue);
        $lineText = preg_replace('/[\x00-\x1F\x7F]/', '', $lineText);
        if(!empty($lineText))
        {
            $tmp_out_put_text .= '<p>'.$lineText.'</p>'.PHP_EOL;

        }
        else
        {
            $tmp_out_put_text .= PHP_EOL;

        }
    }

    $returnText = trim($tmp_out_put_text);

    return $returnText;
}

// http https 삭제
function getUserProfileWebSiteItem($urlString = NULL)
{
    if($urlString == NULL) return false;

    try {
        //code...
        preg_match("/(http|https):\/\/(.*?)$/i", $urlString ,$match);
        if( isset($match[2]) && $match[2] )
        {
            $match[2];
        }
        else
        {
            return $urlString;
        }
    } catch (\Throwable $th) {
        return false;
    }
}

// tag all delete
function strip_tags_content($text) {
    return strip_tags($text);
}

// user profile only number
function getProfilePhoneNumber($phoneString = NULL) {
    try {
        //code...
        return preg_replace("/[^0-9]/", "",$phoneString);
    } catch (\Throwable $th) {
        //throw $th;
        return false;
    }
}

// 디렉토리 없으면 생성
function makeDirectory($targetDirectory = NULL)
{
	if(empty($targetDirectory)) return false;
	
	
	if(!is_dir($targetDirectory)) mkdir($targetDirectory, 0777, TRUE);
	
	return true;
	
}

?>