<?php
/**
 * date 2018-03-27
 * author 九月一十八
 */
define('SYSTEM_IN', true);
class wxaccount {
        protected $appId = null;
        protected $secret = null;
        protected $access_token = null;
	
        public function __construct() {
            //$this->appId = "wxebb96a3f66f22cbb";
            $this->appId = "wx51dab5a008d7aea6";
            $this->secret = "60942fc846af0f357e4c4711dcaf6b85";
	}
	
	public function getAccessToken() {		
        //$url = "http://47.100.48.1/wechattd/index.php?_act=accessToken";
        $url = "http://test.chinapaper.org/wechattd/index.php?_act=accessToken";
		$content = $this->toGet($url);
		$token = @json_decode($content, true);		
		$record = array();
		$record['token'] = $token['access_token'];
		$record['expire'] = $token['expires_in']; 
		$this->access_token = $record;
		return $record['token'];
	}
        
        public function getJsApiTicket(){
	   // $url = "http://47.100.48.1/wechattd/index.php?_act=ticket";
            $url = "http://test.chinapaper.org/wechattd/index.php?_act=ticket";
	    $content = $this->toGet($url);
	    //pre($content);
	    $ticket = @json_decode($content, true);
	    return $ticket['jsapi_ticket'];
	}
        
        public function getJssdkConfig(){
		$jsapiTicket = $this->getJsApiTicket();
		if($this->is_error($jsapiTicket)){
			$jsapiTicket = $jsapiTicket['message'];
		}
		$nonceStr = $this->random(16);
		$timestamp = time();
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$string1 = "jsapi_ticket={$jsapiTicket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";
		$signature = sha1($string1);
		$config = array(
			"appId"		=> $this->appId,
			"nonceStr"	=> $nonceStr,
			"timestamp" => "$timestamp",
			"signature" => $signature,
		);
		//pre($config);
		return $config;
	}
        
        public function getWechatUserInfo($openid){
            //$url = "http://47.100.48.1/wechattd/index.php?_act=accessToken";
//            $url = "http://test.chinapaper.org/wechattd/index.php?_act=accessToken";
//            $content = $this->toGet($url);            
//            $token = json_decode($content);
//            $tok= $token->access_token;
//            $subscribe_msg = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$tok&openid=$openid";
//            $userinfo = json_decode($this->toGet($subscribe_msg)); 
//            return $userinfo;
            $access_token = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid;
            
            $userinfo = json_decode($this->toGet($url));
            return $userinfo;       
        }

        public function getOpenid($code){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appId."&secret=".$this->secret."&code=".$code."&grant_type=authorization_code";
        
            $content = json_decode($this->toGet($url));
            return $content;
        }
        function is_error($data) {
            if (empty($data) || !is_array($data) || !array_key_exists('errno', $data) || (array_key_exists('errno', $data) && $data['errno'] == 0)) {
                    return false;
            } else {
                    return true;
            }
        }
        function random($length, $nc = 0) {
            $random= rand(1, 9);
            for($index=1;$index<$length;$index++)
            {
                $random=$random.rand(1, 9);
            }
            return $random;
        }
        function toGet($url) { 
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 500);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_URL, $url);

            $res = curl_exec($curl);
            curl_close($curl);

            return $res;
        }
              
}