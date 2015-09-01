<?php


class ApiAction extends Action{
	
	
	function index(){
		
		echo "当季<br>";
		echo "<a href='/api/lookbook/brand/isabella' target='_blank'>/api/lookbook/brand/isabella</a><br>";
		echo "往季<br>";
		echo "<a href='/api/lookbook/brand/isabella/season/previous' target='_blank'>/api/lookbook/brand/isabella/season/previous</a><br>";

		
		echo "产品详细属性<br>";
		echo "<a href='/api/style/styleno/SW9N016ZCQ014' target='_blank'>/api/style/styleno/SW9N016ZCQ014</a><br><br><br><br>";
		
		
		echo "库存<br>";
		echo "POST['Warehouse']<br>";
		echo "POST['Styleno']<br>";
		echo "POST['ColorCode']<br>";
		echo "POST['Leng']<br>";
		echo "POST['Size']<br>";
		echo "<a href='/api/inventory/' target='_blank'>/api/inventory/</a><br>";
	}
	
	
	function lookbook(){
		
		$in = array('mens','womens','isabella','weekend');
		
		switch ($_GET['brand']){
			case 'mens':
				$brand = "";
				break;
			case 'isabella':
				$brand = "ISAB";
				break;
			default :
				$brand = 'ISAB';
				break;
		}
		
		if($_GET['season']=="previous"){
			$season = "2015s";
		}else{
			$season = "2015f";
		}
		
		$getData = array(   
			'plugin'	=> 'ERP' ,
			'action'	=> 'ERPLookAction' ,
			'entry'		=> 'getLookbookList' ,
			'brand'		=> $brand ,
			'season'	=> $season ,
		);
		$info = WebService('hj', 'Plugin', 'entry', $getData);

		print_r($info);
		
		echo json_encode($info);
	}
	
	function style(){
		
		$styleno = $_GET['styleno'];
		
		$getData = array(
				'plugin'	=> 'ERP',
				'action'	=> 'ERPProductsAction',
				'entry'		=> 'getProductProperty',
				'styleno'	=> $styleno,
		
		);
		$info = WebService('hj', 'Plugin', 'entry', $getData);
		
		print_r($info);
		
		
		//select * from PRIM_RT.dbo.StyleLookBookDtl where CtrlNO = '00001979'
	}
	
	function inventory(){
		$getData = array(
				'plugin'	=> 'ERP',
				'action'	=> 'ERPProductsAction',
				'entry'		=> 'getProductInventory',
		
		);
		
		
		$Warehouse = $_POST['Warehouse'];
		$styleno = $_POST['Styleno'];
		$color = $_POST['ColorCode'];
		$leng = $_POST['Leng'];
		$size = $_POST['Size'];
		
		
		$postData = array(
				'Warehouse'	=> $Warehouse,
				'Styleno'	=> $styleno,
				'ColorCode'	=> $color,
				'Leng'		=> $leng,
				'Size'		=> $size,
		);
		$info = WebService('hj', 'Plugin', 'entry', $getData, $postData);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
}

?>