<?php
namespace Web\Model;

use Think\Model;

class AreaModel extends Model
{
    public function getProvinceList(){
        $list = $this->where(['area_parent_id'=>0])->field('area_id,area_name')
            ->order('area_sort asc')->select();
        return array_column($list,'area_name','area_id');
    }

    public function getMapping(){
    	if (S('area_mapping')) {
    		return S('area_mapping');
    	}
    	$mapping = array();
    	$list = $this->where("1=1")->order('area_sort asc')->select();
    	foreach ($list as $item){
    		$mapping[$item['area_id']] = $item['area_name'];
    	}
    	S('area_mapping', $mapping, 24*60*60);
    	return $mapping;
    }
    
    public function getAreaNode(){
    	if (S('area_node')) {
    		return S('area_node');
    	}
    	
    	$province_list = $this->where("area_parent_id = 0")->field('area_id as value, area_name as label')->order('area_sort asc')->select();
    	
    	foreach ($province_list as &$province){
    		$city_list = $this->where("area_parent_id = {$province['value']}")->field('area_id as value, area_name as label')->order('area_sort asc')->select();
    		
    		foreach ($city_list as &$city){
    			$area_list = $this->where("area_parent_id = {$city['value']}")->field('area_id as value, area_name as label')->order('area_sort asc')->select();
    			$city['children'] = $area_list;
    		}
    		$province['children'] = $city_list;
    	}
    	S('area_node', $province_list, 24*60*60);
    	return $province_list;
    }
}