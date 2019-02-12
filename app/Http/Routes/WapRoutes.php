<?php
namespace App\Http\Routes;
 
use Illuminate\Contracts\Routing\Registrar;
 
class WapRoutes
{
    public function map(Registrar $router)
      {
        $router->group(['namespace' => 'Wap','prefix' => 'wap'], function ($router) {    
            $router->get('/', 'IndexController@index');
            $router->get('news', 'NewsController@index');    // 图文笔记
            $router->get('news_{id}.html', 'NewsController@detail');    // 图文笔记详情
            $router->match(['get', 'post'],'tags', 'NewsController@tags');
            $router->get('blog', 'BlogController@index');    // 技术博客
            $router->get('blog_{id}.html', 'BlogController@detail');    // 技术博客详情
            $router->get('forum', 'ForumController@index');    // 论坛
            $router->get('forum_list/{id}', 'ForumController@forumList');
            $router->match(['get', 'post'],'forum_list_detail/{id}', 'ForumController@forumListDetail');
            $router->match(['get', 'post'], 'login', 'LoginController@login');
            $router->match(['get', 'post'], 'search', 'SearchController@index');
            $router->get('qqLogin', 'LoginController@qq_login');    // QQ 登录
            $router->get('qq_login_callback', 'LoginController@qqLoginCallback');
            $router->get('loginSetUname', 'LoginController@loginSetUname');
            $router->get('logout', 'LoginController@logout');
            $router->get('imageAlbum/{id}', 'ForumController@image_album');
            $router->get('imageXc', 'ImagesController@index');//相册
            $router->match(['get', 'post'], 'imageList/{id}', 'ImagesController@imageList');//相册
            $router->get('imageAlbumXc/{id}', 'ImagesController@image_album');
            $router->get('guide', 'ForumController@guide');
            
        });

        $router->group(['namespace' => 'Wap','prefix' => 'wap','middleware' => 'wap.login'], function ($router) {
            $router->get('profile', 'ProfileController@index');
            $router->match(['get', 'post'],'reply', 'ForumController@reply');
            $router->get('favorite', 'ForumController@favorite');
            $router->get('like/{id}', 'ForumController@zan');
            $router->post('reply/{id}', 'NewsController@reply');
            $router->match(['get', 'post'],'sendForum', 'ForumController@sendForum');
            $router->get('chooseMod', 'ForumController@chooseMod');
            $router->any('upload_add_qiniu', 'UploadController@addqiniu');
            $router->any('upload_add_qiniu_video', 'VideoUploadController@addVideo');
            $router->match(['get', 'post'],'forum_reply', 'ForumController@reply');
            $router->match(['get', 'post'],'image_reply', 'ImagesController@reply');
        });
      }
}
