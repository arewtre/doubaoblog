<?php
namespace App\Http\Routes;
 
use Illuminate\Contracts\Routing\Registrar;
 
class ApiRoutes
{
  public function map(Registrar $router)
  {
        $router->group(['namespace' => 'Api','prefix' => 'api'], function ($router) {
            $router->match(['get', 'post'],'miniprogram', 'MiniprogramController@index');
            $router->get('miniproLogin', 'MiniprogramController@login');
            $router->get('onLogin', 'MiniprogramController@onLogin');
            $router->get('news', 'NewsController@index');
            $router->get('news_detail', 'NewsController@detail');
            $router->get('getXc', 'XcController@index'); 
            $router->get('getXcCate', 'XcController@cate'); 
            $router->get('getImages', 'XcController@getImages');
            $router->get('getBanner', 'BannerController@index');
            $router->get('getForumTop', 'BannerController@getForumTop');
            $router->get('gethotkeywords', 'BannerController@gethotkeywords');
            $router->get('getForumList', 'BannerController@getForumList');
            $router->get('getForumLists', 'BannerController@getForumLists');
//            $router->get('getForumListsBycid', 'BannerController@getForumListsBycid');
            $router->get('getForumDetail', 'BannerController@getForumDetail');
            $router->get('getForumComment', 'BannerController@getForumComment');
            $router->get('getCateList', 'BannerController@getCateList');
            $router->get('getConfig','MiniprogramController@getConfig');           
            $router->match(['get', 'post'],'login','LoginController@login');
            $router->match(['get', 'post'],'test','LoginController@test');
            $router->get('getMemberList','MyController@memberList');
            $router->get('getZhuanti','BannerController@getZhuanti');
            $router->get('getMyForumLists','BannerController@getMyForumLists');
            $router->match(['get', 'post'],'getExpress','MyController@getExpress');
            $router->match(['get', 'post'],'wechat','WechatController@index');
            $router->match(['get', 'post'],'zywechat','ZyWechatController@index');
            $router->post('uploads','UploadController@addqiniu');
            $router->get('getjrttData','GetJinRiTouTiaoController@index');
            $router->match(['get', 'post'],'msgSend','MessageController@index');
            $router->any('getExpCom', 'BannerController@getExpCom');//物流公司
            $router->any('getGg', 'BannerController@getGg');//公告
            $router->any('openPublish', 'BannerController@openPublish');//打开编辑

            $router->get('getAppLogin', 'AppLoginController@index');//APP登录
            
        });
        
        $router->group(['namespace' => 'Api','prefix' => 'api','middleware' => 'is.api'], function ($router) {
//            $router->match(['get', 'post'],'upload', 'UploadController@index');
            $router->match(['get', 'post'],'toZan','BannerController@toZan');
            $router->match(['get', 'post'],'toCollect','BannerController@toCollect');
            $router->match(['get', 'post'],'getMyCollect','MyController@myCollect');
            $router->match(['get', 'post'],'getMyInfo','MyController@index');
            $router->get('getMylevelMsg','MyController@getMylevelMsg');
            $router->get('deleteForum','BannerController@deleteForum');
            $router->post('addMsg','MyController@addMsg');
            $router->post('upload','UploadController@addqiniu');
            $router->post('publish','MyController@publish');
            $router->match(['get', 'post'],'addComment','BannerController@addComment');

            $router->get('getExpress', 'BannerController@getExpress');//物流
            $router->get('getCity', 'BannerController@getCity');//物流
            $router->get('getWeather', 'BannerController@getWeather');//天气

        });

      $router->group(['namespace' => 'Api','prefix' => 'api'], function ($router) {
//            $router->match(['get', 'post'],'upload', 'UploadController@index');
          $router->match(['get', 'post'],'toZan2','BannerController@toZan');
          $router->match(['get', 'post'],'toCollect2','BannerController@toCollect');
          $router->match(['get', 'post'],'getMyCollect2','MyController@myCollect');
          $router->match(['get', 'post'],'getMyInfo2','MyController@index');
          $router->get('getMylevelMsg2','MyController@getMylevelMsg');
          $router->get('deleteForum2','BannerController@deleteForum');
          $router->post('addMsg2','MyController@addMsg');
          $router->post('upload2','UploadController@addqiniu');
          $router->post('publish2','MyController@publish');
          $router->match(['get', 'post'],'addComment2','BannerController@addComment');

          $router->get('getExpress2', 'BannerController@getExpress');//物流
          $router->get('getCity2', 'BannerController@getCity');//物流
          $router->get('getWeather2', 'BannerController@getWeather');//天气

      });
    }
}