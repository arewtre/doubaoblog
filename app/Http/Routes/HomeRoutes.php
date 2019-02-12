<?php
namespace App\Http\Routes;
 
use Illuminate\Contracts\Routing\Registrar;
 
class HomeRoutes
{
  public function map(Registrar $router)
  {
    $router->group(['namespace' => 'Home','middleware' => 'home.login'], function ($router) {
        $router->get('biaotai/{id}/{bt}/{type}', 'NewsController@biaotai');
        $router->post('addrep/{id}/{type}', 'NewsController@addrep');
        $router->match(['get', 'post'],'forumAdd', 'ForumController@forumAdd');
         //上传资源
        $router->any('upload_add', 'UploadController@add');
        $router->any('upload_manage', 'UploadController@manage');
        $router->any('upload_del', 'UploadController@del');
        $router->any('sign', 'SignController@index');
        $router->get('images_add', 'ImagesController@imagesAdd');//添加照片
        $router->any('imageXc_add', 'ImagesController@add');//相册添加
        $router->any('imageXc_del', 'ImagesController@del');//相册删除
        $router->any('imageXc_edit', 'ImagesController@edit');//相册编辑
        $router->any('imageXc_cate', 'ImagesController@cateList');//相册分类列表
        $router->any('imageXc_cate_add', 'ImagesController@cateAdd');//相册分类添加
        $router->any('imageXc_cate_edit', 'ImagesController@cateEdit');//相册分类编辑
        $router->any('imageXc_cate_del', 'ImagesController@cateDel');//相册分类删除
        $router->post('forum_rep' , 'ForumController@forumRep');    // 回帖    
        $router->any('im', 'ImController@index');//聊天
        $router->any('addqiniu', 'UploadController@addqiniu');//工具

    });
    $router->group(['namespace' => 'Home','middleware' => 'is.mobile'], function ($router) {
        $router->get('/', 'IndexController@index');
        $router->get('news', 'NewsController@index');    // 图文笔记
        $router->get('news_{id}.html', 'NewsController@detail');    // 图文笔记详情
        $router->get('blog', 'BlogController@index');    // 技术博客
        $router->get('blog_{id}.html', 'BlogController@detail');    // 技术博客详情
        $router->get('forum', 'ForumController@index');    // 论坛
        $router->get('guide', 'ForumController@guide');    // 论坛
        $router->get('forum_list/{id}', 'ForumController@forumList');//主题
        $router->get('imageXc', 'ImagesController@index');//相册
        $router->get('imageList/{id}', 'ImagesController@imageList');//相册
        $router->match(['get', 'post'],'forum_list_detail/{id}', 'ForumController@forumListDetail');//帖子详情
        $router->match(['get', 'post'],'login', 'LoginController@login');    // 登录
        $router->get('qqLogin', 'LoginController@qq_login');    // QQ 登录
        $router->get('qq_login_callback', 'LoginController@qqLoginCallback');
        $router->match(['get', 'post'],'loginSetUname', 'LoginController@loginSetUname');
        $router->get('logout', 'LoginController@logout');
        $router->post('search', 'SearchController@index');
        $router->get('sitemap', 'GeneratedController@siteMap');
        $router->get('sitemap.xml', 'GeneratedController@siteMap');
        $router->get('feed.xml', 'GeneratedController@feed');
        $router->get('test', 'TestController@index');
        $router->any('tool', 'ToolController@index');//工具
        $router->any('css', 'ToolController@css');//工具
        $router->any('jsformat', 'ToolController@jsformat');//工具
        $router->any('htmljs', 'ToolController@htmljs');//工具
        $router->any('timestamp', 'ToolController@timestamp');//工具
        $router->any('utf8', 'ToolController@utf8');//工具
        $router->any('md5str', 'ToolController@md5str');//工具
        $router->any('url', 'ToolController@url');//工具
        $router->any('daxiaoxie', 'ToolController@daxiaoxie');//工具
        $router->any('zishutongji', 'ToolController@zishutongji');//工具
        $router->any('jsq', 'ToolController@jsq');//工具
        
    });
    $router->group(['namespace' => 'Home'], function ($router) {
        $router->any('getExpress', 'TestController@getExpress');//物流
    });
  }
}