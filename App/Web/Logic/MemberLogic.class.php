<?php
namespace Web\Logic;

use Think\Model;

/**
 * @notes       : 用户逻辑处理类
 * @author      : gary.Lee<321539047@qq.com>
 * @create time : 2020-01-08 18:21
 * @details     :
 * @package Web\Logic
 */
class MemberLogic extends Model
{
    /**
     * 用户注册
     * @param int|string $login_number 手机号码
     * @param string $login_password 用户密码
     * @return array|bool
     * @throws \Exception
     */
    public function register($login_number,$login_password){
        if($this->checkPhoneExists($login_number)){
            throw new \Exception("抱歉，该手机号已被注册！");
        }
        /*这种密码强度高点
        $salt = C('MEMBER_PASSWORD_SALT');
        $login_password = md5($login_password.$salt);
        */
        $login_password = md5($login_password);
        $data = [
            'login_number'      => $login_number,
            'login_password'    => $login_password,
            'name'              => '手机用户'.substr($login_number,-4),
            'cellphone'         => $login_number,
            'create_time'       => time(),
            'login_time_last'   => time()
        ];
        $ret = $this->add($data);
        unset($data['login_password']);
        if($ret){
            $data['id'] = $ret;
            return $data;
        }
        return false;
    }

    /**
     * @param string $wx_openid 微信openid
     * @param array $wx_info 微信用户信息
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
     * @return array|bool
     */
    private function registerByWx($wx_openid,$wx_info){
        $data = [
            'login_number'      => '',
            'login_password'    => '',
            'wx_openid'         => $wx_openid,
            'name'              => x_isset($wx_info,'nickname'),
            'sex'               => x_isset($wx_info,'sex',0),
            'headpic'           => x_isset($wx_info,'headimgurl'),
            'create_time'       => time(),
            'login_time_last'   => time(),
        ];
        $ret = $this->add($data);
        unset($data['login_password']);
        if($ret){
            $data['id'] = $ret;
            return $data;
        }
        return false;
    }

    /**
     * 微信登陆/注册
     * @param string $wx_openid 微信openid
     * @param array $wx_info 微信用户信息
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
     * @return array|bool|false|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function loginWx($wx_openid,$wx_info){
        $member_data = $this->where(['wx_openid'=>$wx_openid])->find();
        if(empty($member_data)){
            $member_data = $this->registerByWx($wx_openid,$wx_info);
        }else{
            $this->updateLoginTimeLast($member_data['id']);
        }
        return $member_data;
    }

    private function updateLoginTimeLast($id){
        return $this->where(['id'=>$id])->setField('login_time_last',time());
    }

    /**
     * 用户登陆
     * @param int|string $login_number 手机号码
     * @param string $login_password 密码
     * @return array|false|mixed|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($login_number,$login_password){
        $login_password = md5($login_password);
        $where = [
            'login_number'      => $login_number,
            'is_delete'         => 0
        ];
        //$fields = 'id,login_password,is_valid';
        $member_data = $this->where($where)->find();
        if(empty($member_data)){
            throw new \Exception("用户名/或密码错误!");
        }

        if($member_data['login_password'] != $login_password){
            throw new \Exception("用户名/或密码错误!");
        }

        if(!$member_data['is_valid']){
            throw new \Exception("您已被禁止登陆，请联系管理员!");
        }
        unset($member_data['login_password']);
        $this->updateLoginTimeLast($member_data['id']);
        return $member_data;
    }

    /**
     * 检测手机号是否存在
     * @param int|string $phone 手机号码
     * @return int 1--存在,0--不存在
     * @throws \think\Exception
     */
    public function checkPhoneExists($phone){
        $cnt = $this->where(['login_number'=>$phone])->count();
        return intval($cnt);
    }

    public function checkWxExists($wx_openid){
        $cnt = $this->where(['wx_openid'=>$wx_openid])->count();
        return intval($cnt);
    }

    public function flushSession(){
        $member_sess = session('member_sess');
        if($member_sess){
            $data = $this->where(['id'=>$member_sess['id']])->find();
            return $this->setSession($data);
        }
        return false;
    }

    /**
     * 设置用户session
     * @param array $data 用户member表数据
     * @return bool
     */
    public function setSession($data){
        if(empty($data['id']))return false;
        $fields = ['id','login_number','wx_openid',
            'wx_name','wx_headpic','name','headpic','wx_number'];
        foreach ($data as $k=>$v){
            if(!in_array($k,$fields)){
                unset($data[$k]);
            }
        }
        session('member_sess',$data);
        return true;
    }

    /**
     * 检查是否登陆
     * @param bool $redirect 是否跳转
     * @return bool|mixed|null
     */
    public function isLogin($redirect=false){
        $member_sess = session('member_sess');
        if($member_sess){
            return $member_sess;
        }

        if($redirect){
            if(IS_AJAX){
                $this->ajaxReturn(['status'=>'n','info'=>'请登录'],'JSON');
            }else{
                redirect('/Web/Account/login');
            }
        }else{
            return false;
        }
    }

    /**
     * 退出登陆
     * @return bool|mixed|null
     */
    public function loginOut(){
        return session('member_sess',null);
    }


}