<?php
namespace Admin\Controller;
use Admin\Logic\MenuLogic;
use Think\Controller;

abstract class AdminController extends Controller {
   //跳过权限检测的方法
   private $skip_priv  = array('admin.index.index','admin.index.welcome');
   public function __construct(){
   		parent::__construct();
   		header("Content-type: text/html; charset=utf-8");
   		$this->checkLogin();
   		$this->checkPriv();
        $menu_tree = (new MenuLogic())->getMyTree(2);
        $this->assign('menu_list',$menu_tree);
   		$this->assign('sess_admin',$_SESSION[C('ADMIN_SESSION_NAME')]);
   		$this->assign('sys_title',C('SYS_TITLE'));
   }

    protected function getAdminSession($key = ''){
        $adminSession = session(C('ADMIN_SESSION_NAME'));
        if($adminSession){
            return $key ? $adminSession[$key] : $adminSession;
        }
        return false;
    }
   
   private function checkLogin(){
        if(!session('?'.C('ADMIN_SESSION_NAME')))
        {
            if(IS_AJAX){
                $this->ajaxReturn(['status'=>'n','msg'=>'请登录系统']);
            }else{
                if(CONTROLLER_NAME != 'Index'){
                    $url = U('Login/index');
                    $html = "<script type='text/javascript'>";
                    $html .= "window.top.location.href='$url'";
                    $html .= "</script>";
                    echo $html;
                    exit;
                }
                redirect(U("Login/index"));
            }
        }
    }

    private function checkPriv(){
        $module = MODULE_NAME;
        $controller = CONTROLLER_NAME;
        $action = ACTION_NAME;
        $mca = "{$module}.{$controller}.{$action}";
        $mca = strtolower($mca);

        //超级管理员直接跳过权限设置
        if($this->getAdminSession('role_id') == 1){
            return true;
        }

        //方法名以public_开头的函数，将跳过权限,ajax_开头的待定
        if(strpos($action,'public_') !== false){
            return true;
        }

        //跳过不需要检测权限方法
        if(in_array($mca,$this->skip_priv)){
            return true;
        }

        $mca = str_replace('.','',$mca);
        $userPrivs = session(C('ADMIN_SESSION_NAME').'_priv');
        if($userPrivs && in_array($mca,$userPrivs)){
            return true;
        }

        if(IS_AJAX){
            header('Content-type: application/json');
            $this->ajaxReturn(['status'=>'n','msg'=>'抱歉，无权限操作！']);
        }

        $this->error('抱歉，无权限操作！');
    }
   

    public function upload(){
    	if (!empty($_FILES)) {
    		$model = I('get.model');
    		$thumb = I('get.thumb', 0);
    		$thumb_width = I('get.thumb_width', 400);
    		$thumb_height = I('get.thumb_height', 400);
    		$tempFile = $_FILES['file']['tmp_name'];
    		$fileTypes = array('jpg','jpeg','png','gif','mp4',"js" , "pem"); // File extensions
    		$fileParts = $_FILES['file'];
    		$ex = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    		$filename  = $model."_".date('YmdHis', NOW_TIME).'.'.$ex;
    		$filename_thumb = basename($filename, ".{$ex}") . "_thumb_{$thumb_width}." . $ex;
    		$targetDir = UPLOAD_PATH . '/'. $model . '/' . date('Ymd') . '/';
    		$targetFile =  $targetDir . $filename;
    		is_dir($targetDir) OR mkdir($targetDir, 0777, true);
    		if (in_array($ex, $fileTypes)) {
    			@move_uploaded_file($tempFile,$targetFile);
    			if (file_exists($targetFile)) {
    				$filepath = '/Uploads/'.$model. '/' . date('Ymd').'/' . $filename;
    
    				if ($thumb) {
    					$image = new \Think\Image();
						$image->open($targetFile);
						$image->thumb($thumb_width, $thumb_height);
						$image->save($targetDir . $filename_thumb);
						
						if ($thumb == 2) {
							$thumb_width2 = I('get.thumb_width2', 750);
							$thumb_height2 = I('get.thumb_height2', 750);
							$filename_thumb2 = basename($filename, ".{$ex}") . "_thumb_{$thumb_width2}." . $ex;
							$image->open($targetFile);
							$image->thumb($thumb_width2, $thumb_height2);
							$image->save($targetDir . $filename_thumb2);
						}
    				}
    				$rs = array('code'=>1,'info'=>'文件上传成功!','filename'=>$filepath);
    				exit(json_encode($rs));
    			} else {
    				$rs = array('code'=>-3,'info'=>'文件上传失败!');
    				exit(json_encode($rs));
    			}
    		} else {
    			$rs = array('code'=>-2,'info'=>'请上传正确格式的文件!');
    			exit(json_encode($rs));
    		}
    	}
    
    	$rs = array('code'=>-1,'info'=>'文件上传失败!');
    	exit(json_encode($rs));
    }
   
}