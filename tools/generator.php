<?php


/**
 * Class Generator
 *  Generator 类，具体网址和字符串处理
 *
 */


    
	function generate($keyword)
    {
		global $BAIDU_PREFIX;
		global $BAIDU_POSFIX;
		global $SOUGOU_PREFIX;
		global $SOUGOU_POSFIX;
		global $WANGPAN_PREFIX;
		global $BING_PREFIX;
		global $BING_POSFIX;
		global $DOUBAN_PREFIX;
		global $ZHIHU_PREFIX;
		global $FIRST_PREFIX;
		global $JINDONG_PREFIX;
		global $JINDONG_POSFIX;
		global $MOGU_PREFIX;
		global $WEIBO_PREFIX;
		global $WEIBO_POSFIX;
		global $MAIMAIMAI;

		// can not be used for multi-picture situation !!!
		/*
		$encodedKeyword = urlencode($keyword);
		*/
		
		/*
        $text =  $BAIDU_PREFIX . $encodedKeyword . $BAIDU_POSFIX ."\n"."\n".
				 $SOUGOU_PREFIX . $encodedKeyword . $SOUGOU_POSFIX ."\n"."\n".
				 $WANGPAN_PREFIX . $encodedKeyword ."\n"."\n".
				 $BING_PREFIX . $encodedKeyword .$BING_POSFIX ."\n"."\n".
				 $DOUBAN_PREFIX . $encodedKeyword ."\n"."\n".
				 $ZHIHU_PREFIX . $encodedKeyword ."\n"."\n". "if you need to add more searching entry, let me know :) ";
		*/
		
		
		$common1 = $BAIDU_PREFIX . $keyword ;
		$common2 = $SOUGOU_PREFIX . $keyword . $SOUGOU_POSFIX;
		$common3 = $WANGPAN_PREFIX . $keyword ;
		$common4 = $BING_PREFIX . $keyword ;
		$common5 =  $DOUBAN_PREFIX . $keyword ;
		$common6 =  $ZHIHU_PREFIX . $keyword ;
		$common7 = $FIRST_PREFIX . $keyword  ;
		$common8 = $JINDONG_PREFIX . $keyword . $JINDONG_POSFIX ;
		$common9 = $MAIMAIMAI  ;
		$common10 = $WEIBO_PREFIX . $keyword . $WEIBO_POSFIX ;
		$common11 = $MAIMAIMAI;

		$text = array();
		$text[] = array("Title"=>"Baidu",  "Description"=>"Baidu", "PicUrl"=>"http://www.baidu.com/img/bd_logo1.png", "Url" => $common1 );
		$text[] = array("Title"=>"SouGou",  "Description"=>"SouGou", "PicUrl"=>"https://www.sogou.com/images/logo/new/search400x150.png", "Url" => $common2 );
		$text[] = array("Title"=>"WangPan",  "Description"=>"WangPan", "PicUrl"=>"http://pan.java1234.com/images/logo.png", "Url" => $common3 );
		$text[] = array("Title"=>"BiYing",  "Description"=>"BiYing", "PicUrl"=>"http://cn.bing.com/sa/simg/sw_mg_l_4e_ly_cn.png", "Url" => $common4 );
		$text[] = array("Title"=>"DOUBAN xiaoqingxin",  "Description"=>"douban", "PicUrl"=>"https://img3.doubanio.com/f/sns/19886d443852bee48de2ed91f4a3bdfdaf8c809c/pics/nav/logo_db.png", "Url" => $common5 );
		$text[] = array("Title"=>"ZHIHU",  "Description"=>"zhihu", "PicUrl"=>"http://static.zhihu.com/static/revved/img/index/logo.6837e927.png", "Url" => $common6 );
		$text[] = array("Title"=>"1haodian",  "Description"=>"1haodian", "PicUrl"=>"http://d7.yihaodianimg.com/N07/M07/AE/F3/CgQIz1ZyfEqAaJj8AAAPqOO2cwQ12100.png", "Url" => $common7 );
		$text[] = array("Title"=>"JD",  "Description"=>"JingDong", "PicUrl"=>"https://misc.360buyimg.com/lib/img/e/logo-201305.png", "Url" => $common8 );
		$text[] = array("Title"=>"maimaimai",  "Description"=>"maimaimai", "PicUrl"=>"http://s0.hao123img.com/res/r/image/2015-12-30/812a4fb0c8eaf16ff7a041474790715c.png", "Url" => $common9 );
		$text[] = array("Title"=>"WeiBo",  "Description"=>"Weibo", "PicUrl"=>"http://img.t.sinajs.cn/t6/style/images/global_nav/WB_logo_b.png", "Url" => $common10 );
		
        return $text;
    }

    // some definitions 
	$BAIDU_PREFIX = "www.baidu.com/s?ie=utf-8&wd=";
	
	$SOUGOU_PREFIX = "http://weixin.sogou.com/weixin?type=2&query=";
	$SOUGOU_POSFIX = "&ie=utf8&_sug_=n";
	
	$WANGPAN_PREFIX = "http://pan.java1234.com/result.php?wp=0&op=0&ty=gn&q=";
	
	$BING_PREFIX = "http://cn.bing.com/search?q=";
	
	$DOUBAN_PREFIX = "https://www.douban.com/search?q=";
	
	$ZHIHU_PREFIX = "http://zhihu.sogou.com/zhihu?ie=utf8&p=73351201&query=";
	
	$FIRST_PREFIX = "http://search.yhd.com/c0-0/k";
	
	$JINDONG_PREFIX = "http://search.jd.com/Search?keyword=";
	$JINDONG_POSFIX = "&enc=utf-8";
	
	$MOGU_PREFIX = "http://search.mogujie.com/search?q=";

	$WEIBO_PREFIX = "http://s.weibo.com/weibo/";
	$WEIBO_POSFIX = "&Refer=index";

	$MAIMAIMAI = "http://gouwu.hao123.com/?tn=kuzhan";

?>