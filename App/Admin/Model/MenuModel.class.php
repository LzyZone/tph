<?php
/**
 * Created by PhpStorm.
 * User: lizhiyong
 * Date: 2017/11/5
 * Time: 上午9:01
 */
namespace Admin\Model;
class MenuModel extends AdminModel {
    public function getValidMenu(){
        return $this->where(['display'=>1])->select();
    }

    public function getMenuTreeList(){
        return $this->where(['display'=>1])
            ->field('id,name,parentid,m,c,a')
            ->order('listorder asc,id asc')
            ->select();
    }

    public function delAllChildren($id){
        $flag = false;
        $flag = $this->where(array('id'=>$id))->delete();
        if($flag){
            $childIds = $this->where(array('parentid'=>$id))->field('id')->select();
            if(!$childIds){return false;}
            foreach ($childIds as $k=>$v){
                $flag = $this->delAllChildren($v['id']);
            }
        }
        return $flag;
    }
}