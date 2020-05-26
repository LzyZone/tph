<?php
/**
 * Created by PhpStorm.
 * User: lizhiyong
 * Date: 2017/11/5
 * Time: 上午9:01
 */
namespace Admin\Model;
use Think\Model;

/**
 * @notes       : 后台数据库模型，所有后台数据库模型需要继承该模型
 * @author      : gary.Lee<321539047@qq.com>
 * @create time : 2020/5/24 9:25 上午
 * @details     :
 * @package Admin\Model
 */
class AdminModel extends Model{
    protected $connection = 'db_admin';
}