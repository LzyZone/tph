<?php
namespace Admin\Controller;

use Admin\Logic\MenuLogic;
use Common\Util\Tree;

/**
 * @notes       :
 * @author      : gary.Lee<321539047@qq.com>
 * @create time : 2020/5/24 9:23 上午
 * @details     :
 * @package Admin\Controller
 */
class RoleController extends AdminController {
    private $model;
	public function __construct(){
		parent::__construct();
		$this->model = D('Roles');
	}

    public function index(){
    	$where = "1=1";
    	if (!empty($_GET['role_name'])){
			$where .= " AND role_name like '%{$_GET['role_name']}%'";
		}

		$count = $this->model->where($where)->count();
    	$Page= new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
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
	        $role_name = I('post.role_name','','trim');
	        $role_info = I('post.role_info','','trim');
            $status = I('post.status',1,'intval');
            try{
                if(empty($role_name)){
                    throw new \Exception("请输入角色名称");
                }

                if(!$id && $this->model->checkRoleExists($role_name)){
                    throw new \Exception("角色{$role_name}已存在");
                }

                if($id == 1){
                    throw new \Exception("超级管理员不允许编辑");
                }

                $data = [
                    'role_name' => $role_name,
                    'role_info' => $role_info,
                    'status'    => $status
                ];
                if($id){
                    $flag = $this->model->editRole($id,$data);
                }else{
                    $flag = $this->model->addRole($data);
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
	    $data = ['status'=>1];
	    if($id == 1){
            $this->error('超级管理员不允许编辑');
        }
	    if($id){
            $data = $this->model->where(['role_id'=>$id])->find();
        }
	    $this->assign('data',$data);
        $this->display('modify');
    }

    public function priv(){
	    if(IS_POST){
            $ret = ['status'=>'n','msg'=>'操作失败'];
	        $id = I('post.id',0,'intval');
            $menu_ids = I('post.menuid');
            try{
                if(empty($id)){
                    throw new \Exception("操作失败");
                }
                if($id == 1){
                    throw new \Exception('超级管理员不允许设置权限');
                }
                $menu_list = D('Menu')->where(['id'=>['IN',$menu_ids]])
                    ->field('id,m,c,a')->select();
                if($menu_list){
                    D('RolePriv')->where(['role_id'=>$id])->delete();
                    foreach ($menu_list as $v){
                        $data = [
                            'role_id' => $id,
                            'm' => $v['m'],
                            'c' => $v['c'],
                            'a' => $v['a']
                        ];
                        D('RolePriv')->add($data);
                    }
                    $ret = ['status'=>'y','msg'=>'操作成功'];
                }
            }catch (\Exception $ex){
                $ret = ['status'=>'n','msg'=>$ex->getMessage()];
            }
            $this->ajaxReturn($ret,'JSON');
        }
	    $id = I('get.id',0,'intval');
	    if(empty($id)){
	        $this->error('操作错误');
        }
	    if($id == 1){
            $this->error('超级管理员不允许设置权限');
        }
        $priv_data = D('RolePriv')->getCMAByRoleId($id);
        $result = D('Menu')->getMenuTreeList();
        foreach ($result as $n=>$t) {
            $menu_str = $t['m'].$t['c'].$t['a'];
            $menu_str = strtolower($menu_str);
            $act = '';
            if($t['parentid']){
                $_act = '<span class="indenter" style="padding-left: 0px;"><a href="#" title="Collapse">&nbsp;</a></span>';
            }
            $result[$n]['cname'] = $act.$t['name'];
            $result[$n]['checked'] = (in_array($menu_str,(array)$priv_data))? ' checked' : '';
            $result[$n]['level'] = $this->get_level($t['id'],$result);
            //$result[$n]['parentid_node'] = ($t['parentid']) ? ' class="child-of-node-'.$t['parentid'].'"' : '';
            $result[$n]['parentid_node'] = 'data-tt-parent-id="'.$t['parentid'].'"';
        }

        $tree = new Tree();
        $tree->icon = array('│ ','├─ ','└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $str  = "<tr idk='node-\$id' data-tt-id='\$id' \$parentid_node>
							<td style='padding-left:30px;'>\$spacer<input type='checkbox' name='menuid[]' value='\$id' level='\$level' \$checked onclick='checknode(this);'> \$cname</td>
						</tr>";
        $tree->init($result);
        $tree_html = $tree->get_tree(0, $str);
        $this->assign('tree_html',$tree_html);
        $this->assign('id',$id);
        $this->display();
    }

    public function delete(){
	    $ret = ['status'=>'n','msg'=>'删除失败'];
        if(IS_AJAX){
            $role_id = I('post.key',0,'intval');
            if(empty($role_id)){
                $this->ajaxReturn($ret);
            }
            if($role_id == 1){
                $ret['msg'] = '超级管理员角色不允许删除';
                $this->ajaxReturn($ret);
            }
            $flag = $this->model->where(['role_id'=>$role_id])->delete();
            if($flag){
                $ret = ['status'=>'y','msg'=>'删除成功'];
            }
        }
        $this->ajaxReturn($ret);
    }

    /**
     * 获取菜单深度
     * @param $id
     * @param $array
     * @param $i
     */
    private function get_level($id,$array=array(),$i=0) {
        if($i >=5) return $i;
        foreach($array as $n=>$value){
            if($value['id'] == $id)
            {
                if($value['parentid']== '0') return $i;
                $i++;
                return $this->get_level($value['parentid'],$array,$i);
            }
        }
    }
}