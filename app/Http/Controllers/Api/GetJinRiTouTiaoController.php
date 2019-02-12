<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Model\Froum;
use App\Http\Model\FroumCategory;
use App\Http\Model\Member;
use View;
class GetJinRiTouTiaoController extends CommonController
{
    public function __construct(){
        parent::__construct();
        
    }
    
    public function index(Request $request)
    {
       $data2 = json_encode(["touser"=>"oOHd306QdD-CAIuTJigcPgSNF2SQ","msgtype" => "text","text" => ["content"=>""]]);
       pre($data2);
        $url = "https://m.toutiao.com/list/?tag=news_baby&ac=wap&count=20&format=json_raw&as=A1353B9FD21473B&cp=5BF2E4C7B36BCE1&max_behot_time=".time()."&_signature=8WnkcQAAqqUCJLk8mZ-IfvFp5G&i=".time();
       $url2 = "https://m.toutiao.com/related/open/6623973028625646084/?parent_rid=17649285542604934065&city=%E5%8D%97%E4%BA%AC&province=%E6%B1%9F%E8%8B%8F&page_type=article&share_iid=&share_app_name=&wx_share_count=0&site_id=5000246&num=5&num=15&code_id=14798012085000246&code_id=14799599715000246&except_page=&tt_running=0&enable_mix=1&web_id=6625413991060702733&utm_source=&utm_medium=&utm_campaign=";
       $url3 = "https://m.toutiao.com/i6623973028625646084/info/?_signature=opkpXBAS-XpR1HQRsPdhH6KZKU&i=6623973028625646084";
       $url4 = "https://www.toutiao.com/api/pc/feed/?category=news_baby&utm_source=toutiao&widen=1&max_behot_time=".time()."&max_behot_time_tmp=".time()."&tadrequire=true&as=A1155B3F52B4A45&cp=5BF234BA7455CE1&_signature=9kbYnQAArb4FC4XQX2-qg.ZG2I";
       $url5= "https://www.toutiao.com/stream/widget/local_weather/data/?city=北京";
       $url6 = "http://www.yuerzaixian.com/plus/json.aspx?jid=J131610767481472177&page=1";
       $url7="https://www.toutiao.com/pgc/ma/?page_type=1&max_behot_time=".time()."&uid=4377795668&media_id=4377795668&output=json&is_json=1&count=10&from=user_profile_app&version=2&as=A1054BF5B303CEE&cp=5B5353EC0EEE0E1&callback=jsonp5";
       $url8 = "https://m.toutiao.com/list/?tag=news_sports&ac=wap&count=20&format=json_raw&as=A1755B6FB277131&cp=5BF297C163B1AE1&max_behot_time=".time();
       $result = httpGet($url8);
       pre($result);
    }
    
    
    
}
