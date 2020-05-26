<?php
namespace Admin\Model;

class RolePrivModel extends AdminModel {
    public function getCMAByRoleId($role_id){
        $result = $this->where(array('role_id'=>$role_id))->field('CONCAT(m,c,a) as priv')->select();
        if($result){
            $data = array();
            foreach ($result as $k=>$v){
                $data[] = strtolower($v['priv']);
            }
            return $data;
        }
        return false;
    }
}