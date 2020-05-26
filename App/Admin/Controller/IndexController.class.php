<?php
namespace Admin\Controller;

class IndexController extends AdminController {
    public function index(){
       $this->display(); 
    }
    
    public function welcome(){
    	$this->display();
    }
}