<?php

class HomeAction extends Action {
	
	
    public function index(){
	
    	$info = M('admin')->find();
    	
//     	print_r($info);
    	
    	
    }

    function Login(){
    	
    	
    	if($_POST){
    		$getData = array(
    				'plugin'	=> 'System',
    				'action'	=> 'WindowsDomainAction',
    				'entry'		=> 'getAdInfo',
    				 
    		);
    		$postData = array(
    				'username'	=> $_POST['username'],
    				'password'	=> $_POST['password'],
    		);
    		$info = WebService('pe', 'Plugin', 'entry', $getData, $postData);
    		 
    		if($info['status']=='1'){
    			//     		print_r($info);
    			
    			$_SESSION['admin']['info'] = $info;
    			$this->redirect("/home/main");
    		}else{
    			$this->assign('status','0');
    			$this->assign('msg',$info['msg']);
    		}
    	}
    	
		
    	
    	$this->display('/login');
    }
    
    function main(){
    	
    	
    	
    	
    	
    	$this->display('/blank');
    }
    
    function demo(){
    	
    	
    	$this->display('/admin');
    }
    
    function lookbook(){
    	
    	$getData = array(
    			'plugin'	=> 'ERP',
    			'action'	=> 'ERPLookAction',
    			'entry'		=> 'getLookbookList',
    			'brand'		=> 'ISAB',
    			'season'	=> '2015f',
    	);
    	
    	$list = WebService('hj', 'Plugin', 'entry', $getData);
    	

    	
    	$this->assign('list',$list);
    	$this->display('/lookbook');
    }
    
    function style(){
    	$ob = M("lookbook_style_img");
    	
    	if($_POST['ado']=='addnewpic'){
    		import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath =  './Public/Uploads/';// 设置附件上传目录
			if(!$upload->upload()) {// 上传错误提示错误信息
				$this->error($upload->getErrorMsg());
			}else{// 上传成功 获取上传文件信息
				$info =  $upload->getUploadFileInfo();
// 				print_r($info);
				$save = array(
						"style_no"=> $_GET['styleno'],
						'img'	  => "/Public/Uploads/".$info[0]['savename']
						);
				
				$ob->add($save);
// 				print_r($save);
				$this->redirect("/Home/style/styleno/".$_GET['styleno']);
			}
    		
    	}
    	
    	if($_POST['ado']=='saveOrderBy'){
    		$save['orderby'] = $_POST['orderby'];
    		$ob->where(array('id'=>$_POST['id']))->save($save);
    		$this->redirect("/Home/style/styleno/".$_GET['styleno']);
    	}
    	
		
		
		if(!empty($_GET['delete'])){
			$map = array('style_no'=>$_GET['styleno'],'id'=>intval($_GET['delete']));
			$info = $ob->where($map)->find();
			@unlink(".".$info['img']);
			$ob->where($map)->delete();
			$this->redirect("/Home/style/styleno/".$_GET['styleno']);
		}
		
		$list = $ob->where(array('style_no'=>$_GET['styleno']))
				->order(array('orderby'=>'asc'))->limit(30)->select();
		
		
    	
		$this->assign('list',$list);
    	$this->display('/style');
    }
    
    
    
    
    
    
    
    
}