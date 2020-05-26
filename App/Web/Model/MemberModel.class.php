<?php
namespace Web\Model;

use Think\Model;

class MemberModel extends Model
{
    public function getData($mem_id,$fields='*'){
        $fields = is_array($fields) ? implode(',',$fields) : $fields;
        return $this->where(['id'=>$mem_id])->field($fields)->find();
    }
}