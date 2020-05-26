<?php
namespace Web\Controller;
use Think\Controller;

/**
 * @notes       : 用户中心基类（需要登陆是需要继承该类）
 * @author      : gary.Lee<321539047@qq.com>
 * @create time : 2020-01-09 18:35
 * @details     :
 * @package Web\Controller
 */
class BaseController extends Controller {
   protected $member_info;
   protected $noLogin = [
       'Payment' => '*'
   ];
   public function __construct(){
       parent::__construct();
       $is_login = true;
       if(isset($this->noLogin[CONTROLLER_NAME])){
           if(is_string($this->noLogin[CONTROLLER_NAME])){
               if($this->noLogin[CONTROLLER_NAME] == '*'
                   || $this->noLogin[CONTROLLER_NAME] == ACTION_NAME){
                   $is_login = false;
               }
           }else if(is_array($this->noLogin[CONTROLLER_NAME])
            && in_array(ACTION_NAME,$this->noLogin[CONTROLLER_NAME])){
                $is_login = false;
           }
       }

       if($is_login){
           $this->member_info = D('Member','Logic')->isLogin(true);
           $this->assign('member_info',$this->member_info);
       }
       
       $wx_config = C('WX_CONFIG');
       vendor('WXjssdk.jssdk');
       $jssdk = new \JSSDK($wx_config['appid'], $wx_config['appsecret']);
       $signPackage = $jssdk->getSignPackage();
       $this->assign("signPackage", $signPackage);
   }


   public function showError($err_title,$err_desc=''){
       $this->assign('err_title',$err_title);
       $this->assign('err_desc',$err_desc);
       $this->assign('page_title','错误提示');
       $this->display('Public/error');
       exit;
   }
}