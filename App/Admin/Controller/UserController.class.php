<?php
namespace Admin\Controller;

use Admin\Logic\UsersLogic;

/**
 * @author Gary <lizhiyong2204@sina.com>
 * @date 2015年12月14日
 * @todu
 */
class UserController extends AdminController {
    private $model;
	public function __construct(){
		parent::__construct();
		$this->model = D('Users');
   		$this->assign('role_list',D('Roles')->getMapping());
   		$this->assign('user_mapping', D('Users')->getUserMapping());
	}

    public function index(){
    	$param = array();
    	$param['username'] = I('get.username', '');
    	$param['nickname'] = I('get.nickname', '');
    	$param['role_id'] = I('get.role_id', 0,'intval');
    	$param['is_valid'] = I('get.is_valid', 0,'intval');
    	$where = "1=1";
    	if (!empty($param['username'])){
			$where .= " AND username like '%{$param['username']}%'";
		}
		if (!empty($param['nickname'])){
			$where .= " AND nickname like '%{$param['nickname']}%'";
		}
		if (!empty($param['role_id']) && $param['role_id'] != 0){
			$where .= " AND role_id = {$param['role_id']}";
		}
		if (!empty($param['is_valid'])){
            $param['is_valid'] -= 1;
			$where .= " AND is_valid = {$param['is_valid']}";
		}
		
		$count = $this->model->where($where)->count();
    	
    	$Page= new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    	$show = $Page->show();// 分页显示输出
    	$list = $this->model->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
    	
    	$this->assign('page',$show);
    	
    	$this->assign('total', $count);
    	$this->assign('list', $list);
    	$this->display(); 
    }

    public function add(){
        $this->modify();
    }

    public function edit(){
	    $this->modify();
    }

    private function modify(){
	    if(IS_POST){
	        $ret = ['status'=>'n','msg'=>'操作失败'];
	        $id = I('post.id',0,'intval');
	        $username = I('post.username','','trim');
            $role_id = I('post.role_id',0,'intval');
	        $password = I('post.password','','trim');
            $confirm_password = I('post.confirm_password','','trim');
            $nickname = I('post.nickname','','trim');
            $is_valid = I('post.is_valid',1,'intval');
            try{
                if(empty($username)){
                    throw new \Exception("请输入用户名");
                }

                if(!$id && $this->model->checkUserExists($username)){
                    throw new \Exception("用户名{$username}已存在");
                }

                if(empty($role_id)){
                    throw new \Exception("请选择角色");
                }

                if(!$id && empty($password)){
                    throw new \Exception("请输入密码");
                }

                if($password && $password != $confirm_password){
                    throw new \Exception("两次输入的密码不一致");
                }

                if($id == 1 && !$is_valid){
                    throw new \Exception("超级管理员不允许被禁用");
                }

                $data = [
                    'username' => $username,
                    'role_id'  => $role_id,
                    'nickname' => $nickname,
                    'is_valid' => $is_valid,
                ];
                if($id){
                    if(!empty($password)){
                        $data['password'] = $password;
                    }
                    $flag = $this->model->editUser($id,$data);
                }else{
                    $data['password'] = $password;
                    $flag = $this->model->addUser($data);
                }

                if($flag !== false){
                    $ret = ['status'=>'y','msg'=>'操作成功'];
                }else{
                    throw new \Exception("数据库写入失败");
                }
            }catch (\Exception $ex){
                $ret = ['status'=>'n','msg'=>$ex->getMessage()];
            }
	        $this->ajaxReturn($ret);
        }
	    $id = I('get.id',0,'intval');
	    $data = $this->model->where(['id'=>$id])->find();
	    $roles = D('Roles')->getValidRoles();
	    if($id == 1){
	        foreach ($roles as $k=>$v){
	            if($v['role_id'] > 1){
	                unset($roles[$k]);
                }
            }
        }
	    $this->assign('data',$data);
        $this->assign('role_list', $roles);
        $this->display('modify');
    }

    public function delete(){
        if(IS_AJAX){
            $id = I('post.key',0,'intval');
            if(empty($id)){
                $this->ajaxReturn(['status'=>'n','msg'=>'删除失败']);
            }

            if($id == 1){
                $this->ajaxReturn(['status'=>'n','msg'=>'超级管理员不允许被删除']);
            }

            $this->model->where(['id'=>$id])->delete();

            $this->ajaxReturn(['status'=>'y','msg'=>'删除成功']);
        }
    }
}