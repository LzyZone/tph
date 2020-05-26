<?php
namespace Common\Util\Wechat\Sdk;
use Think\Log;

/**
 * @notes       : 微信jssdk
 * @author      : gary.Lee<321539047@qq.com>
 * @create time : 2020-01-11 22:16
 * @details     :
 * @package Common\Util\Wechat\Sdk
 */
class JsSdk
{
    private $auth_base_url = 'https://open.weixin.qq.com/';
    private $api_base_url = 'https://api.weixin.qq.com/';
    private $appid;
    private $secret;
    private $err_code;
    private $err_msg;

    public function __construct($appid,$secret)
    {
        $this->appid = $appid;
        $this->secret = $secret;
    }

    /**
     * 第一步 授权
     * @param $redirect_url
     * @param string $scope
     */
    public function authorize($redirect_url=null,$scope='snsapi_userinfo'){
        if(!$redirect_url){
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $redirect_url = "{$protocol}{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        }
        $redirect_url = urlencode($redirect_url);
        $url = $this->auth_base_url.'connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=STATE#wechat_redirect';
        $url = sprintf($url,$this->appid,$redirect_url,$scope);
        header("Location: {$url}");exit;
    }

    /**
     * 第二步获取授权access_token
     * @param $code
     * @return bool | array
     */
    public function accessToken($code){
        $url = $this->api_base_url."sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code";
        $url = sprintf($url,$this->appid,$this->secret,$code);
        $result = $this->httpGet($url);
        if(empty($result))return false;
        $result = json_decode($result,true);
        if(isset($result['errcode'])){
            $this->setError($result['errcode'],$result['errmsg']);
            return false;
        }
        /*
         * {
              "access_token":"ACCESS_TOKEN",
              "expires_in":7200,
              "refresh_token":"REFRESH_TOKEN",
              "openid":"OPENID",
              "scope":"SCOPE"
           }
         */
        return $result;
    }

    /**
     * 刷新授权access_token
     * @param $refresh_token
     * @return array|bool|mixed|object|\stdClass|string
     */
    public function refreshToken($refresh_token){
        $url = $this->api_base_url."sns/oauth2/refresh_token?appid=%s&grant_type=refresh_token&refresh_token=%s";
        $url = sprintf($url,$this->appid,$refresh_token);
        $result = $this->httpGet($url);
        if(empty($result))return false;
        $result = json_decode($result,true);
        if(isset($result['errcode'])){
            $this->setError($result['errcode'],$result['errmsg']);
            return false;
        }
        /*
         * {
              "access_token":"ACCESS_TOKEN",
              "expires_in":7200,
              "refresh_token":"REFRESH_TOKEN",
              "openid":"OPENID",
              "scope":"SCOPE"
           }
         */
        return $result;
    }

    /**
     * 第三步获取用户信息
     * @param $access_token
     * @return array|bool|mixed|object|\stdClass|string
     */
    public function userInfo($access_token){
        $url = $this->api_base_url."sns/userinfo?access_token=%s&openid=%s&lang=zh_CN";
        $url = sprintf($url,$access_token,$this->appid);
        $result = $this->httpGet($url);
        if(empty($result))return false;
        $result = json_decode($result,true);
        if(isset($result['errcode'])){
            $this->setError($result['errcode'],$result['errmsg']);
            return false;
        }
        /**
         * {
                "openid":" OPENID",
                "nickname": NICKNAME,
                "sex":"1",
                "province":"PROVINCE",
                "city":"CITY",
                "country":"COUNTRY",
                "headimgurl":       "http://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
                "privilege":[ "PRIVILEGE1" "PRIVILEGE2"     ],
                "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
            }
         */
        return $result;
    }

    public function getError(){
        return [$this->err_code,$this->err_msg];
    }

    private function setError($err_code,$err_msg){
        $this->err_code = $err_code;
        $this->err_msg = $err_msg;
        Log::write("wechat_auth_error,err_code:{$err_code},err_msg:{$err_msg}");
    }



    public function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__).'/cacert.pem');
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

}