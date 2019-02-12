<?php
use App\Http\Model\VisitLog;
use App\Http\Model\SpiderLog;
use App\Http\Model\ForumCategory;
use App\Http\Model\Forum;
use App\Http\Model\Member;
use App\Http\Model\Openid;
use App\Http\Model\ForumWxRep;
use App\Http\Model\MemberMsgRep;
use App\Http\Model\CommonSmiley;
use App\Http\Model\ForumWxComment;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
require_once 'resources/org/code/bbcode.class.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 获取客户端类型，手机还是电脑，以及相应的操作系统类型。
 *
 * @param string $subject
 */
function get_os($agent) {
    $os = false;
    if (preg_match ( '/win/i', $agent ) && strpos ( $agent, '95' )) {
        $os = 'Windows 95';
    } else if (preg_match ( '/win 9x/i', $agent ) && strpos ( $agent, '4.90' )) {
        $os = 'Windows ME';
    } else if (preg_match ( '/win/i', $agent ) && preg_match ( '/98/i', $agent )) {
        $os = 'Windows 98';
    } else if (preg_match ( '/win/i', $agent ) && preg_match ( '/nt 6.0/i', $agent )) {
        $os = 'Windows Vista';
    } else if (preg_match ( '/win/i', $agent ) && preg_match ( '/nt 6.1/i', $agent )) {
        $os = 'Windows 7';
    } else if (preg_match ( '/win/i', $agent ) && preg_match ( '/nt 6.2/i', $agent )) {
        $os = 'Windows 8';
    } else if (preg_match ( '/win/i', $agent ) && preg_match ( '/nt 10.0/i', $agent )) {
        $os = 'Windows 10'; // 添加win10判断
    } else if (preg_match ( '/win/i', $agent ) && preg_match ( '/nt 5.1/i', $agent )) {
        $os = 'Windows XP';
    } else if (preg_match ( '/win/i', $agent ) && preg_match ( '/nt 5/i', $agent )) {
        $os = 'Windows 2000';
    } else if (preg_match ( '/win/i', $agent ) && preg_match ( '/nt/i', $agent )) {
        $os = 'Windows NT';
    } else if (preg_match ( '/win/i', $agent ) && preg_match ( '/32/i', $agent )) {
        $os = 'Windows 32';
    } else if (preg_match ( '/linux/i', $agent )) {
        if(preg_match("/Mobile/", $agent)){
            if(preg_match("/QQ/i", $agent)){
                $os = "Android QQ Browser";
            }else{
                $os = "Android Browser";
            }
        }else{
            $os = 'PC-Linux';
        }
    } else if (preg_match ( '/Mac/i', $agent )) {
        if(preg_match("/Mobile/", $agent)){
            if(preg_match("/QQ/i", $agent)){
                $os = "IPhone QQ Browser";
            }else{
                $os = "IPhone Browser";
            }
        }else{
            $os = 'Mac OS X';
        }
    } else if (preg_match ( '/unix/i', $agent )) {
        $os = 'Unix';
    } else if (preg_match ( '/sun/i', $agent ) && preg_match ( '/os/i', $agent )) {
        $os = 'SunOS';
    } else if (preg_match ( '/ibm/i', $agent ) && preg_match ( '/os/i', $agent )) {
        $os = 'IBM OS/2';
    } else if (preg_match ( '/Mac/i', $agent ) && preg_match ( '/PC/i', $agent )) {
        $os = 'Macintosh';
    } else if (preg_match ( '/PowerPC/i', $agent )) {
        $os = 'PowerPC';
    } else if (preg_match ( '/AIX/i', $agent )) {
        $os = 'AIX';
    } else if (preg_match ( '/HPUX/i', $agent )) {
        $os = 'HPUX';
    } else if (preg_match ( '/NetBSD/i', $agent )) {
        $os = 'NetBSD';
    } else if (preg_match ( '/BSD/i', $agent )) {
        $os = 'BSD';
    } else if (preg_match ( '/OSF1/i', $agent )) {
        $os = 'OSF1';
    } else if (preg_match ( '/IRIX/i', $agent )) {
        $os = 'IRIX';
    } else if (preg_match ( '/FreeBSD/i', $agent )) {
        $os = 'FreeBSD';
    } else if (preg_match ( '/teleport/i', $agent )) {
        $os = 'teleport';
    } else if (preg_match ( '/flashget/i', $agent )) {
        $os = 'flashget';
    } else if (preg_match ( '/webzip/i', $agent )) {
        $os = 'webzip';
    } else if (preg_match ( '/offline/i', $agent )) {
        $os = 'offline';
    } else {
        $os = '未知操作系统';
    }
    return $os;
}
 
/**
 * 获取 客户端的浏览器类型
 * @return string
 */
function get_broswer($sys){
    if (stripos($sys, "Firefox/") > 0) {
        preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
        $exp[0] = "Firefox";
        $exp[1] = $b[1];  //获取火狐浏览器的版本号
    } elseif (stripos($sys, "Maxthon") > 0) {
        preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
        $exp[0] = "傲游";
        $exp[1] = $aoyou[1];
    } elseif (stripos($sys, "MSIE") > 0) {
        preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
        $exp[0] = "IE";
        $exp[1] = $ie[1];  //获取IE的版本号
    } elseif (stripos($sys, "OPR") > 0) {
        preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
        $exp[0] = "Opera";
        $exp[1] = $opera[1];
    } elseif(stripos($sys, "Edge") > 0) {
        //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
        preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
        $exp[0] = "Edge";
        $exp[1] = $Edge[1];
    } elseif (stripos($sys, "Chrome") > 0) {
        preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
        $exp[0] = "Chrome";
        $exp[1] = $google[1];  //获取google chrome的版本号
    } elseif(stripos($sys,'rv:')>0 && stripos($sys,'Gecko')>0){
        preg_match("/rv:([\d\.]+)/", $sys, $IE);
        $exp[0] = "IE";
        $exp[1] = $IE[1];
    }elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $sys, $regs)) {  
        $exp[0]  = 'OmniWeb';  
        $exp[1]   = $regs[2];  
    }elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $sys, $regs)) {  
        $exp[0]  = 'Netscape';  
        $exp[1]   = $regs[2];  
    }elseif (preg_match('/safari\/([^\s]+)/i', $sys, $regs)) {  
        $exp[0]  = 'Safari';  
        $exp[1]   = $regs[1];  
    }elseif (preg_match('/MSIE\s([^\s|;]+)/i', $sys, $regs)) {  
        $exp[0]  = 'Internet Explorer';  
        $exp[1]   = $regs[1];  
    }elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $sys, $regs)) {  
        $exp[0]  = 'Opera';  
        $exp[1]   = $regs[1];  
    }elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $sys, $regs)) {  
        $exp[0]  = '(Internet Explorer ' .$exp[1]. ') NetCaptor';  
        $exp[1]   = $regs[1];  
    }elseif (preg_match('/Maxthon/i', $sys, $regs)) {  
        $exp[0]  = '(Internet Explorer ' .$exp[1]. ') Maxthon';  
        $exp[1]   = '';  
    }elseif (preg_match('/360SE/i', $sys, $regs)) {  
        $exp[0]       = '(Internet Explorer ' .$exp[1]. ') 360SE';  
        $exp[1]   = '';  
    }elseif (preg_match('/SE 2.x/i', $sys, $regs)) {  
        $exp[0]       = '(Internet Explorer ' .$exp[1]. ') 搜狗';  
        $exp[1]   = '';  
    }elseif (preg_match('/FireFox\/([^\s]+)/i', $sys, $regs)) {  
        $exp[0]  = 'FireFox';  
        $exp[1]   = $regs[1];  
    }elseif (preg_match('/Lynx\/([^\s]+)/i', $sys, $regs)) {  
        $exp[0]  = 'Lynx';  
        $exp[1]   = $regs[1];  
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false){
        $exp[0]  = 'wechat';  
        $exp[1]   = "";
    }else {
        $exp[0] = "未知浏览器";
        $exp[1] = "";
    }
    return $exp[0].'('.$exp[1].')';
}
 
/**
 * 根据 客户端IP 获取到其具体的位置信息
 * @param unknown $ip
 * @return string
 */
function get_address_by_ip($ip) {
    $url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $info = curl_exec($curl);
    curl_close($curl);
    return $info;
}
 
/**
 * 记录访问日志
 * @param unknown $ip
 * @return string
 */
function clientlog() {
    $useragent = $_SERVER ['HTTP_USER_AGENT'];
    $input['clientip'] = $_SERVER ['REMOTE_ADDR'];
 
    $input['client_info'] = get_broswer ( $useragent );
    $input['os']= get_os ( $useragent );
    $rawdata_position = get_address_by_ip ( $input['clientip'] );
 
    $rawdata_position = json_decode($rawdata_position, true);
    $input['country'] = $rawdata_position['data']['country'];
    $input['province'] = $rawdata_position['data']['region'];
    $input['city'] = $rawdata_position['data']['city'];
    $input['nettype'] = $rawdata_position['data']['isp'];
 
 
    $time = date ( 'y-m-d h:m:s' );
    $input['url'] = get_url();
    $data = "来自{$input['country']} {$input['province']} {$input['city'] }{$input['nettype']} 的客户端: {$input['client_info']},IP为:{$input['clientip']},在{$time}时刻访问了.{$input['url']}！\r\n";
//    本地记录
//    $filename = IA_ROOT."/log.log";
//    if (! file_exists ( $filename )) {
//        fopen ( $filename, "w+" );
//    }
//    file_put_contents ( $filename, $data, FILE_APPEND );
    
    VisitLog::create($input);
    
}

/**
 * 获取当前页面完整URL地址
 */
function get_url() {
  $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
  $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
  $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
  $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
  return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}

/**
 * 获取当前爬虫地址
 */
function getSpider(){
    $ServerName = $_SERVER["SERVER_NAME"] ; 
    $ServerPort = $_SERVER["SERVER_PORT"] ; 
    $ScriptName = $_SERVER["SCRIPT_NAME"] ; 
    $QueryString = $_SERVER["QUERY_STRING"]; 
    $serverip = $_SERVER["REMOTE_ADDR"] ; 
    $Url="http://".$ServerName;
    if ($ServerPort != "")
    {
     $Url = $Url.":".$ServerPort ;
    } 
    $Url=$Url.$ScriptName;
    if ($QueryString !="")
    {
     $Url=$Url."?".$QueryString;
    }  
    $GetLocationURL=$Url ;
    $agent = $_SERVER["HTTP_USER_AGENT"]; 
    $agent=strtolower($agent);
    $Bot ="";
    if (strpos($agent,"bot"))
    {
     $Bot = "Other Crawler";
    }
    if (strpos($agent,"googlebot"))
    {
     $Bot = "Google";
    }   
    if (strpos($agent,"mediapartners-google"))
    {
     $Bot = "Google Adsense";
    }
    if (strpos($agent,"baiduspider"))
    {
     $Bot = "Baidu";
    }
    if (strpos($agent,"sogou spider"))
    {
     $Bot = "Sogou";
    }
    if (strpos($agent,"yahoo"))
    {
     $Bot = "Yahoo!";
    }
    if (strpos($agent,"msn"))
    {
     $Bot = "MSN";
    }
    if (strpos($agent,"ia_archiver"))
    {
     $Bot = "Alexa";
    }
    if (strpos($agent,"iaarchiver"))
    {
     $Bot = "Alexa";
    }
    if (strpos($agent,"sohu"))
    {
     $Bot = "Sohu";
    }
    if (strpos($agent,"sqworm"))
    {
     $Bot = "AOL";
    }
    if (strpos($agent,"yodaoBot"))
    {
     $Bot = "Yodao";
    }
    if (strpos($agent,"iaskspider"))
    {
     $Bot = "Iask";
    }
    
    if(!empty($Bot)){
        $input['crawler_category'] = $Bot;
        $input['crawler_url'] = get_url();
        $input['crawler_IP'] = $serverip;
        SpiderLog::create($input); 
    }
}

/**
 * 对象转数组
 */
function object_array($array) {        
    if(is_object($array)) {            
        $array = (array)$array;                
    } if(is_array($array)) {            
        foreach($array as $key=>$value) {                
            $array[$key] = object_array($value);                       
        }        
    }
    return $array;            
}

/**
 * 获取分类名称
 */
function getCateName($pid) {        
    $cate = ForumCategory::where("id",$pid)->first();
    return $cate->defectsname;            
}

/**
 * 获得今日帖子数量
 */
function getTodayCateNum($id) {
    $count = DB::table('forum')
        ->whereDate('created_at','=', date("Y-m-d"))
        ->where('pid',$id)
        ->count(); //今日帖子数

    return $count;
}


/**
 * 服务：将时间段按天进行分割
 * @param string $start_date   @起始日期('Y-m-d H:i:s')
 * @param string $end_date     @结束日期('Y-m-d H:i:s')
 * @return array $mix_time_data=array(
'start_date'=>array([N]'Y-m-d H:i:s'),
'end_date'=>array([N]'Y-m-d H:i:s'),
'days_list'=>array([N]'Y-m-d'),
'days_inline'=>array([N]'Y-m-d H:i:s'),
'times_inline'=>array([N]'time()')
)
 */
function Date_segmentation($start_date, $end_date)
{
    /******************************* 时间分割 ***************************/
    //如果为空，则从今天的0点为开始时间
    if(!empty($start_date))
        $start_date=date('Y-m-d H:i:s',strtotime($start_date));
    else
        $start_date=date('Y-m-d 00:00:00',time());
 
 
 
    //如果为空，则以明天的0点为结束时间（不存在24:00:00，只会有00:00:00）
    if(!empty($end_date))
        $end_date=date('Y-m-d H:i:s',strtotime($end_date));
    else
        $end_date=date('Y-m-d 00:00:00',strtotime('+1 day'));
 
 
 
    //between 查询 要求必须是从低到高
    if($start_date>$end_date)
    {
        $ttt=$start_date;
        $start_date=$end_date;
        $end_date=$ttt;
    }elseif($start_date==$end_date){
        echo '时间输入错误';die;
    }
 
 
    $time_s=strtotime($start_date);
    $time_e=strtotime($end_date);
    $seconds_in_a_day=86400;
 
    //生成中间时间点数组（时间戳格式、日期时间格式、日期序列）
    $days_inline_array=array();
    $times_inline_array=array();
 
    //日期序列
    $days_list=array();
    //判断开始和结束时间是不是在同一天
    $days_inline_array[0]=$start_date;  //初始化第一个时间点
    $times_inline_array[0]=$time_s;     //初始化第一个时间点
    $days_list[]=date('Y-m-d',$time_s);//初始化第一天
    if(
        date('Y-m-d',$time_s)
        ==date('Y-m-d',$time_e)
    ){
        $days_inline_array[1]=$end_date;
        $times_inline_array[1]=$time_e;
    }
    else
    {
        /**
         * A.取开始时间的第二天凌晨0点
         * B.用结束时间减去A
         * C.用B除86400取商，取余
         * D.用A按C的商循环+86400，取得分割时间点，如果C没有余数，则最后一个时间点 与 循环最后一个时间点一致
         */
        $A_temp=date('Y-m-d 00:00:00',$time_s+$seconds_in_a_day);
        $A=strtotime($A_temp);
        $B=$time_e-$A;
        $C_quotient=floor($B/$seconds_in_a_day);    //商舍去法取整
        $C_remainder=fmod($B,$seconds_in_a_day);               //余数
        $days_inline_array[1]=$A_temp;
        $times_inline_array[1]=$A;
        $days_list[]=date('Y-m-d',$A);              //第二天
        for($increase_time=$A,$c_count_t=1;$c_count_t<=$C_quotient;$c_count_t++)
        {
            $increase_time+=$seconds_in_a_day;
            $days_inline_array[]=date('Y-m-d H:i:s',$increase_time);
            $times_inline_array[]=$increase_time;
            $days_list[]=date('Y-m-d',$increase_time);
        }
        $days_inline_array[]=$end_date;
        $times_inline_array[]=$time_e;
    }
 
    return array(
        'start_date'=>$start_date,
        'end_date'=>$end_date,
        'days_list'=>$days_list,
        'days_inline'=>$days_inline_array,
        'times_inline'=>$times_inline_array
    );
}


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * curl请求指定url
 * @param $url
 * @param array $data
 * @return mixed
 */
function curl($url, $data = [])
{
    // 处理get数据
    if (!empty($data)) {
        $url = $url . '?' . http_build_query($data);
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_ENCODING, "");

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}

function httpPost($url,$data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    // POST数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // 把post的变量加上
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//    curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
//        'pass:123456','user:zzw', 
//    ) );
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
/**
 * 获取小程序SessionKey
 */
function getSessionKey($code,$appId,$appSecret){
    $url = 'https://api.weixin.qq.com/sns/jscode2session';
    $result = json_decode(curl($url, [
        'appid' => $appId,
        'secret' => $appSecret,
        'grant_type' => 'authorization_code',
        'js_code' => $code
    ]), true);
    return isset($result['errcode']) ? [] : $result;
}


/**
*获取小程序access_token
*/
function getAccessToken(){
    if(Cache::has('access_token')){
       $res = Cache::get('access_token');
        if($res->time > time()){
            return $res->access_token;
        }else{
            getToken();
        } 
    }else{
        getToken();
    }  
}

function getToken(){
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxb73f46cea17e1d7f&secret=ace3e213f7b8fcf2a6b9dcf26a72575e";
    $result = json_decode(curl($url));
    $result->time = time() + 7000;
    Cache::put('access_token',$result,120);
    return !isset($result) ? [] : $result->access_token;
}
 
/**
 * 帖子被评论通知
 */
function sendMsgByComment($form_id,$da) {
    $data['touser'] = $da['touser'];
    $data['template_id'] = "YX3ZCw181s3POS7mreFtY-dWYFmapDVJClwJB_MRTRA";
    $data['page'] = "pages/forumDetail/index?id=".$da['fid'];
    $data['form_id'] = $form_id;
    $data['data']['keyword1']['value'] = $da['content'];
    $data['data']['keyword2']['value'] = $da['comuser'];
    $data['data']['keyword3']['value'] = $da['title'];
    $data['data']['keyword4']['value'] = $da['addtime'];
    //pre($data);
    $result = sendTemplateMsg(json_encode($data));
    return $result;
}

/**
 * 帖子被评论通知
 */
function sendMsgByRep($form_id,$da) {
    $data['touser'] = $da['touser'];
    $data['template_id'] = "vEWyCghbCR8BpGbEHKxz-sTTjRT7tt9d9RoVahRJdrg";
    $data['page'] = "pages/forumDetail/index?id=".$da['fid'];
    $data['form_id'] = $form_id;
    $data['data']['keyword1']['value'] = $da['comcontent'];
    $data['data']['keyword2']['value'] = $da['comname'];
    $data['data']['keyword3']['value'] = $da['comtime'];
    $data['data']['keyword4']['value'] = $da['comuser'];
    $data['data']['keyword5']['value'] = $da['repcontent'];
    $data['data']['keyword6']['value'] = $da['title'];
    $data['data']['keyword7']['value'] = $da['reptime'];
    //pre(json_encode($data));
    $result = sendTemplateMsg(json_encode($data));
    return $result;
}


/**
 * 帖子被回复通知
 */
function sendMsgByRepBack($form_id,$openid,$da) {
    $data['touser'] = $openid;
    $data['template_id'] = "vEWyCghbCR8BpGbEHKxz-rQWIOPkwysp19vyMK1PGd4";
    $data['page'] = "pages/forumDetail/index?id=".$da['fid'];
    $data['form_id'] = $form_id;
    $data['data']['keyword1']['value'] = $da['repuser'];
    $data['data']['keyword2']['value'] = $da['repcontent'];
    $data['data']['keyword3']['value'] = $da['title'];
    $data['data']['keyword4']['value'] = $da['reptime'];
    //pre(json_encode($data));
    $result = sendTemplateMsg(json_encode($data));
    return $result;
}

/**
 * 登录成功通知
 */
function sendMsgByLogin($form_id,$da) {
    $data['touser'] = $da['openid'];
    $data['template_id'] = "PtvibM_onPY7fYc5pLy0Q95rqwfl6HFmkIGMY6YnGcU";
    $data['form_id'] = $form_id;
    $data['page'] = "pages/index/index";
    $data['data']['keyword1']['value'] = "您已成功登录豆宝网，让育儿流行起来~";
    $data['data']['keyword2']['value'] = $da['nickname'];
    $data['data']['keyword3']['value'] = date("Y-m-d H:i:s");
    $data['data']['keyword4']['value'] = $da['systemInfo'];
    $data['data']['keyword5']['value'] = "微信号:LQAWY0918,公众号:歆之语";
    $data['data']['keyword6']['value'] = "本站不定期更新育儿,健康类的文章,大家可以看看哦!";
    $data['data']['keyword7']['value'] = "有问题可加微信号一起交流育娃经验哦";
    //pre(json_encode($data));
    $result = sendTemplateMsg(json_encode($data));
    return $result;
}

/**
 * 获得回复人的昵称
 */
function getReplyName($comid) {
    $data = ForumWxRep::select("*")
        ->join('member', 'member.id', '=', 'forum_wx_rep.uid')    
        ->where('forum_wx_rep.repid',$comid)
        ->first(); 
    //pre($data->nickname);
    return $data->nickname;
}
/**
 * 获得回复人的昵称
 */
function getMsgReplyName($comid) {
    $data = MemberMsgRep::select("*")
        ->join('member', 'member.id', '=', 'member_msg_rep.uid')    
        ->where('member_msg_rep.repid',$comid)
        ->first(); 
    //pre($data->nickname);
    return $data->nickname;
}

/**
 * 获得回复人的昵称
 */
function getMemberName($uid) {
    $data = Member::select("*")
        ->where('id',$uid)
        ->first(); 
    //pre($data->nickname);
    return $data->nickname;
}


/**
 * 获得用户信息
 */
function getMember($uid) {
    $data = Member::select()
            ->join('openid', 'openid.uid', '=', 'member.id')
            ->where('member.id',$uid) 
            ->first();
    return $data;
}

/**
 * 获得openid
 */
function getMemberOpenid($uid){
    $openid = Openid::where("uid",$uid)
            ->first();
    return $openid->openid;
}

function getCommentContent($comid){
    $res = ForumWxComment::where("comid",$comid)->first();
    return $res;
}

function getRepContent($comid){
    $res = ForumWxRep::where("repid",$comid)->first();
    return $res;
}
/**
 * 获得模板消息所需参数
 */
function getTemplateData($touserid,$comid){
    $openid = Openid::where("uid",$touserid)
            ->first();
    $comuser = getMember($comid);
    $data['touser'] = $openid->openid;
    $data['comuser'] = $comuser->nickname;
    return $data;
}

/**
*发送模板消息
*/
function sendTemplateMsg($data){
    $accessToken = getAccessToken();
    $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$accessToken;
    $result = json_decode(json_encode(httpPost($url,$data)));
    setLog($result,"模板消息返回:","temp.log");
    return $result;
}

function wxBizDataCrypt($appid,$appsecret,$encryptedData,$iv){
    include_once "app/Libs/wechat/wxBizDataCrypt.php";
    $userifo = new \wxBizDataCrypt($appid, $appsecret);
    $errCode = $userifo->decryptData($encryptedData, $iv, $data );
    if ($errCode == 0) {
        return $data;
    } else {
        return false;
    }
}


function setLog($data,$name,$pathname){
    $log = new Logger('register');
    $log->pushHandler(new StreamHandler(storage_path('logs/'.$pathname),Logger::INFO) );
    $log->addInfo($name.json_encode($data));
}
/**
*把用户输入的文本转义,用于保存
* （主要针对特殊符号和emoji表情）
*/
function userTextEncode($str){
   if(!is_string($str))return $str;
   if(!$str || $str=='undefined')return '';

   $text = json_encode($str); //暴露出unicode
   $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
       return addslashes($str[0]);
   },$text); //将emoji的unicode留下，这里的正则比原来增加了d，很多emoji实际上是\ud开头的，反而没发现有\ue开头。
   return json_decode($text);
}

/**
*解码上面的转义,用于显示
*/
function  userTextDecode($str){
   $text = json_encode($str); //暴露出unicode
   $text = preg_replace_callback('/\\\\\\\\/i',function($str){
       return '\\';
   },$text); //将两条斜杠变成一条
   return json_decode($text);
}

/*
 * 取html中的所有img出来
 */
function html2img ($html) {
    $imgs = array();
    if (empty($html)) return $imgs;
 
    preg_match_all("/<img[^>]+>/i",$html,$img);
    
    if (empty($img)) return $imgs;
    $img = $img[0];

    foreach ($img as $g) {
        $g = preg_replace("/^<img|>$/i", '',$g);//移除二头字符
        preg_match("/\ssrc\s*\=\s*\"([^\"]+)|\ssrc\s*\=\s*'([^']+)|\ssrc\s*\=\s*([^\"'\s]+)/i", $g, $src);//空格 src 可能空格 = 可能空格 "非"" 或 '非'' 或 非空白 这几种可能,下同 
        $src= empty($src) ? '': $src[count($src) - 1];//匹配到,总会放在最后

        if (empty($src) ) {//空的src? 没用,跳过
            continue ;
        }

//        preg_match("/\salt\s*\=\s*\"([^\"]+)|\salt\s*\=\s*'([^']+)|\salt\s*\=\s*(\S+)/i", $g, $alt);
//        $alt = empty($alt) ? $src : $alt[count($alt) - 1];//alt没值?用src
//        preg_match("/\stitle\s*\=\s*\"([^\"]+)|\stitle\s*\=\s*'([^']+)|\stitle\s*\=\s*(\S+)/i", $g, $title);
//        $title= empty($title) ? $src : $title[count($title) - 1];//title没值?用src
//        $imgs[] = array('title' => $title, 'alt' => $alt, 'src' => $src);
        $imgs[] = $src;
    }

    return $imgs;
}


/**
 * 返回文件格式
 * @param  string $str 文件名
 * @return string      文件格式
 */
function file_format($str){
    // 取文件后缀名
    $str=strtolower(pathinfo($str, PATHINFO_EXTENSION));
    // 图片格式
    $image=array('webp','jpg','png','ico','bmp','gif','tif','pcx','tga','bmp','pxc','tiff','jpeg','exif','fpx','svg','psd','cdr','pcd','dxf','ufo','eps','ai','hdri');
    // 视频格式
    $video=array('mp4','avi','3gp','rmvb','gif','wmv','mkv','mpg','vob','mov','flv','swf','mp3','ape','wma','aac','mmf','amr','m4a','m4r','ogg','wav','wavpack');
    // 压缩格式
    $zip=array('rar','zip','tar','cab','uue','jar','iso','z','7-zip','ace','lzh','arj','gzip','bz2','tz');
    // 文档格式
    $text=array('exe','doc','ppt','xls','wps','txt','lrc','wfs','torrent','html','htm','java','js','css','less','php','pdf','pps','host','box','docx','word','perfect','dot','dsf','efe','ini','json','lnk','log','msi','ost','pcs','tmp','xlsb');
    // 匹配不同的结果
    switch ($str) {
        case in_array($str, $image):
            return 'image';
            break;
        case in_array($str, $video):
            return 'video';
            break;
        case in_array($str, $zip):
            return 'zip';
            break;
        case in_array($str, $text):
            return 'text';
            break;
        default:
            return 'image';
            break;
    }
}

function unicode_decode($name){
 
  $json = '{"str":"'.$name.'"}';
  $arr = json_decode($json,true);
  if(empty($arr)) return '';
  return $arr['str'];

}

   function pre($data){
        // 定义样式
        $str='<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #F5F5F5;border: 1px solid #CCC;border-radius: 4px;">';
        // 如果是boolean或者null直接显示文字；否则print
        if (is_bool($data)) {
            $show_data=$data ? 'true' : 'false';
        }elseif (is_null($data)) {
            $show_data='null';
        }else{
            $show_data=print_r($data,true);
        }
        $str.=$show_data;
        $str.='</pre>';
        echo $str;die;
    }




    function pr($data){
        // 定义样式
       if(session("userinfo.id")==1) {
            $str='<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #F5F5F5;border: 1px solid #CCC;border-radius: 4px;">';
            // 如果是boolean或者null直接显示文字；否则print
            if (is_bool($data)) {
                $show_data=$data ? 'true' : 'false';
            }elseif (is_null($data)) {
                $show_data='null';
            }else{
                $show_data=print_r($data,true);
            }
            $str.=$show_data;
            $str.='</pre>';
            echo $str;die;
       }
    }


    function addresstolatlag($address){
        $url='http://api.map.baidu.com/geocoder/v2/?address='.$address.'&output=json&ak=DB9a87e557c368f3ad394a7c9e82b514';
        if($result=file_get_contents($url))
        {
            $res= explode(',"lat":', substr($result, 40,36));
            return   $res;
    
        }
    
    }





 /**
 * 传入时间戳,计算距离现在的时间
 * @param  number $time 时间戳
 * @return string     返回多少以前
 */
function word_time($time,$type) {
    if($type==1){
        $time = (int) substr(strtotime($time), 0, 10);
    }else{
        $time = (int) substr($time, 0, 10);
    }

    $int = time() - $time;
    $str = '';
    if ($int <= 2){
        $str = sprintf('刚刚', $int);
    }elseif ($int < 60){
        $str = sprintf('%d秒前', $int);
    }elseif ($int < 3600){
        $str = sprintf('%d分钟前', floor($int / 60));
    }elseif ($int < 86400){
        $str = sprintf('%d小时前', floor($int / 3600));
    }elseif ($int < 1728000){
        $str = sprintf('%d天前', floor($int / 86400));
    }else{
        $str = date('Y-m-d', $time);  
    }
        return $str;
    }


/**
 * 判断是否Ajax请求
 */
function is_ajax(){
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {
        return true;
    }
    else
    {
        return false;
    }
}


function idDecryption($data){
    
    return Crypt::decrypt($data);
    
}
function idEncryption($data){
    
    return Crypt::encrypt($data);
    
}
function object2array(&$object) {
    if (is_object($object)) {
        $arr = (array)($object);
    } else {
        $arr = &$object;
    }
    if (is_array($arr)) {
        foreach($arr as $varName => $varValue){
            $arr[$varName] = object2array($varValue);
        }
    }
    return $arr;
}

function isMobile() { 
  // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
  if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
    return true;
  } 
  // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
  if (isset($_SERVER['HTTP_VIA'])) { 
    // 找不到为flase,否则为true
    return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
  } 
  // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
  if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger'); 
    // 从HTTP_USER_AGENT中查找手机浏览器的关键字
    if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
      return true;
    } 
  } 
  // 协议法，因为有可能不准确，放到最后判断
  if (isset ($_SERVER['HTTP_ACCEPT'])) { 
    // 如果只支持wml并且不支持html那一定是移动设备
    // 如果支持wml和html但是wml在html之前则是移动设备
    if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
      return true;
    } 
  } 
  return false;
}

function isWeixin() { 
  if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
    return true; 
  } else {
    return false; 
  }
}
/**
 * 根据IP获取详细信息
 * @param mixed $uid
 * @return bool
 */
function getIpInfo($ip=""){  
    if(empty($ip)) $ip = get_client_ip();  //get_client_ip()为tp自带函数
    $url='http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;  
    $result = file_get_contents($url);  
    $result = json_decode($result,true);  
    if($result['code']!==0 || !is_array($result['data'])) return false;  
    return $result['data'];  
}
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/*
 * 取html中的所有img出来
 */
function html2imgs ($html) {
    $imgs = array();
    if (empty($html)) return $imgs;
 
    preg_match_all("/<img[^>]+>/i",$html,$img);
    
    if (empty($img)) return $imgs;
    $img = $img[0];

    foreach ($img as $g) {
        $g = preg_replace("/^<img|>$/i", '',$g);//移除二头字符
        preg_match("/\ssrc\s*\=\s*\"([^\"]+)|\ssrc\s*\=\s*'([^']+)|\ssrc\s*\=\s*([^\"'\s]+)/i", $g, $src);//空格 src 可能空格 = 可能空格 "非"" 或 '非'' 或 非空白 这几种可能,下同 
        $src= empty($src) ? '': $src[count($src) - 1];//匹配到,总会放在最后

        if (empty($src) ) {//空的src? 没用,跳过
            continue ;
        }

        preg_match("/\salt\s*\=\s*\"([^\"]+)|\salt\s*\=\s*'([^']+)|\salt\s*\=\s*(\S+)/i", $g, $alt);
        $alt = empty($alt) ? $src : $alt[count($alt) - 1];//alt没值?用src
        preg_match("/\stitle\s*\=\s*\"([^\"]+)|\stitle\s*\=\s*'([^']+)|\stitle\s*\=\s*(\S+)/i", $g, $title);
        $title= empty($title) ? $src : $title[count($title) - 1];//title没值?用src
        $imgs[] = array('title' => $title, 'alt' => $alt, 'src' => $src);
    }

    return $imgs;
}

    /**
 * 获得访问者系统
 */
function GetOS($Agent="") {  
    $Agent = $_SERVER['HTTP_USER_AGENT'];  
    $browserplatform = '';
    if (preg_match('/win/i',$Agent) && strpos($Agent, '95')) {
    $browserplatform="Windows 95";
    }
    elseif (preg_match('/win 9x/i',$Agent) && strpos($Agent, '4.90')) {
    $browserplatform="Windows ME";
    }
    elseif (preg_match('/win/i',$Agent) && preg_match('/98/i',$Agent)) {
    $browserplatform="Windows 98";
    }
    elseif (preg_match('/win/i',$Agent) && preg_match('/nt 5.0/i',$Agent)) {
    $browserplatform="Windows 2000";
    }
    elseif (preg_match('/win/i',$Agent) && preg_match('/nt 5.1/i',$Agent)) {
    $browserplatform="Windows XP";
    }
    elseif (preg_match('/win/i',$Agent) && preg_match('/nt 6.0/i',$Agent)) {
    $browserplatform="Windows Vista";
    }
    elseif (preg_match('/win/i',$Agent) && preg_match('/nt 6.1/i',$Agent)) {
    $browserplatform="Windows 7";
    }
    elseif (preg_match('/win/i',$Agent) && preg_match('/32/i',$Agent)) {
    $browserplatform="Windows 32";
    }
    elseif (preg_match('/win/i',$Agent) && preg_match('/nt/i',$Agent)) {
    $browserplatform="Windows NT";
    }elseif (preg_match('/Mac OS/i',$Agent)) {
    $browserplatform="Mac OS";
    }
    elseif (preg_match('/linux/i',$Agent)) {
    $browserplatform="Linux";
    }
    elseif (preg_match('/unix/i',$Agent)) {
    $browserplatform="Unix";
    }
    elseif (preg_match('/sun/i',$Agent) && preg_match('/os/i',$Agent)) {
    $browserplatform="SunOS";
    }
    elseif (preg_match('ibm/i',$Agent) && preg_match('/os/i',$Agent)) {
    $browserplatform="IBM OS/2";
    }
    elseif (preg_match('/Mac/i',$Agent) && preg_match('/PC/i',$Agent)) {
    $browserplatform="Macintosh";
    }
    elseif (preg_match('/PowerPC/i',$Agent)) {
    $browserplatform="PowerPC";
    }
    elseif (preg_match('/AIX/i',$Agent)) {
    $browserplatform="AIX";
    }
    elseif (preg_match('/HPUX/i',$Agent)) {
    $browserplatform="HPUX";
    }
    elseif (preg_match('/NetBSD/i',$Agent)) {
    $browserplatform="NetBSD";
    }
    elseif (preg_match('/BSD/i',$Agent)) {
    $browserplatform="BSD";
    }
    elseif (preg_match('/OSF1/i',$Agent)) {
    $browserplatform="OSF1";
    }
    elseif (preg_match('/IRIX/i',$Agent)) {
    $browserplatform="IRIX";
    }
    elseif (preg_match('/FreeBSD/i',$Agent)) {
    $browserplatform="FreeBSD";
    }
    if ($browserplatform=='') {$browserplatform = "Unknown"; }
    return $browserplatform;  
}  
    
    /**
 * 获得访问者浏览器
 */
function browse_info() {
    $agent  = $_SERVER['HTTP_USER_AGENT'];  
    $browser  = '';  
    $browser_ver  = '';  

    if (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs)) {  
        $browser  = 'OmniWeb';  
        $browser_ver   = $regs[2];  
    }  

    if (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs)) {  
        $browser  = 'Netscape';  
        $browser_ver   = $regs[2];  
    }  

    if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {  
        $browser  = 'Safari';  
        $browser_ver   = $regs[1];  
    }  

    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {  
        $browser  = 'Internet Explorer';  
        $browser_ver   = $regs[1];  
    }  

    if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {  
        $browser  = 'Opera';  
        $browser_ver   = $regs[1];  
    }  

    if (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs)) {  
        $browser  = '(Internet Explorer ' .$browser_ver. ') NetCaptor';  
        $browser_ver   = $regs[1];  
    }  

    if (preg_match('/Maxthon/i', $agent, $regs)) {  
        $browser  = '(Internet Explorer ' .$browser_ver. ') Maxthon';  
        $browser_ver   = '';  
    }  
    if (preg_match('/360SE/i', $agent, $regs)) {  
        $browser       = '(Internet Explorer ' .$browser_ver. ') 360SE';  
        $browser_ver   = '';  
    }  
    if (preg_match('/SE 2.x/i', $agent, $regs)) {  
        $browser       = '(Internet Explorer ' .$browser_ver. ') 搜狗';  
        $browser_ver   = '';  
    }  

    if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {  
        $browser  = 'FireFox';  
        $browser_ver   = $regs[1];  
    }  

    if (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs)) {  
        $browser  = 'Lynx';  
        $browser_ver   = $regs[1];  
    }  

    if(preg_match('/Chrome\/([^\s]+)/i', $agent, $regs)){  
        $browser  = 'Chrome';  
        $browser_ver   = $regs[1];  

    }  

    if ($browser != '') {  
        return $browser." version: ".$browser_ver;  
    } else {  
        return "unknow browser";  
    } 
}

/**
 * 获得访问者浏览器语言
 */
function get_lang() {
    if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $lang = substr($lang, 0, 5);
        if (preg_match('/zh-cn/i',$lang)) {
            $lang = '简体中文';
        } else if (preg_match('/zh/i',$lang)) {
            $lang = '繁体中文';
        } else {
            $lang = 'English';
        }
        return $lang;
    } else {
        return 'unknow';
    }
}

/**
 * 获得板块帖子数量
 */
function getForum($id,$type) {
    if($type==1){
        $count = DB::table('forum')
            ->where('display',1)
            ->where('pid',$id)
            ->whereDate('created_at','=', date("Y-m-d"))
            ->count(); //今日帖子数
    }elseif($type==2){
        $count = DB::table('forum')
                ->where('pid',$id)
                ->where('display',1)
                ->count(); //今日帖子数
    }
    return $count;
}

/**
 * 获得板块帖子数量
 */
function getTodayNum($type) {
    if($type==1){//帖子
        $count = DB::table('forum')
            ->whereDate('created_at','=', date("Y-m-d"))
            ->count(); //今日帖子数
    }elseif($type==2){//新闻
        $count = DB::table('news')
                ->where('type',1)
                ->whereDate('created_at','=', date("Y-m-d"))
                ->count(); 
    }elseif($type==3){//今日博客
        $count = DB::table('news')
                ->where('type',2)
                ->whereDate('created_at','=', date("Y-m-d"))
                ->count(); 
    }elseif($type==4){//今日回复
        $count = DB::table('forum_rep')
                ->whereDate('created_at','=', date("Y-m-d"))
                ->count(); 
    }
    return $count;
}

//function object2array(&$object) {
//    if (is_object($object)) {
//        $arr = (array)($object);
//    } else {
//        $arr = &$object;
//    }
//    if (is_array($arr)) {
//        foreach($arr as $varName => $varValue){
//            $arr[$varName] = object2array($varValue);
//        }
//    }
//    return $arr;
//}
/**
 * 获得板块帖子数量
 */
function getBbcode($str,$type) {
    $bbcode = new \bbcode();
    if($type==1){
        return $bbcode->bbcode2html($str,2);
    }else{
        return $bbcode->html2bbcode($str);
    }
}
function dhtmlspecialchars($string, $flags = null) {
//	if(is_array($string)) {
//		foreach($string as $key => $val) {
//			$string[$key] = dhtmlspecialchars($val, $flags);
//		}
//	} else {
//		if($flags === null) {
//			$string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
//			if(strpos($string, '&amp;#') !== false) {
//				$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
//			}
//		} else {
//			if(PHP_VERSION < '5.4.0') {
//				$string = htmlspecialchars($string, $flags);
//			} else {
//				if(strtolower(CHARSET) == 'utf-8') {
//					$charset = 'UTF-8';
//				} else {
//					$charset = 'ISO-8859-1';
//				}
//				$string = htmlspecialchars($string, $flags, $charset);
//			}
//		}
//	}
	return $string;
}
function discuzcode($message, $smileyoff = false, $bbcodeoff = false, $htmlon = 0, $allowsmilies = 1, $allowbbcode = 1, $allowimgcode = 1, $allowhtml = 0, $jammer = 0, $parsetype = '0', $authorid = '0', $allowmediacode = '0', $pid = 0, $lazyload = 0, $pdateline = 0, $first = 0) {
	global $_G;

	static $authorreplyexist;

	if($pid && strpos($message, '[/password]') !== FALSE) {
		if($authorid != $_G['uid'] && !$_G['forum']['ismoderator']) {
			$message = preg_replace_callback("/\s?\[password\](.+?)\[\/password\]\s?/i", create_function('$matches', 'return parsepassword($matches[1], '.intval($pid).');'), $message);
			if($_G['forum_discuzcode']['passwordlock'][$pid]) {
				return '';
			}
		} else {
			$message = preg_replace("/\s?\[password\](.+?)\[\/password\]\s?/i", "", $message);
			$_G['forum_discuzcode']['passwordauthor'][$pid] = 1;
		}
	}

	if($parsetype != 1 && !$bbcodeoff && $allowbbcode && (strpos($message, '[/code]') || strpos($message, '[/CODE]')) !== FALSE) {
		$message = preg_replace_callback("/\s?\[code\](.+?)\[\/code\]\s?/is", 'discuzcode_callback_codedisp_1', $message);
	}

	$msglower = strtolower($message);

	$htmlon = $htmlon && $allowhtml ? 1 : 0;

	if(!$htmlon) {
		$message = dhtmlspecialchars($message);
	} else {
		$message = preg_replace("/<script[^\>]*?>(.*?)<\/script>/i", '', $message);
	}

//	if($_G['setting']['plugins']['func'][HOOKTYPE]['discuzcode']) {
//		$_G['discuzcodemessage'] = & $message;
//		$param = func_get_args();
//		hookscript('discuzcode', 'global', 'funcs', array('param' => $param, 'caller' => 'discuzcode'), 'discuzcode');
//	}

	if(!$smileyoff && $allowsmilies) {
		//echo "<pre>";print_r(1);die;
            $message = parsesmiles($message);
	}

	if($_G['setting']['allowattachurl'] && strpos($msglower, 'attach://') !== FALSE) {
		$message = preg_replace_callback("/attach:\/\/(\d+)\.?(\w*)/i", 'discuzcode_callback_parseattachurl_12', $message);
	}

	if($allowbbcode) {
		if(strpos($msglower, 'ed2k://') !== FALSE) {
			$message = preg_replace_callback("/ed2k:\/\/(.+?)\//", 'discuzcode_callback_parseed2k_1', $message);
		}
	}

	if(!$bbcodeoff && $allowbbcode) {
		if(strpos($msglower, '[/url]') !== FALSE) {
			$message = preg_replace_callback("/\[url(=((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|thunder|qqdl|synacast){1}:\/\/|www\.|mailto:)?([^\r\n\[\"']+?))?\](.+?)\[\/url\]/is", 'discuzcode_callback_parseurl_152', $message);
		}
		if(strpos($msglower, '[/email]') !== FALSE) {
			$message = preg_replace_callback("/\[email(=([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+))?\](.+?)\[\/email\]/is", 'discuzcode_callback_parseemail_14', $message);
		}

		$nest = 0;
		while(strpos($msglower, '[table') !== FALSE && strpos($msglower, '[/table]') !== FALSE){
			$message = preg_replace_callback("/\[table(?:=(\d{1,4}%?)(?:,([\(\)%,#\w ]+))?)?\]\s*(.+?)\s*\[\/table\]/is", 'discuzcode_callback_parsetable_123', $message);
			if(++$nest > 4) break;
		}

		$message = str_replace(array(
			'[/color]', '[/backcolor]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]', '[s]', '[/s]', '[hr]', '[/p]',
			'[i=s]', '[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
			'[list=A]', "\r\n[*]", '[*]', '[/list]', '[indent]', '[/indent]', '[/float]'
			), array(
			'</font>', '</font>', '</font>', '</font>', '</div>', '<strong>', '</strong>', '<strike>', '</strike>', '<hr class="l" />', '</p>', '<i class="pstatus">', '<i>',
			'</i>', '<u>', '</u>', '<ul>', '<ul type="1" class="litype_1">', '<ul type="a" class="litype_2">',
			'<ul type="A" class="litype_3">', '<li>', '<li>', '</ul>', '<blockquote>', '</blockquote>', '</span>'
			), preg_replace(array(
			"/\[color=([#\w]+?)\]/i",
			"/\[color=((rgb|rgba)\([\d\s,]+?\))\]/i",
			"/\[backcolor=([#\w]+?)\]/i",
			"/\[backcolor=((rgb|rgba)\([\d\s,]+?\))\]/i",
			"/\[size=(\d{1,2}?)\]/i",
			"/\[size=(\d{1,2}(\.\d{1,2}+)?(px|pt)+?)\]/i",
			"/\[font=([^\[\<]+?)\]/i",
			"/\[align=(left|center|right)\]/i",
			"/\[p=(\d{1,2}|null), (\d{1,2}|null), (left|center|right)\]/i",
			"/\[float=left\]/i",
			"/\[float=right\]/i"

			), array(
			"<font color=\"\\1\">",
			"<font style=\"color:\\1\">",
			"<font style=\"background-color:\\1\">",
			"<font style=\"background-color:\\1\">",
			"<font size=\"\\1\">",
			"<font style=\"font-size:\\1\">",
			"<font face=\"\\1\">",
			"<div align=\"\\1\">",
			"<p style=\"line-height:\\1px;text-indent:\\2em;text-align:\\3\">",
			"<span style=\"float:left;margin-right:5px\">",
			"<span style=\"float:right;margin-left:5px\">"
			), $message));

		if($pid && !defined('IN_MOBILE')) {
			$message = preg_replace_callback("/\s?\[postbg\]\s*([^\[\<\r\n;'\"\?\(\)]+?)\s*\[\/postbg\]\s?/is", create_function('$matches', 'return parsepostbg($matches[1], '.intval($pid).');'), $message);
		} else {
			$message = preg_replace("/\s?\[postbg\]\s*([^\[\<\r\n;'\"\?\(\)]+?)\s*\[\/postbg\]\s?/is", "", $message);
		}

		if($parsetype != 1) {
			if(strpos($msglower, '[/quote]') !== FALSE) {
				$message = preg_replace("/\s?\[quote\][\n\r]*(.+?)[\n\r]*\[\/quote\]\s?/is", tpl_quote(), $message);
			}
			if(strpos($msglower, '[/free]') !== FALSE) {
				$message = preg_replace("/\s*\[free\][\n\r]*(.+?)[\n\r]*\[\/free\]\s*/is", tpl_free(), $message);
			}
		}
		if(!defined('IN_MOBILE')) {
			if(strpos($msglower, '[/media]') !== FALSE) {
				$message = preg_replace_callback("/\[media=([\w,]+)\]\s*([^\[\<\r\n]+?)\s*\[\/media\]/is", $allowmediacode ? 'discuzcode_callback_parsemedia_12' : 'discuzcode_callback_bbcodeurl_2', $message);
			}
			if(strpos($msglower, '[/audio]') !== FALSE) {
				$message = preg_replace_callback("/\[audio(=1)*\]\s*([^\[\<\r\n]+?)\s*\[\/audio\]/is", $allowmediacode ? 'discuzcode_callback_parseaudio_2' : 'discuzcode_callback_bbcodeurl_2', $message);
			}
			if(strpos($msglower, '[/flash]') !== FALSE) {
				$message = preg_replace_callback("/\[flash(=(\d+),(\d+))?\]\s*([^\[\<\r\n]+?)\s*\[\/flash\]/is", $allowmediacode ? 'discuzcode_callback_parseflash_234' : 'discuzcode_callback_bbcodeurl_4', $message);
			}
		} else {
			if(strpos($msglower, '[/media]') !== FALSE) {
				$message = preg_replace("/\[media=([\w,]+)\]\s*([^\[\<\r\n]+?)\s*\[\/media\]/is", "[media]\\2[/media]", $message);
			}
			if(strpos($msglower, '[/audio]') !== FALSE) {
				$message = preg_replace("/\[audio(=1)*\]\s*([^\[\<\r\n]+?)\s*\[\/audio\]/is", "[media]\\2[/media]", $message);
			}
			if(strpos($msglower, '[/flash]') !== FALSE) {
				$message = preg_replace("/\[flash(=(\d+),(\d+))?\]\s*([^\[\<\r\n]+?)\s*\[\/flash\]/is", "[media]\\4[/media]", $message);
			}
		}

		if($parsetype != 1 && $allowbbcode < 0 && isset($_G['cache']['bbcodes'][-$allowbbcode])) {
			$message = preg_replace($_G['cache']['bbcodes'][-$allowbbcode]['searcharray'], $_G['cache']['bbcodes'][-$allowbbcode]['replacearray'], $message);
		}
		if($parsetype != 1 && strpos($msglower, '[/hide]') !== FALSE && $pid) {
			if($_G['setting']['hideexpiration'] && $pdateline && (TIMESTAMP - $pdateline) / 86400 > $_G['setting']['hideexpiration']) {
				$message = preg_replace("/\[hide[=]?(d\d+)?[,]?(\d+)?\]\s*(.*?)\s*\[\/hide\]/is", "\\3", $message);
				$msglower = strtolower($message);
			}
			if(strpos($msglower, '[hide=d') !== FALSE) {
				$message = preg_replace_callback("/\[hide=(d\d+)?[,]?(\d+)?\]\s*(.*?)\s*\[\/hide\]/is", create_function('$matches', 'return expirehide($matches[1], $matches[2], $matches[3], '.intval($pdateline).');'), $message);
				$msglower = strtolower($message);
			}
			if(strpos($msglower, '[hide]') !== FALSE) {
				if($authorreplyexist === null) {
					if(!$_G['forum']['ismoderator']) {
						if($_G['uid']) {
							$_post = C::t('forum_post')->fetch('tid:'.$_G['tid'], $pid);
							$authorreplyexist = $_post['tid'] == $_G['tid'] ? C::t('forum_post')->fetch_pid_by_tid_authorid($_G['tid'], $_G['uid']) : FALSE;
						}
					} else {
						$authorreplyexist = TRUE;
					}
				}
				if($authorreplyexist) {
					$message = preg_replace("/\[hide\]\s*(.*?)\s*\[\/hide\]/is", tpl_hide_reply(), $message);
				} else {
					$message = preg_replace("/\[hide\](.*?)\[\/hide\]/is", tpl_hide_reply_hidden(), $message);
					$message = '<script type="text/javascript">replyreload += \',\' + '.$pid.';</script>'.$message;
				}
			}
			if(strpos($msglower, '[hide=') !== FALSE) {
				$message = preg_replace_callback("/\[hide=(\d+)\]\s*(.*?)\s*\[\/hide\]/is", create_function('$matches', 'return creditshide($matches[1], $matches[2], '.intval($pid).', '.intval($authorid).');'), $message);
			}
		}
	}

//	if(!$bbcodeoff) {
//		if($parsetype != 1 && strpos($msglower, '[swf]') !== FALSE) {
//			$message = preg_replace_callback("/\[swf\]\s*([^\[\<\r\n]+?)\s*\[\/swf\]/is", 'discuzcode_callback_bbcodeurl_1', $message);
//		}
//		$attrsrc = !IS_ROBOT && $lazyload ? 'file' : 'src';
//		if(strpos($msglower, '[/img]') !== FALSE) {
//			$message = preg_replace_callback("/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is", create_function('$matches', 'return '.intval($allowimgcode).' ? parseimg(0, 0, $matches[1], '.intval($lazyload).', '.intval($pid).', \'onmouseover="img_onmouseoverfunc(this)" \'.('.intval($lazyload).' ? \'lazyloadthumb="1"\' : \'onload="thumbImg(this)"\')) : ('.intval($allowbbcode).' ? (!defined(\'IN_MOBILE\') ? bbcodeurl($matches[1], \'<a href="{url}" target="_blank">{url}</a>\') : bbcodeurl($matches[1], \'\')) : bbcodeurl($matches[1], \'{url}\'));'), $message);
//			$message = preg_replace_callback("/\[img=(\d{1,4})[x|\,](\d{1,4})\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is", create_function('$matches', 'return '.intval($allowimgcode).' ? parseimg($matches[1], $matches[2], $matches[3], '.intval($lazyload).', '.intval($pid).') : ('.intval($allowbbcode).' ? (!defined(\'IN_MOBILE\') ? bbcodeurl($matches[3], \'<a href="{url}" target="_blank">{url}</a>\') : bbcodeurl($matches[3], \'\')) : bbcodeurl($matches[3], \'{url}\'));'), $message);
//		}
//	}

	for($i = 0; $i <= $_G['forum_discuzcode']['pcodecount']; $i++) {
		$message = str_replace("[\tDISCUZ_CODE_$i\t]", $_G['forum_discuzcode']['codehtml'][$i], $message);
	}

	unset($msglower);

	if($jammer) {
		$message = preg_replace_callback("/\r\n|\n|\r/", 'discuzcode_callback_jammer', $message);
	}
	if($first) {
		if(helper_access::check_module('group')) {
			$message = preg_replace("/\[groupid=(\d+)\](.*)\[\/groupid\]/i", lang('forum/template', 'fromgroup').': <a href="forum.php?mod=forumdisplay&fid=\\1" target="_blank">\\2</a>', $message);
		} else {
			$message = preg_replace("/(\[groupid=\d+\].*\[\/groupid\])/i", '', $message);
		}

	}
       //pre();
        //return $message;
	return $htmlon ? $message : nl2br(str_replace(array("\t", '   ', '  '), array('&nbsp; &nbsp; &nbsp; &nbsp; ', '&nbsp; &nbsp;', '&nbsp;&nbsp;'), $message));
}

function discuzcode_callback_codedisp_1($matches) {
	return codedisp($matches[1]);
}
function codedisp($code) {
	global $_G;
        
	$pcodecount=0;
        $codecount=0;
        $pcodecount++;
        $pcodecounts =array();
	$code = dhtmlspecialchars(str_replace('\\"', '"', $code));
	$code = str_replace("\n", "<li>", $code);
	$pcodecounts[$pcodecount] = tpl_codedisp($code);
	$codecount++;
	return "[\tDISCUZ_CODE_".$pcodecount."\t]";
}
function tpl_codedisp($code) {
$randomid = 'code_'.random(3);
?><?php
$return = <<<EOF
<div class="blockcode"><div id="{$randomid}"><ol><li>{$code}</ol></div><em onclick="copycode($('{$randomid}'));">复制代码</em></div>
EOF;
?><?php 
return $return;
}
function random($length, $numeric = 0) {
	PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	if($numeric) {
		$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
	} else {
		$hash = '';
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$max = strlen($chars) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
	}
	return $hash;
}
function discuzcode_callback_parseattachurl_12($matches) {
	return parseattachurl($matches[1], $matches[2], 1);
}

function discuzcode_callback_parseed2k_1($matches) {
	return parseed2k($matches[1]);
}

function discuzcode_callback_parseurl_152($matches) {
	return parseurl($matches[1], $matches[5], $matches[2]);
}

function discuzcode_callback_parseemail_14($matches) {
	return parseemail($matches[1], $matches[4]);
}

function discuzcode_callback_parsetable_123($matches) {
	return parsetable($matches[1], $matches[2], $matches[3]);
}

function discuzcode_callback_parsemedia_12($matches) {
	return parsemedia($matches[1], $matches[2]);
}

function discuzcode_callback_bbcodeurl_2($matches) {
	return bbcodeurl($matches[2], '<a href="{url}" target="_blank">{url}</a>');
}

function discuzcode_callback_parseaudio_2($matches) {
	return parseaudio($matches[2], 400);
}

function discuzcode_callback_parseflash_234($matches) {
	return parseflash($matches[2], $matches[3], $matches[4]);
}

function discuzcode_callback_bbcodeurl_4($matches) {
	return bbcodeurl($matches[4], '<a href="{url}" target="_blank">{url}</a>');
}

function discuzcode_callback_bbcodeurl_1($matches) {
	return bbcodeurl($matches[1], ' <img src="'.STATICURL.'image/filetype/flash.gif" align="absmiddle" alt="" /> <a href="{url}" target="_blank">Flash: {url}</a> ');
}

function discuzcode_callback_jammer($matches) {
	return jammer();
}

function parseurl($url, $text, $scheme) {
	global $_G;
	if(!$url && preg_match("/((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|thunder|qqdl|synacast){1}:\/\/|www\.)[^\[\"']+/i", trim($text), $matches)) {
		$url = $matches[0];
		$length = 65;
		if(strlen($url) > $length) {
			$text = substr($url, 0, intval($length * 0.5)).' ... '.substr($url, - intval($length * 0.3));
		}
		return '<a href="'.(substr(strtolower($url), 0, 4) == 'www.' ? 'http://'.$url : $url).'" target="_blank">'.$text.'</a>';
	} else {
		$url = substr($url, 1);
		if(substr(strtolower($url), 0, 4) == 'www.') {
			$url = 'http://'.$url;
		}
		$url = !$scheme ? $_G['siteurl'].$url : $url;
		return '<a href="'.$url.'" target="_blank">'.$text.'</a>';
	}
}

function parseflash($w, $h, $url) {
	$w = !$w ? 550 : $w;
	$h = !$h ? 400 : $h;
	preg_match("/((https?){1}:\/\/|www\.)[^\r\n\[\"'\?]+(\.swf|\.flv)(\?[^\r\n\[\"'\?]+)?/i", $url, $matches);
	$url = $matches[0];
	$randomid = 'swf_'.random(3);
	if(fileext($url) != 'flv') {
		return '<span id="'.$randomid.'"></span><script type="text/javascript" reload="1">$(\''.$randomid.'\').innerHTML=AC_FL_RunContent(\'width\', \''.$w.'\', \'height\', \''.$h.'\', \'allowNetworking\', \'internal\', \'allowScriptAccess\', \'never\', \'src\', encodeURI(\''.$url.'\'), \'quality\', \'high\', \'bgcolor\', \'#ffffff\', \'wmode\', \'transparent\', \'allowfullscreen\', \'true\');</script>';
	} else {
		return '<span id="'.$randomid.'"></span><script type="text/javascript" reload="1">$(\''.$randomid.'\').innerHTML=AC_FL_RunContent(\'width\', \''.$w.'\', \'height\', \''.$h.'\', \'allowNetworking\', \'internal\', \'allowScriptAccess\', \'never\', \'src\', \''.STATICURL.'image/common/flvplayer.swf\', \'flashvars\', \'file='.rawurlencode($url).'\', \'quality\', \'high\', \'wmode\', \'transparent\', \'allowfullscreen\', \'true\');</script>';
	}
}

function parseed2k($url) {
	global $_G;
	list(,$type, $name, $size,) = explode('|', $url);
	$url = 'ed2k://'.$url.'/';
	$name = addslashes($name);
	if($type == 'file') {
		$ed2kid = 'ed2k_'.random(3);
		return '<a id="'.$ed2kid.'" href="'.$url.'" target="_blank">'.dhtmlspecialchars(urldecode($name)).' ('.sizecount($size).')</a><script language="javascript">$(\''.$ed2kid.'\').innerHTML=htmlspecialchars(unescape(decodeURIComponent(\''.$name.'\')))+\' ('.sizecount($size).')\';</script>';
	} else {
		return '<a href="'.$url.'" target="_blank">'.$url.'</a>';
	}
}

function parseattachurl($aid, $ext, $ignoretid = 0) {
	global $_G;
	$_G['forum_skipaidlist'][] = $aid;
	return $_G['siteurl'].'forum.php?mod=attachment&aid='.aidencode($aid, $ext, $ignoretid ? '' : $_G['tid']).($ext ? '&request=yes&_f=.'.$ext : '');
}

function parseemail($email, $text) {
	$text = str_replace('\"', '"', $text);
	if(!$email && preg_match("/\s*([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\s*/i", $text, $matches)) {
		$email = trim($matches[0]);
		return '<a href="mailto:'.$email.'">'.$email.'</a>';
	} else {
		return '<a href="mailto:'.substr($email, 1).'">'.$text.'</a>';
	}
}

function parsetable($width, $bgcolor, $message) {
	if(strpos($message, '[/tr]') === FALSE && strpos($message, '[/td]') === FALSE) {
		$rows = explode("\n", $message);
		$s = !defined('IN_MOBILE') ? '<table cellspacing="0" class="t_table" '.
			($width == '' ? NULL : 'style="width:'.$width.'"').
			($bgcolor ? ' bgcolor="'.$bgcolor.'">' : '>') : '<table>';
		foreach($rows as $row) {
			$s .= '<tr><td>'.str_replace(array('\|', '|', '\n'), array('&#124;', '</td><td>', "\n"), $row).'</td></tr>';
		}
		$s .= '</table>';
		return $s;
	} else {
		if(!preg_match("/^\[tr(?:=([\(\)\s%,#\w]+))?\]\s*\[td([=\d,%]+)?\]/", $message) && !preg_match("/^<tr[^>]*?>\s*<td[^>]*?>/", $message)) {
			return str_replace('\\"', '"', preg_replace("/\[tr(?:=([\(\)\s%,#\w]+))?\]|\[td([=\d,%]+)?\]|\[\/td\]|\[\/tr\]/", '', $message));
		}
		if(substr($width, -1) == '%') {
			$width = substr($width, 0, -1) <= 98 ? intval($width).'%' : '98%';
		} else {
			$width = intval($width);
			$width = $width ? ($width <= 560 ? $width.'px' : '98%') : '';
		}
		$message = preg_replace_callback("/\[tr(?:=([\(\)\s%,#\w]+))?\]\s*\[td(?:=(\d{1,4}%?))?\]/i", 'parsetable_callback_parsetrtd_12', $message);
		$message = preg_replace_callback("/\[\/td\]\s*\[td(?:=(\d{1,4}%?))?\]/i", 'parsetable_callback_parsetrtd_1', $message);
		$message = preg_replace_callback("/\[tr(?:=([\(\)\s%,#\w]+))?\]\s*\[td(?:=(\d{1,2}),(\d{1,2})(?:,(\d{1,4}%?))?)?\]/i", 'parsetable_callback_parsetrtd_1234', $message);
		$message = preg_replace_callback("/\[\/td\]\s*\[td(?:=(\d{1,2}),(\d{1,2})(?:,(\d{1,4}%?))?)?\]/i", 'parsetable_callback_parsetrtd_123', $message);
		$message = preg_replace("/\[\/td\]\s*\[\/tr\]\s*/i", '</td></tr>', $message);
		return (!defined('IN_MOBILE') ? '<table cellspacing="0" class="t_table" '.
			($width == '' ? NULL : 'style="width:'.$width.'"').
			($bgcolor ? ' bgcolor="'.$bgcolor.'">' : '>') : '<table>').
			str_replace('\\"', '"', $message).'</table>';
	}
}

function parsetable_callback_parsetrtd_12($matches) {
	return parsetrtd($matches[1], 0, 0, $matches[2]);
}

function parsetable_callback_parsetrtd_1($matches) {
	return parsetrtd('td', 0, 0, $matches[1]);
}

function parsetable_callback_parsetrtd_1234($matches) {
	return parsetrtd($matches[1], $matches[2], $matches[3], $matches[4]);
}

function parsetable_callback_parsetrtd_123($matches) {
	return parsetrtd('td', $matches[1], $matches[2], $matches[3]);
}

function parsetrtd($bgcolor, $colspan, $rowspan, $width) {
	return ($bgcolor == 'td' ? '</td>' : '<tr'.($bgcolor && !defined('IN_MOBILE') ? ' style="background-color:'.$bgcolor.'"' : '').'>').'<td'.($colspan > 1 ? ' colspan="'.$colspan.'"' : '').($rowspan > 1 ? ' rowspan="'.$rowspan.'"' : '').($width && !defined('IN_MOBILE') ? ' width="'.$width.'"' : '').'>';
}

function parseaudio($url, $width = 400) {
	$url = addslashes($url);
        if(!in_array(strtolower(substr($url, 0, 6)), array('http:/', 'https:', 'ftp://', 'rtsp:/', 'mms://')) && !preg_match('/^static\//', $url) && !preg_match('/^data\//', $url)) {
		return dhtmlspecialchars($url);
	}
	$ext = fileext($url);
	switch($ext) {
		case 'mp3':
			$randomid = 'mp3_'.random(3);
			return '<span id="'.$randomid.'"></span><script type="text/javascript" reload="1">$(\''.$randomid.'\').innerHTML=AC_FL_RunContent(\'FlashVars\', \'soundFile='.urlencode($url).'\', \'width\', \'290\', \'height\', \'24\', \'allowNetworking\', \'internal\', \'allowScriptAccess\', \'never\', \'src\', \''.STATICURL.'image/common/player.swf\', \'quality\', \'high\', \'bgcolor\', \'#FFFFFF\', \'menu\', \'false\', \'wmode\', \'transparent\', \'allowNetworking\', \'internal\');</script>';
		case 'wma':
		case 'mid':
		case 'wav':
			return '<object classid="clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6" width="'.$width.'" height="64"><param name="invokeURLs" value="0"><param name="autostart" value="0" /><param name="url" value="'.$url.'" /><embed src="'.$url.'" autostart="0" type="application/x-mplayer2" width="'.$width.'" height="64"></embed></object>';
		case 'ra':
		case 'rm':
		case 'ram':
			$mediaid = 'media_'.random(3);
			return '<object classid="clsid:CFCDAA03-8BE4-11CF-B84B-0020AFBBCCFA" width="'.$width.'" height="32"><param name="autostart" value="0" /><param name="src" value="'.$url.'" /><param name="controls" value="controlpanel" /><param name="console" value="'.$mediaid.'_" /><embed src="'.$url.'" autostart="0" type="audio/x-pn-realaudio-plugin" controls="ControlPanel" console="'.$mediaid.'_" width="'.$width.'" height="32"></embed></object>';
	}
}

function parsemedia($params, $url) {
	$params = explode(',', $params);
	$width = intval($params[1]) > 800 ? 800 : intval($params[1]);
	$height = intval($params[2]) > 600 ? 600 : intval($params[2]);

	$url = addslashes($url);
        if(!in_array(strtolower(substr($url, 0, 6)), array('http:/', 'https:', 'ftp://', 'rtsp:/', 'mms://')) && !preg_match('/^static\//', $url) && !preg_match('/^data\//', $url)) {
		return dhtmlspecialchars($url);
	}

	if($flv = parseflv($url, $width, $height)) {
		return $flv;
	}
	if(in_array(count($params), array(3, 4))) {
		$type = $params[0];
		$url = htmlspecialchars(str_replace(array('<', '>'), '', str_replace('\\"', '\"', $url)));
		switch($type) {
			case 'mp3':
			case 'wma':
			case 'ra':
			case 'ram':
			case 'wav':
			case 'mid':
				return parseaudio($url, $width);
			case 'rm':
			case 'rmvb':
			case 'rtsp':
				$mediaid = 'media_'.random(3);
				return '<object classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" width="'.$width.'" height="'.$height.'"><param name="autostart" value="0" /><param name="src" value="'.$url.'" /><param name="controls" value="imagewindow" /><param name="console" value="'.$mediaid.'_" /><embed src="'.$url.'" autostart="0" type="audio/x-pn-realaudio-plugin" controls="imagewindow" console="'.$mediaid.'_" width="'.$width.'" height="'.$height.'"></embed></object><br /><object classid="clsid:CFCDAA03-8BE4-11CF-B84B-0020AFBBCCFA" width="'.$width.'" height="32"><param name="src" value="'.$url.'" /><param name="controls" value="controlpanel" /><param name="console" value="'.$mediaid.'_" /><embed src="'.$url.'" autostart="0" type="audio/x-pn-realaudio-plugin" controls="controlpanel" console="'.$mediaid.'_" width="'.$width.'" height="32"></embed></object>';
			case 'flv':
				$randomid = 'flv_'.random(3);
				return '<span id="'.$randomid.'"></span><script type="text/javascript" reload="1">$(\''.$randomid.'\').innerHTML=AC_FL_RunContent(\'width\', \''.$width.'\', \'height\', \''.$height.'\', \'allowNetworking\', \'internal\', \'allowScriptAccess\', \'never\', \'src\', \''.STATICURL.'image/common/flvplayer.swf\', \'flashvars\', \'file='.rawurlencode($url).'\', \'quality\', \'high\', \'wmode\', \'transparent\', \'allowfullscreen\', \'true\');</script>';
			case 'swf':
				$randomid = 'swf_'.random(3);
				return '<span id="'.$randomid.'"></span><script type="text/javascript" reload="1">$(\''.$randomid.'\').innerHTML=AC_FL_RunContent(\'width\', \''.$width.'\', \'height\', \''.$height.'\', \'allowNetworking\', \'internal\', \'allowScriptAccess\', \'never\', \'src\', encodeURI(\''.$url.'\'), \'quality\', \'high\', \'bgcolor\', \'#ffffff\', \'wmode\', \'transparent\', \'allowfullscreen\', \'true\');</script>';
			case 'asf':
			case 'asx':
			case 'wmv':
			case 'mms':
			case 'avi':
			case 'mpg':
			case 'mpeg':
				return '<object classid="clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6" width="'.$width.'" height="'.$height.'"><param name="invokeURLs" value="0"><param name="autostart" value="0" /><param name="url" value="'.$url.'" /><embed src="'.$url.'" autostart="0" type="application/x-mplayer2" width="'.$width.'" height="'.$height.'"></embed></object>';
			case 'mov':
				return '<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="'.$width.'" height="'.$height.'"><param name="autostart" value="false" /><param name="src" value="'.$url.'" /><embed src="'.$url.'" autostart="false" type="video/quicktime" controller="true" width="'.$width.'" height="'.$height.'"></embed></object>';
			default:
				return '<a href="'.$url.'" target="_blank">'.$url.'</a>';
		}
	}
	return;
}

function bbcodeurl($url, $tags) {
	if(!preg_match("/<.+?>/s", $url)) {
		if(!in_array(strtolower(substr($url, 0, 6)), array('http:/', 'https:', 'ftp://', 'rtsp:/', 'mms://')) && !preg_match('/^static\//', $url) && !preg_match('/^data\//', $url)) {
			$url = 'http://'.$url;
		}
		return str_replace(array('submit', 'member.php?mod=logging'), array('', ''), str_replace('{url}', addslashes($url), $tags));
	} else {
		return '&nbsp;'.$url;
	}
}

function jammer() {
	$randomstr = '';
	for($i = 0; $i < mt_rand(5, 15); $i++) {
		$randomstr .= chr(mt_rand(32, 59)).' '.chr(mt_rand(63, 126));
	}
	return mt_rand(0, 1) ? '<font class="jammer">'.$randomstr.'</font>'."\r\n" :
		"\r\n".'<span style="display:none">'.$randomstr.'</span>';
}

function highlightword($text, $words, $prepend) {
	$text = str_replace('\"', '"', $text);
	foreach($words AS $key => $replaceword) {
		$text = str_replace($replaceword, '<highlight>'.$replaceword.'</highlight>', $text);
	}
	return "$prepend$text";
}

function parseflv($url, $width = 0, $height = 0) {
	$lowerurl = strtolower($url);
	$flv = $iframe = $imgurl = '';
	if($lowerurl != str_replace(array('player.youku.com/player.php/sid/','tudou.com/v/','player.ku6.com/refer/'), '', $lowerurl)) {
		$flv = $url;
	} elseif(strpos($lowerurl, 'v.youku.com/v_show/') !== FALSE) {
		$ctx = stream_context_create(array('http' => array('timeout' => 10)));
		if(preg_match("/^https?:\/\/v.youku.com\/v_show\/id_([^\/]+)(.html|)/i", $url, $matches)) {
			$flv = 'https://player.youku.com/player.php/sid/'.$matches[1].'/v.swf';
			$iframe = 'https://player.youku.com/embed/'.$matches[1];
			if(!$width && !$height) {
				$api = 'http://v.youku.com/player/getPlayList/VideoIDS/'.$matches[1];
				$str = stripslashes(file_get_contents($api, false, $ctx));
				if(!empty($str) && preg_match("/\"logo\":\"(.+?)\"/i", $str, $image)) {
					$url = substr($image[1], 0, strrpos($image[1], '/')+1);
					$filename = substr($image[1], strrpos($image[1], '/')+2);
					$imgurl = $url.'0'.$filename;
				}
			}
		}
	} elseif(strpos($lowerurl, 'tudou.com/programs/view/') !== FALSE) {
		if(preg_match("/^http:\/\/(www.)?tudou.com\/programs\/view\/([^\/]+)/i", $url, $matches)) {
			$flv = 'http://www.tudou.com/v/'.$matches[2];
			$iframe = 'http://www.tudou.com/programs/view/html5embed.action?code='.$matches[2];
			if(!$width && !$height) {
				$str = file_get_contents($url, false, $ctx);
				if(!empty($str) && preg_match("/<span class=\"s_pic\">(.+?)<\/span>/i", $str, $image)) {
					$imgurl = trim($image[1]);
				}
			}
		}
	} elseif(strpos($lowerurl, 'v.ku6.com/show/') !== FALSE) {
		if(preg_match("/^http:\/\/v.ku6.com\/show\/([^\/]+).html/i", $url, $matches)) {
			$flv = 'http://player.ku6.com/refer/'.$matches[1].'/v.swf';
			if(!$width && !$height) {
				$api = 'http://vo.ku6.com/fetchVideo4Player/1/'.$matches[1].'.html';
				$str = file_get_contents($api, false, $ctx);
				if(!empty($str) && preg_match("/\"picpath\":\"(.+?)\"/i", $str, $image)) {
					$imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
				}
			}
		}
	} elseif(strpos($lowerurl, 'v.ku6.com/special/show_') !== FALSE) {
		if(preg_match("/^http:\/\/v.ku6.com\/special\/show_\d+\/([^\/]+).html/i", $url, $matches)) {
			$flv = 'http://player.ku6.com/refer/'.$matches[1].'/v.swf';
			if(!$width && !$height) {
				$api = 'http://vo.ku6.com/fetchVideo4Player/1/'.$matches[1].'.html';
				$str = file_get_contents($api, false, $ctx);
				if(!empty($str) && preg_match("/\"picpath\":\"(.+?)\"/i", $str, $image)) {
					$imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
				}
			}
		}
	} elseif(strpos($lowerurl, 'www.youtube.com/watch?') !== FALSE) {
		if(preg_match("/^https?:\/\/www.youtube.com\/watch\?v=([^\/&]+)&?/i", $url, $matches)) {
			$flv = 'https://www.youtube.com/v/'.$matches[1].'&hl=zh_CN&fs=1';
			$iframe = 'https://www.youtube.com/embed/'.$matches[1];
			if(!$width && !$height) {
				$str = file_get_contents($url, false, $ctx);
				if(!empty($str) && preg_match("/'VIDEO_HQ_THUMB':\s'(.+?)'/i", $str, $image)) {
					$url = substr($image[1], 0, strrpos($image[1], '/')+1);
					$filename = substr($image[1], strrpos($image[1], '/')+3);
					$imgurl = $url.$filename;
				}
			}
		}
	} elseif(strpos($lowerurl, 'video.sina.com.cn/v/b/') !== FALSE) {
		if(preg_match("/^http:\/\/video.sina.com.cn\/v\/b\/(\d+)-(\d+).html/i", $url, $matches)) {
			$flv = 'http://vhead.blog.sina.com.cn/player/outer_player.swf?vid='.$matches[1];
			if(!$width && !$height) {
				$api = 'http://interface.video.sina.com.cn/interface/common/getVideoImage.php?vid='.$matches[1];
				$str = file_get_contents($api, false, $ctx);
				if(!empty($str)) {
					$imgurl = str_replace('imgurl=', '', trim($str));
				}
			}
		}
	} elseif(strpos($lowerurl, 'you.video.sina.com.cn/b/') !== FALSE) {
		if(preg_match("/^http:\/\/you.video.sina.com.cn\/b\/(\d+)-(\d+).html/i", $url, $matches)) {
			$flv = 'http://vhead.blog.sina.com.cn/player/outer_player.swf?vid='.$matches[1];
			if(!$width && !$height) {
				$api = 'http://interface.video.sina.com.cn/interface/common/getVideoImage.php?vid='.$matches[1];
				$str = file_get_contents($api, false, $ctx);
				if(!empty($str)) {
					$imgurl = str_replace('imgurl=', '', trim($str));
				}
			}
		}
	} elseif(strpos($lowerurl, 'http://my.tv.sohu.com/u/') !== FALSE) {
		if(preg_match("/^http:\/\/my.tv.sohu.com\/u\/[^\/]+\/(\d+)/i", $url, $matches)) {
			$flv = 'http://v.blog.sohu.com/fo/v4/'.$matches[1];
			if(!$width && !$height) {
				$api = 'http://v.blog.sohu.com/videinfo.jhtml?m=view&id='.$matches[1].'&outType=3';
				$str = file_get_contents($api, false, $ctx);
				if(!empty($str) && preg_match("/\"cutCoverURL\":\"(.+?)\"/i", $str, $image)) {
					$imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
				}
			}
		}
	} elseif(strpos($lowerurl, 'http://v.blog.sohu.com/u/') !== FALSE) {
		if(preg_match("/^http:\/\/v.blog.sohu.com\/u\/[^\/]+\/(\d+)/i", $url, $matches)) {
			$flv = 'http://v.blog.sohu.com/fo/v4/'.$matches[1];
			if(!$width && !$height) {
				$api = 'http://v.blog.sohu.com/videinfo.jhtml?m=view&id='.$matches[1].'&outType=3';
				$str = file_get_contents($api, false, $ctx);
				if(!empty($str) && preg_match("/\"cutCoverURL\":\"(.+?)\"/i", $str, $image)) {
					$imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
				}
			}
		}
	} elseif(strpos($lowerurl, 'http://www.56.com') !== FALSE) {

		if(preg_match("/^http:\/\/www.56.com\/\S+\/play_album-aid-(\d+)_vid-(.+?).html/i", $url, $matches)) {
			$flv = 'http://player.56.com/v_'.$matches[2].'.swf';
			$matches[1] = $matches[2];
		} elseif(preg_match("/^http:\/\/www.56.com\/\S+\/([^\/]+).html/i", $url, $matches)) {
			$flv = 'http://player.56.com/'.$matches[1].'.swf';
		}
		if(!$width && !$height && !empty($matches[1])) {
			$api = 'http://vxml.56.com/json/'.str_replace('v_', '', $matches[1]).'/?src=out';
			$str = file_get_contents($api, false, $ctx);
			if(!empty($str) && preg_match("/\"img\":\"(.+?)\"/i", $str, $image)) {
				$imgurl = trim($image[1]);
			}
		}
	}
	if($flv) {
		if(!$width && !$height) {
			return array('flv' => $flv, 'imgurl' => $imgurl);
		} else {
			$width = addslashes($width);
			$height = addslashes($height);
			$flv = addslashes($flv);
			$iframe = addslashes($iframe);
			$randomid = 'flv_'.random(3);
			$enablemobile = $iframe ? 'mobileplayer() ? "<iframe height=\''.$height.'\' width=\''.$width.'\' src=\''.$iframe.'\' frameborder=0 allowfullscreen></iframe>" : ' : '';
			return '<span id="'.$randomid.'"></span><script type="text/javascript" reload="1">$(\''.$randomid.'\').innerHTML=('.$enablemobile.'AC_FL_RunContent(\'width\', \''.$width.'\', \'height\', \''.$height.'\', \'allowNetworking\', \'internal\', \'allowScriptAccess\', \'never\', \'src\', \''.$flv.'\', \'quality\', \'high\', \'bgcolor\', \'#ffffff\', \'wmode\', \'transparent\', \'allowfullscreen\', \'true\'));</script>';
		}
	} else {
		return FALSE;
	}
}

function parseimg($width, $height, $src, $lazyload, $pid, $extra = '') {
	global $_G;
	static $styleoutput = null;
	if($_G['setting']['domainwhitelist_affectimg']) {
		$tmp = parse_url($src);
		if(!empty($tmp['host']) && !iswhitelist($tmp['host'])) {
			return $src;
		}
	}
	if(strstr($src, 'file:') || substr($src, 1, 1) == ':') {
		return $src;
	}
	if($width > $_G['setting']['imagemaxwidth']) {
		$height = intval($_G['setting']['imagemaxwidth'] * $height / $width);
		$width = $_G['setting']['imagemaxwidth'];
		if(defined('IN_MOBILE')) {
			$extra = '';
		} else {
			$extra = 'onmouseover="img_onmouseoverfunc(this)" onclick="zoom(this)" style="cursor:pointer"';
		}
	}
	$attrsrc = !IS_ROBOT && $lazyload ? 'file' : 'src';
	$rimg_id = random(5);
	$GLOBALS['aimgs'][$pid][] = $rimg_id;
	$guestviewthumb = !empty($_G['setting']['guestviewthumb']['flag']) && empty($_G['uid']);
	$img = '';
	if($guestviewthumb) {
		if(!isset($styleoutput)) {
			$img .= guestviewthumbstyle();
			$styleoutput = true;
		}
		$img .= '<div class="guestviewthumb"><img id="aimg_'.$rimg_id.'" class="guestviewthumb_cur" onclick="showWindow(\'login\', \'{loginurl}\'+\'&referer=\'+encodeURIComponent(location))" '.$attrsrc.'="{url}" border="0" alt="" />
				<br><a href="{loginurl}" onclick="showWindow(\'login\', this.href+\'&referer=\'+encodeURIComponent(location));">'.lang('forum/template', 'guestviewthumb').'</a></div>';

	} else {
		if(defined('IN_MOBILE')) {
			$img = '<img'.($width > 0 ? ' width="'.$width.'"' : '').($height > 0 ? ' height="'.$height.'"' : '').' src="{url}" border="0" alt="" />';
		} else {
			$img = '<img id="aimg_'.$rimg_id.'" onclick="zoom(this, this.src, 0, 0, '.($_G['setting']['showexif'] ? 1 : 0).')" class="zoom"'.($width > 0 ? ' width="'.$width.'"' : '').($height > 0 ? ' height="'.$height.'"' : '').' '.$attrsrc.'="{url}" '.($extra ? $extra.' ' : '').'border="0" alt="" />';
		}
	}
	$code = bbcodeurl($src, $img);
	if($guestviewthumb) {
		$code = str_replace('{loginurl}', 'member.php?mod=logging&action=login', $code);
	}
	return $code;
}

function parsesmiles(&$message) {
	global $_G;
	static $enablesmiles;
        //echo "<pre>";print_r($_G['cache']['smilies']);die;
        $data = array('searcharray' => array(), 'replacearray' => array(), 'typearray' => array());
        $v = CommonSmiley::select()->orderBy("displayorder","desc")->get()->toArray();
	foreach($v as $smiley) {
		$data['searcharray'][$smiley['id']] = '/'.preg_quote(dhtmlspecialchars($smiley['code']), '/').'/';
		$data['replacearray'][$smiley['id']] = $smiley['url'];
		$data['typearray'][$smiley['id']] = $smiley['typeid'];
	}
        $mm= Array("1"=>Array
        (
            'available' => 1,
            'name' => '默认',
            'type' => 'smiley',
            'displayorder' => 2,
            'directory' => 'default'  
        ),"2"=>Array
        (
            'available' => 1,
            'name' => '酷猴',
            'type' => 'smiley',
            'displayorder' => 2,
            'directory' => 'coolmonkey'
        ),"3"=>Array
        (
            'available' => 1,
            'name' => '呆呆男',
            'type' => 'smiley',
            'displayorder' => 3,
            'directory' => 'grapeman'
        )

);
        //pre($data['replacearray']);
        //pre($data['typearray']);
        //spre(STATICURL);
//	if($enablesmiles === null) {
//		$enablesmiles = false;
		if(!empty($data) && is_array($data)) {
			foreach($data['replacearray'] AS $key => $smiley) {
				//pre($mm[$data['typearray'][$key]]['directory']);
                                $m1 = @$mm[$data['typearray'][$key]]['directory'];
                            $data['replacearray'][$key] = '<img src="'.STATICURL.'image/smiley/'.$m1.'/'.$smiley.'" smilieid="'.$key.'" border="0" alt="" />';
			//pre($data['replacearray'][$key]);
                                
                        }
			$enablesmiles = true;
		}
//	}
	//pre($data);die;
	$enablesmiles && $message = preg_replace($data['searcharray'], $data['replacearray'], $message, 10);
	return $message;
}

function parsepostbg($bgimg, $pid) {
	global $_G;
	static $postbg;
	if($postbg[$pid]) {
		return '';
	}
	loadcache('postimg');
	foreach($_G['cache']['postimg']['postbg'] as $postbg) {
		if($postbg['url'] != $bgimg) {
			continue;
		}
		$bgimg = dhtmlspecialchars(basename($bgimg), ENT_QUOTES);
		$postbg[$pid] = true;
		$_G['forum_posthtml']['header'][$pid] .= '<style type="text/css">#pid'.$pid.'{background-image:url("'.STATICURL.'image/postbg/'.$bgimg.'");}</style>';
		break;
	}
	return '';
}

function parsepassword($password, $pid) {
	global $_G;
	static $postpw;
	if($postpw[$pid]) {
		return '';
	}
	$postpw[$pid] = true;
	if(empty($_G['cookie']['postpw_'.$pid]) || $_G['cookie']['postpw_'.$pid] != md5($password)) {
		$_G['forum_discuzcode']['passwordlock'][$pid] = 1;
	}
	return '';
}

function guestviewthumbstyle() {
	static $styleoutput = null;
	$return = '';
	if ($styleoutput === null) {
		global $_G;
		$return = '<style>.guestviewthumb {margin:10px auto; text-align:center;}.guestviewthumb a {font-size:12px;}.guestviewthumb_cur {cursor:url('.IMGDIR.'/scf.cur), default; max-width:'.$_G['setting']['guestviewthumb']['width'].'px;}.ie6 .guestviewthumb_cur { width:'.$_G['setting']['guestviewthumb']['width'].'px !important;}</style>';
		$styleoutput = true;
	}
	return $return;
}
function tpl_quote() {
?><?php
$return = <<<EOF
<div class="quote"><blockquote>\\1</blockquote></div>
EOF;
?><?php 
return $return;
}


function getExpress($com,$code){
    $url = "http://api.kuaidi.com/openapi.html?id=1d9b4e96a9bfd1e89db1dc7fac368c7f&com=".$com."&nu=".$code."&show=0&muti=0&order=desc";
    $json = httpGet($url);
    $data = json_decode($json,true);
    return $data;
}

function getWeather($city){
    $url = "http://wthrcdn.etouch.cn/weather_mini?city=".$city;
    $json = httpGet($url);
    $data = json_decode($json);
    //pre($json); 
    return $data;
}

function getCity($latitude,$longitude){
    $url = 'http://api.map.baidu.com/geocoder/v2/?ak=D6WOzHaymzVVKvgiy8UbhQEznkgeK6BD&location=' .$latitude . ',' .$longitude . '&output=json';
    $json = httpGet($url);
    $data = json_decode($json,true);
    return $data;
}


function getLatelyTime($type = ''){
    $now = time();
     $result = [];
    if($type == 'week'){
        //最近一周
        for($i=0;$i<7;$i++){
            $result[] = date('Y-m-d',strtotime('-'.$i.' day', $now));
        }
    }elseif($type == 'month'){
        //最近一个月
        for($i=0;$i<30;$i++){
            $result[] = date('Y-m-d',strtotime('-'.$i.' day', $now));
        }
    }elseif($type == 'year'){
        //最近一年
        for($i=0;$i<12;$i++){
            $result[] = date('Y-m',strtotime('-'.$i.' month', $now));
        }
    }
    return $result;
}











