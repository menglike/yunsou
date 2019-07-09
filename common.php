<?php
	function curl_http($url,$type='get',$post='',$header='',$http='http') {
		$ch = curl_init();
        $headers = array(
                'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'accept-language: zh-CN,zh;q=0.9',
                'cache-control: max-age=0',
                'cookie: count_h=4; count_m=4; UM_distinctid=165404399ee176-009c514a90a838-5b183a13-1fa400-165404399ef16; JSESSIONID=BF0490201D7EE766083D8BAFB7B65E45; first_h=1542777855488; first_m=1542777855491; CNZZDATA1261169279=503973959-1534377782-%7C1542773678; CNZZDATA1261392089=1616309039-1534377038-%7C1542776737; Hm_lvt_8c0c4cc417a1758182f08aac6b34a3d1=1540369960,1542161150,1542777857; Hm_lvt_dff120e04ac10b4b918dde3f60e06b18=1540369960,1542161150,1542777857; count_h=2; count_m=2; __music_index__=2; Hm_lpvt_8c0c4cc417a1758182f08aac6b34a3d1=1542777894; Hm_lpvt_dff120e04ac10b4b918dde3f60e06b18=1542777894',
                'referer: https://wangpan007.com/',
                'upgrade-insecure-requests: 1',
                'user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        );
        try{
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER , !empty($header) ? $header : $headers );  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                if($type=='post'){
                curl_setopt($ch, CURLOPT_POST,1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
                }
                if($http=='https'){
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                }
                curl_setopt($ch, CURLOPT_ENCODING,'gzip');
        }catch(Exception $e){
            echo $e;
        }
        if(curl_errno($ch)){
          var_dump(curl_error($ch));
        }
		$output = curl_exec( $ch );
		return $output;
	}