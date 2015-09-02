<?php


class ApiAction extends Action{
	
	function _initialize(){
		header("Content-type: text/html; charset=utf-8");
	}
	
	function index(){
		
		$domain = "http://api.ports-intl.com";
		
		echo "<br><br><br><br><br><br><br>";
		echo "首页滚动图片<br>";
		echo "<a href='$domain/api/mainscreen/' target='_blank'>$domain/api/mainscreen/</a><br>";
		echo "字段说明：json['img'] 大图url<br><br>";
		echo "字段说明：json['simg'] 小图url<br><br>";
		echo "<br><br><br><br><br><br><br>";
		
		echo "左边品牌列表<br>";
		echo "<a href='$domain/api/Brandlist' target='_blank'>$domain/api/Brandlist</a><br>";
		
		
		echo "字段说明：json['onSeasonName'] //当季的显示名  放在现在图片里 FALL / WINTER 2015<br><br><br>";
		echo "字段说明：json['preSeasonName'] //当季的显示名  放在现在图片里 SPRING / SUMMER 2015<br><br><br>";
		echo "字段说明：json['onSeasonWomens'] //当季的Womens 下面的列表<br><br><br>";
		echo "字段说明：json['onSeasonMens'] //当季的Mens 下面的列表<br><br><br>";
		echo "字段说明：json['preSeasonWomens'] //上季的Womens 下面的列表<br><br><br>";
		echo "字段说明：json['preSeasonMens'] //上季的Mens 下面的列表<br><br><br>";
		echo "<img src='/Public/Uploads/1.png' height='500' /><br><br>";
		
		echo "在womens 跟 mens 下面显示名 用 json['onSeasonWomens']['ref3']<br>
				ref1 为季节 ref2 为品牌代码 用来组合查找 该品牌该季节的LOOK列表 ";
		
		echo "<br><br><br><br><br><br>点击上面的品牌列表，直接调取下面的接口获得Look图片列表<br><br>
				
				url用上面返回的字段组合，ref1 为季节代码 ref2 为品牌代码
				
				<br><br><br>";
		
		
		echo "品牌Look获取<br>";
		echo "<a href='$domain/api/lookbook/brand/ISAB/season/2015FW' target='_blank'>$domain/api/lookbook/brand/ISAB/season/2015FW</a><br>";
		echo "字段说明：json['img'] //图片地址<br><br><br>";
		echo "字段说明：json['relations'] //模特身上的衣服列表<br><br><br>";
		echo "字段说明：json['relations']['StyleCode'] //衣服款号<br><br><br>";
		echo "字段说明：json['relations']['CateGoryCN'] //衣服名称<br><br><br>";
		echo "字段说明：json['relations']['StyleColor'] //衣服颜色<br><br><br>";
		echo "<br><br><br><br><br><br><br>";

		echo "下面先不看<br>--库存<br>";
		echo "POST['Warehouse']<br>";
		echo "POST['Styleno']<br>";
		echo "POST['ColorCode']<br>";
		echo "POST['Leng']<br>";
		echo "POST['Size']<br>";
		echo "<a href='/api/inventory/' target='_blank'>/api/inventory/</a><br>";
		
		
		
	}
	
	function mainscreen(){
		
		$ob = M("ad_img");
		
		$list = $ob->where(array('classname'=>'mainscreen'))
					->order(array('orderby'=>'asc'))->select();
		
		foreach($list as $key=>$value){
			$list[$key]['img'] = "http://api.ports-intl.com/".$value['img'];
			$list[$key]['simg'] = "http://api.ports-intl.com/".$value['simg'];
		}
		
		echo json_encode($list);
	}
	
	function Brandlist(){
		
		//当季
		$arr['onSeasonName'] = "FALL / WINTER 2015";
		$arr['onSeason'] = "2015FW";
		//上季
		$arr['preSeasonName'] = "SPRING / SUMMER 2015";
		$arr['preSeason'] = "2015SS";
// 		

		$ob = M("ad_img");
		
		$arr["onSeasonWomens"]  = $ob->where(array('classname'=>'onseason','ref1'=>$arr['onSeason'],'ref4'=>'WOMENS','show'=>'1'))
						->order(array('orderby'=>'asc'))->select();
		
		$arr["onSeasonMens"]  = $ob->where(array('classname'=>'onseason','ref1'=>$arr['onSeason'],'ref4'=>'MENS','show'=>'1'))
						->order(array('orderby'=>'asc'))->select();
		
		$arr["preSeasonWomens"]  = $ob->where(array('classname'=>'onseason','ref1'=>$arr['preSeason'],'ref4'=>'WOMENS','show'=>'1'))
						->order(array('orderby'=>'asc'))->select();
		
		$arr["preSeasonMens"]  = $ob->where(array('classname'=>'onseason','ref1'=>$arr['preSeason'],'ref4'=>'MENS','show'=>'1'))
						->order(array('orderby'=>'asc'))->select();
		
		print_r($arr);
		
	}
	
	
	function lookbook(){

// 		$in = array('mens','womens','isabella','weekend');
		
// 		switch ($_GET['brand']){
// 			case 'mens':
// 				$brand = "";
// 				break;
// 			case 'isabella':
// 				$brand = "ISAB";
// 				break;
// 			default :
// 				$brand = 'ISAB';
// 				break;
// 		}
		
// 		if($_GET['season']=="previous"){
// 			$season = "2015s";
// 		}else{
// 			$season = "2015f";
// 		}
		
		$season = str_replace(array("fw","ss"), array("f","s"), strtolower($_GET['season']));
// 		echo $season;
		$getData = array(   
			'plugin'	=> 'ERP' ,
			'action'	=> 'ERPLookAction' ,
			'entry'		=> 'getLookbookList' ,
			'brand'		=> $_GET['brand'] ,
			'season'	=> $season ,
		);
		$info = WebService('', 'Plugin', 'entry', $getData);

		foreach($info as $key=>$value){
			$info[$key]['img'] = "http://api.ports-intl.com/Public/Uploads/tmp/img-show-tmp".rand(1,8)."-1334w2000h.png";
		}
		
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
		
// 		print_r($info);
		
		
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