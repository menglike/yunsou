<?php
require "common.php";
require "config.php";
define('AK',$ak);
define('SITE',$site);
define('WELCOME',$welcome);
				
class WeixinController {
    function api(){
		//获得参数 signature nonce token timestamp echostr
		$nonce     = $_GET['nonce'];
		$token     = 'imooc';
		$timestamp = $_GET['timestamp'];
		$echostr   = $_GET['echostr'];
		$signature = $_GET['signature'];
		//形成数组，然后按字典序排序
		$array = array();
		$array = array($nonce, $timestamp, $token);
		sort($array);
		//拼接成字符串,sha1加密 ，然后与signature进行校验
		$str = sha1( implode( $array ) );

		if( $str == $signature){

			//第一次接入weixin api接口的时候
			if( $echostr  == '' ){
				$postArr = file_get_contents('php://input');
				$this->reponseMsg($postArr);
			}else{
				echo  $echostr;
			}
		}
	}

	public function reponseMsg($postArr){
		$postObj = simplexml_load_string( $postArr ,'SimpleXMLElement', LIBXML_NOCDATA);
		//判断该数据包是否是订阅的事件推送
		if( strtolower( $postObj->MsgType) == 'event'){
			//如果是关注 subscribe 事件
			if( strtolower($postObj->Event == 'subscribe') ){
				//回复用户消息(纯文本格式)	欢迎关注本号，您想找云盘资源直接回复即可，海量数据正在沉睡~
				$toUser   = $postObj->FromUserName;
				$fromUser = $postObj->ToUserName;
				$time     = time();
				$msgType  = 'text';
				$content  = 'hello';
				$template = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content></xml>";
				echo  sprintf($template, $toUser, $fromUser, $time, $content) ;
			}
		}

		if(strtolower($postObj->MsgType) == 'text'){
			$kw = trim($postObj->Content); 
			$url = 'http://ssapi.liangmlk.cn/Pan-query-q-'.$kw.'-p-1-ak-'.AK.'.html';
			$res = curl_http($url,'get');
			$msg = '';
			if(preg_match('/error/',$res)){
				$error = json_decode($res,true);
				$msg = $error['msg'];
			}
			
			$template = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
//注意模板中的中括号 不能少 也不能多
			$fromUser = $postObj->ToUserName;
			$toUser   = $postObj->FromUserName; 
			$time     = time();
			$content  = '您正在搜索 '.$kw."\n";
			if($msg === ''){
				preg_match('/list(.*?)\}\)/',$res,$out);
				$str = "{\"list".$out[1].'}';
				$res = json_decode($str,true);
				$num = $res['list']['count']	;
				$content  .= '总共找到 '.$num." 条结果\n";
				$content  .= '<a href="'.SITE.'/query.php?q='.$kw.'"> '. "查看详情</a>\n";
			}else{
				$content  .= $msg;
			}
			$msgType  = 'text';
			echo sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
			
		}
	}
	

	

}
$wx = new WeixinController();
$wx->api();