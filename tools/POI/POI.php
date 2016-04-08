<?php
	
	function getPOIinfo($lac,$lon,$ak_provided){

		// get POI info using lac and lon information
		$ak = $ak_provided;
		$url = "http://api.map.baidu.com/geocoder/v2/?coordtype=bd09ll&location=" . $lac . "," . $lon . "&output=json&ak=" . $ak . "&pois=1";
		$ch = curl_init();
  		curl_setopt($ch,CURLOPT_HEADER,false);
  		curl_setopt($ch,CURLOPT_URL,$url);
  		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$content=curl_exec($ch);
		curl_close($ch);


		$content_decoded = json_decode($content,true);

		// $content_arr = json2arr($content);

		return $content_decoded;


	}


	// json tools . temporarily put here 
	function json2arr($json){

		$arr = array();
		foreach((array)$json as $key=>$val){
			if(is_object($val))$arr[$key]=json2arr($val);
			else $arr[$key] = $val;
		}
		return $arr;

	}


?>
