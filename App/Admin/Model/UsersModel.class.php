<?php
namespace Admin\Model;
class UsersModel extends AdminModel {
	/**
	 * 检测登录用户名和密码
	 * @param string $username 用户名
	 * @param string $password 密码
	 * @return array
	 */
	public function checkLogin($username,$password){
		$where = $result = array();
		$where['username'] = $username;
		$password = md5($password.C('ADMIN_PWD_SALT'));
		$result = $this->where($where)->find();
		if(!empty($result)){
		    if($result['password'] !== $password){
		        $this->where($where)->setInc('err_limit');
		        return ['password_error',false];
            }
            $err_limit = C('ADMIN_LOGIN_ERR_LIMIT');
		    if($result['is_valid']){
		        if($err_limit > 0 && $result['err_limit'] <= $err_limit){
                    $this->where($where)->save([
                        'last_login_time' => date('Y-m-d H:i:s'),
                        'last_login_ip' => get_client_ip(),
                        'err_limit' => 0
                    ]);
		            return ['ok',$result];
                }
                return ['limit',$result['err_limit']];
            }
			return ['deny',false];
		}
		return ['error',false];
	}

    public function checkUserExists($username){
        return $this->where(['username'=>$username])->count();
    }

    public function addUser($data){
        $data['password'] = md5($data['password'].C('ADMIN_PWD_SALT'));
        $data['create_time'] = date('Y-m-d H:i:s');
        return $this->add($data);
    }

    public function editUser($id,$data){
        if(!empty($data['password'])){
            $data['password'] = md5($data['password'].C('ADMIN_PWD_SALT'));
        }
        return $this->where(['id'=>$id])->save($data);
    }
	
	public function getUserMapping(){
		$mapping = array();
		$result = $this->field(array('id, username'))->select();
		foreach ($result as $item){
			$mapping[$item['id']] = $item['username'];
		}
		return $mapping;
	}

}

?>