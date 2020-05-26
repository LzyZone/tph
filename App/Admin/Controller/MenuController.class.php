<?php
namespace Admin\Controller;
use Common\Util\Tree;

/**
 * @notes       :
 * @author      : gary.Lee<321539047@qq.com>
 * @create time : 2020/5/24 9:23 上午
 * @details     :
 * @package Admin\Controller
 */
class MenuController extends AdminController {
    private $model;
	public function __construct(){
		parent::__construct();
		$this->model = D('Menu');
	}

    public function index(){
        $tree = new Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $result = $this->model->order('listorder asc,id asc')->select();
        $res_data = array();
        foreach ($result as $v){
            $v['manage'] = '';
            if(!$this->model->where(['id'=>$v['parentid']])->getField('parentid')){
               $v['manage'] = "<a href='javascript:x_admin_open(\"添加菜单\",\"add?act=add&id=".$v['id']."\",700,360);' title='添加菜单'><i class='Hui-iconfont'>&#xe600;</i></a>&nbsp;&nbsp;";
            }
            $v['manage'] .= "<a href='javascript:x_admin_open(\"编辑菜单\",\"edit.html?act=edit&id=".$v['id']."\",700,360);'><i class='Hui-iconfont'>&#xe60c;</i></a> &nbsp;<a href='javascript:admin_del(\"delete\",".$v['id'].",\"是否删除菜单[".$v['name']."]?\");' title='删除'><i class='Hui-iconfont'>&#xe609;</i></a>";
            $res_data[] = $v;
        }
        $str  = "<tr class='text-c'>
                <td>\$id</td>
                <td style='text-align: left;'>\$spacer \$name</td>
                <td class='td-manage'>\$manage</td>
                </tr>";
        $tree->init($res_data);
        $menu_html = $tree->get_tree(0, $str);
        $this->assign('menu_html',$menu_html);
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
            $data = [];
            $id = I('post.id');
            $data['parentid'] = I('post.parentid',0,'intval');
            $data['name'] = I('post.name','','trim');
            $data['m'] = I('post.menu_m','','trim');
            $data['c'] = I('post.menu_c','','trim');
            $data['a'] = I('post.menu_a','','trim');
            $data['data'] = I('post.data','','trim');
            $data['display'] = I('post.display',1,'intval');
            $data['listorder'] = I('post.listorder',99,'intval');
            $data['iconfont'] = I('post.iconfont','','trim');
            try{
                if(empty($data['name'])){
                    throw new \Exception("请输入菜单名称");
                }
                if(empty($data['m'])){
                    throw new \Exception("请输入模块名");
                }
                if(empty($data['c'])){
                    throw new \Exception("请输入文件名");
                }
                if(empty($data['a'])){
                    throw new \Exception("请输入方法名");
                }
                if($id){
                    $flag = $this->model->where(['id'=>$id])->save($data);
                }else{
                    $flag = $this->model->add($data);
                }
                if($flag !==false){
                    $ret = ['status'=>'y','msg'=>'操作成功'];
                }else{
                    throw new \Exception("数据库写入失败");
                }
            }catch (\Exception $ex){
                $ret = ['status'=>'n','msg'=>$ex->getMessage()];
            }
            $this->ajaxReturn($ret,'JSON');
        }
        $id = I('get.id',0,'intval');
        $act = I('get.act','');
        $def_data = $data = [
            'name' => '',
            'm' => '',
            'c' => '',
            'a' => '',
            'data' => '',
            'iconfont' => '',
            'display' => 1,
            'listorder' => 99
        ];

        if(!empty($id)){
            $data = $this->model->where(['id'=>$id])->find();
        }
        $tree = new Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

        $pid_list = $this->model->where(['parentid'=>0])->field('id')->select();
        $pid_list = array_column($pid_list,'id');
        $pid_list[] = 0;
        $result = $this->model->where(['parentid'=>['IN',$pid_list]])->order('listorder asc,id asc')->select();
        $array = array_column($result,null,'id');
        $str  = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
        if($act == 'edit'){
            $select_id = isset($data['parentid']) ? $data['parentid'] : 0;
        }else{
            $select_id = isset($data['id']) ? $data['id'] : 0;
        }
        $menu_html = $tree->get_tree(0, $str,$select_id);
        $this->assign('data',$act == 'edit' ? $data : $def_data);
        $this->assign('menu_html',$menu_html);
        $this->display('modify');
    }

    public function delete(){
	    $ret = ['status'=>'n','msg'=>'删除失败'];
        if(IS_AJAX){
            $id = I('post.key',0,'intval');
            if(empty($id)){
                $this->ajaxReturn($ret);
            }
            $this->model->delAllChildren($id);
            $ret = ['status'=>'y','msg'=>'删除成功'];
        }
        $this->ajaxReturn($ret);
    }
}