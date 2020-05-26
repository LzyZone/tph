<?php
namespace Admin\Model;

class RolesModel extends AdminModel {
    public function addRole($data){
        $data['add_time'] = date('Y-m-d H:i:s');
        return $this->add($data);
    }

    public function editRole($id,$data){
        return $this->where(['role_id'=>$id])->save($data);
    }

    public function checkRoleExists($role_name){
        return $this->where(['role_name'=>$role_name])->count();
    }

    public function getMapping(){
        $role_list = $this->field('role_id,role_name')->select();
        return array_column($role_list,'role_name','role_id');
    }

    public function getValidRoles(){
        $role_list = $this->where(['status'=>1])->field('role_id,role_name')->select();
        return array_column($role_list,null,'role_id');
    }

}