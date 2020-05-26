<?php
/**
 * 记录操作日志
 * 用户操作日志
 * @param String $msg
 */
function sys_act_log($msg){
    $session_name = C('ADMIN_SESSION_NAME');
	$data_log = array();
	$data_log['module'] 	= MODULE_NAME;
	$data_log['file'] 		= CONTROLLER_NAME;
	$data_log['action'] 	= ACTION_NAME;
	$data_log['querystring'] = __SELF__;
	$data_log['data'] 		= $msg;
	if(session('?'.$session_name)){
        $data_log['userid'] 	= $_SESSION[$session_name]['id'];
        $data_log['username'] 	= $_SESSION[$session_name]['username'];
    }else{
        $data_log['userid'] 	= 0;
        $data_log['username'] 	= '';
    }
	$data_log['ip'] 		= get_client_ip();
	$data_log['time'] 	= date('Y-m-d H-i-s',NOW_TIME);
	M('log','','db_admin')->add($data_log);
}

//获取系统是间 格式2016-8-19 10:20:34
function get_now_date(){
	return date('Y-m-d H:i:s',NOW_TIME);
}

/**
 * 导出CSV文件
 * @param array $data        数据
 * @param array $header_data 首行数据
 * @param string $file_name  文件名称
 * @return string
 */
function export_csv_1($data = array(), $header_data = array(), $file_name = '')
{
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $file_name);
    if (!empty($header_data)) {
        echo iconv('utf-8','gbk//TRANSLIT','"'.implode('","',$header_data).'"'."\n");
    }
    foreach ($data as $key => $value) {
        $output = array();
        $output[] = $value['id'];
        $output[] = $value['name'];
        echo iconv('utf-8','gbk//TRANSLIT','"'.implode('","', $output)."\"\n");
    }
}
/**
 * 导出CSV文件
 * @param array $data        数据
 * @param array $header_data 首行数据
 * @param string $file_name  文件名称
 * @return string
 */
function export_csv_2($data = array(), $header_data = array(), $file_name = '')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename='.$file_name);
    header('Cache-Control: max-age=0');
    $fp = fopen('php://output', 'a');
    if (!empty($header_data)) {
        foreach ($header_data as $key => $value) {
            $header_data[$key] = iconv('utf-8', 'gbk', $value);
        }
        fputcsv($fp, $header_data);
    }
    $num = 0;
    //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
    $limit = 100000;
    //逐行取出数据，不浪费内存
    $count = count($data);
    if ($count > 0) {
        for ($i = 0; $i < $count; $i++) {
            $num++;
            //刷新一下输出buffer，防止由于数据过多造成问题
            if ($limit == $num) {
                ob_flush();
                flush();
                $num = 0;
            }
            $row = $data[$i];
            foreach ($row as $key => $value) {
                $row[$key] = iconv('utf-8', 'gbk', $value);
            }
            fputcsv($fp, $row);
        }
    }
    fclose($fp);
}

function area_name($area_id){
    static $areas = [];
    if(isset($areas[$area_id])){
        return $areas[$area_id];
    }
    $area_name = M('area')->where(['area_id'=>$area_id])->getField('area_name');
    $areas[$area_id] = $area_name ? $area_name : '未知';
    return $area_name;
}

/**
 * 获取导航路径
 * @return string
 */
function get_nav_title(){
    $where = [
        'c'=>CONTROLLER_NAME,
        'a'=>ACTION_NAME,
        'display'=>1
    ];
    $data = D('menu')->where($where)
        ->field('id,name,parentid')
        ->find();
    $parent_data = (new \Admin\Logic\MenuLogic())->getNavMenu($data['parentid']);
    $data = array_merge($parent_data,[$data]);
    $nav_title = '<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页';
    foreach ($data as $k=>$v){
        $nav_title .= "<span class=\"c-gray en\">&gt;</span> {$v['name']}";
    }
    $nav_title .= '<a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>';
    return $nav_title;
}

?>