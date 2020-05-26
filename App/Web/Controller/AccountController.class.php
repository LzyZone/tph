<?php
namespace Web\Controller;
use Common\Util\Wechat\Sdk\JsSdk;
use Think\Controller;

/**
 * @notes       : 用户登陆/注册/退出 控制器
 * @author      : gary.Lee<321539047@qq.com>
 * @create time : 2020-01-08 18:25
 * @details     :
 * @package Web\Controller
 */
class AccountController extends Controller {
    /**
     * 登陆
     */
	public function login(){
        if(IS_POST){
            $login_number = I('post.login_number','','trim');
            $login_password = I('post.login_password','','trim');
            $ret = ['status'=>'n','info'=>'登陆失败！'];
            try{
                if(!preg_match('/^1\d{10}$/',$login_number,$matches)){
                    throw new \Exception("请输入正确的手机号码！");
                }

                if(empty($login_password)){
                    throw new \Exception("请输入密码！");
                }

                if(strlen($login_password) < 6){
                    throw new \Exception("密码长度至少需要6个字符！");
                }

                $member_logic = D('Member','Logic');
                $result = $member_logic->login($login_number,$login_password);

                if($result){
                    $ret = ['status'=>'y','info'=>'登陆成功！'];
                    $member_logic->setSession($result);
                }
            }catch (\Exception $ex){
                $ret['info'] = $ex->getMessage();
            }
            $this->ajaxReturn($ret,'JSON');
        }
        $this->assign('page_title','用户登陆');
        $this->display();
    }

    public function login_wx(){
        $wechat_config = C('WX_CONFIG');
        //$wechat_config['appid'] = 'wxd266a3ee0d56ccfd';
        //$wechat_config['appsecret'] = 'd5ca4c35af39d0f2b3b43b0247383dbe';
        $jssdk = new JsSdk($wechat_config['appid'],$wechat_config['appsecret']);
        $cache_key = session_id().'_access_token';
        if($cache_key && $cache_key != '_access_token'){
            $access_token = S($cache_key);
            $err_msg = '';
            if($access_token){
                $user_info = $jssdk->userInfo($access_token);
                if($user_info){
                    $member_logic = D('Member','Logic');
                    $ret = $member_logic->loginWx($user_info['openid'],$user_info);
                    if($ret){
                        $member_logic->setSession($ret);
                        redirect('/Web/Member/index');exit;
                    }
                }
                //清空无效缓存
                S($cache_key,null);
            }
        }


        if(empty($_GET['code'])){
            $jssdk->authorize();
        }else{
            $ac_data = $jssdk->accessToken($_GET['code']);
            if($ac_data){
                //设置access_token缓存
                S($cache_key,$ac_data['access_token'],$ac_data['expires_in']-300);

                $user_info = $jssdk->userInfo($ac_data['access_token']);
                if($user_info){
                    $member_logic = D('Member','Logic');
                    $ret = $member_logic->loginWx($user_info['openid'],$user_info);
                    if($ret){
                        $member_logic->setSession($ret);
                        redirect('/Web/Member/index');exit;
                    }
                }else{
                    list(,$err_msg) = $jssdk->getError();
                }
            }else{
                list(,$err_msg) = $jssdk->getError();
            }

            $this->assign('err_msg',$err_msg);
            $this->assign('page_title','用户登陆');
            $this->display();
        }
    }

    /**
     * 注册
     */
    public function register(){
	    if(IS_POST){
            $login_number = I('post.login_number','','trim');
            $login_password = I('post.login_password','','trim');
            $login_password2 = I('post.login_password2','','trim');
            $ret = ['status'=>'n','info'=>'注册失败！'];
            try{
                if(!preg_match('/^1\d{10}$/',$login_number,$matches)){
                    throw new \Exception("请输入正确的手机号码！");
                }

                if(empty($login_password)){
                    throw new \Exception("请输入密码！");
                }

                if(strlen($login_password) < 6){
                    throw new \Exception("密码长度至少需要6个字符！");
                }

                if(empty($login_password2)){
                    throw new \Exception("请输入确认密码！");
                }

                if($login_password2 != $login_password){
                    throw new \Exception("两次密码输入不匹配！");
                }

                $member_logic = D('Member','Logic');
                $result = $member_logic->register($login_number,$login_password);
                if($result){
                    $ret = ['status'=>'y','info'=>'注册成功！'];
                    $member_logic->setSession($result);

                }
            }catch (\Exception $ex){
                $ret['info'] = $ex->getMessage();
            }
            $this->ajaxReturn($ret,'JSON');
        }
        $this->assign('page_title','用户注册');
		$this->display();
	}

    /**
     * 登出
     */
	public function login_out(){
        $member_logic = D('Member','Logic');
        $member_logic->loginOut();
        redirect('/Web/Account/login');
    }

}