<?php
namespace Admin\Logic;

class MenuLogic
{
    private $model;
    public function __construct(){
        $this->model = D('Menu');
    }

    public function getMyTree($level,$pid=0){
        $role_id = session(C('ADMIN_SESSION_NAME').'.role_id');
        $role_id = intval($role_id);
        if($role_id != 1){
            $tb_name = D('RolePriv')->getTableName();
            $menu_list = $this->model->alias('a')
                ->join("LEFT JOIN {$tb_name} as b ON a.m=b.m AND a.c=b.c AND a.a=b.a")
                ->field('a.id,a.name,a.parentid,a.m,a.c,a.a,a.iconfont')
                ->where("a.display=1 AND b.role_id={$role_id} AND b.id IS NOT NULL")
                ->order('a.listorder asc,a.id asc')
                ->select();
            return $this->formatTree($menu_list,$pid,$level);
        }
        return $this->getTree($level,$pid);
    }

    public function getTree($level,$pid=0){
        $menu_list = $this->model
                    ->field('id,name,parentid,m,c,a,iconfont')
                    ->where(['display'=>1])
                    ->order('listorder asc,id asc')
                    ->select();
        return $this->formatTree($menu_list,$pid,$level);
    }

    public function getNavMenu($pid){
        $where['display'] = 1;
        $where['id'] = $pid;
        $data = $this->model->where($where)
            ->field('id,name,parentid')
            ->find();

        if(!$data)return[];

        if($data['parentid']){
            $data[] = $this->getNavMenu($data['parentid']);
        }else{
            $data = [$data];
        }
        return $data;
    }

    private function formatTree($menu_list,$pid=0,$level=1){
        $level--;
        if(empty($menu_list) || $level < 0)return[];
        $tree = [];
        foreach ($menu_list as $k=>$v){
            if($v['parentid'] == $pid){
                $val = $v;
                unset($menu_list[$k]);
                $val['children'] = $this->formatTree($menu_list,$val['id'],$level);
                $tree[] = $val;
            }
        }
        return $tree;
    }
}