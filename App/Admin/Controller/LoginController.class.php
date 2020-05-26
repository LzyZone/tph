<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller {
	private $_verify_config = array(
		'length' => 4,
		'fontSize' => 28,
		'useCurve'=>false
	);
	private $verify = null;
	public function __construct(){
		parent::__construct();
		$this->verify =   new \Think\Verify($this->_verify_config);
	}
	
    public function index(){
    	if(session('?'.C('ADMIN_SESSION_NAME'))){
    		redirect(U("Index/index"));
    	}
    	$this->assign("web_title",'系统登录');
    	$this->display("Public/login");
    }
      
    public function checkLogin(){
    	$_return_data = array('msg'=>'登录失败','status'=>'n','url'=>'');
    	if(IS_POST && IS_AJAX){
    		$username = I("post.username");
    		$password = I("post.password");    		
    		$code = I("post.code");
    		$username = trim($username);
    		$password = trim($password);
    		if(!$this->verify->check($code)){
    			$_return_data['status'] = 'n';
    			$_return_data['msg'] = '验证码错误';
    			$this->ajaxReturn($_return_data);
    		}
    		list($is_login,$result) = D('Users')->checkLogin($username,$password);
            switch ($is_login){
                case 'ok':
                    $_return_data['status'] = 'y';
                    $_return_data['msg'] = '登录成功';
                    $_return_data['url'] = U("Index/index");
                    $this->_setSession($result);
                    break;
                case 'password_error':
                    $_return_data['status'] = 'n';
                    $_return_data['msg'] = '密码输入错误';
                    break;
                case 'deny':
                    $_return_data['status'] = 'n';
                    $_return_data['msg'] = '账号被禁止登陆，请联系管理人员';
                    break;
                case 'error':
                    $_return_data['status'] = 'n';
                    $_return_data['msg'] = '用户名或密码错误';
                    break;
                case 'limit':
                    $_return_data['status'] = 'n';
                    $_return_data['msg'] = '登陆失败，登陆失败次数已达上线';
                    break;
            }
    	}
    	$this->ajaxReturn($_return_data);
    }
	
    
    /**
     * 生成验证码
     */
    public function verify(){    	
    	$Verify = new \Think\Verify($this->_verify_config);
    	$Verify->entry();
    }
    
    /**
     * 退出
     */
    public function loginOut(){
    	sys_act_log("退出系统");
        $session_name = C('ADMIN_SESSION_NAME');
    	session($session_name,null);
    	redirect(U("Login/index"));
    }
    
    /**
     * 设置session
     * @param array $user
     */
    private function _setSession(array $user){
        $session_name = C('ADMIN_SESSION_NAME');
        //为了安全起见，不允许缓存密码
    	unset($user['password']);
    	$user['role_name'] = D('Roles')->where(['role_id'=>$user['role_id']])->getField('role_name');
    	session($session_name,$user);

    	$my_priv = D('RolePriv')->getCMAByRoleId($user['role_id']);
        if($my_priv){
            session($session_name.'_priv',$my_priv);
        }
        sys_act_log('登陆系统');
    }
   
    
}