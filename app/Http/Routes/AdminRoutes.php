<?php
namespace App\Http\Routes;
 
use Illuminate\Contracts\Routing\Registrar;
 
class AdminRoutes
{
  public function map(Registrar $router)
  { 
        //后台路由组
        $router->group(['namespace' => 'Admin', 'prefix' => 'admin'], function($router){
              $router->any('login', 'LoginController@login');
              $router->get('code', 'LoginController@code');
        });
        
        $router->group(['namespace' => 'Admin', 'prefix' => 'admin','middleware' => 'admin.login'], function($router){
        //$router->group(['namespace' => 'Admin', 'prefix' => 'admin'], function(){
            //$router->auth();
            $router->get('/', ['as' => 'index', 'uses' => 'IndexController@index']);
            $router->get('index', 'IndexController@index');
            $router->get('main', 'IndexController@main');
            $router->get('getArticle', 'IndexController@getArticle');
            $router->get('getUser', 'IndexController@getUser');
            $router->any('visitLog', 'VisitController@index');//访问记录

            $router->match(['get', 'post'],'info', 'UserController@info');
            $router->match(['get', 'post'],'userList', 'UserController@index');
            $router->match(['get', 'post'],'user_add', 'UserController@addUser');
            $router->post('user_del', 'UserController@userDel');
            $router->match(['get', 'post'],'memberList', 'UserController@member');
            $router->get('logout', 'LoginController@logout');
            $router->any('pass', 'UserController@pass');

            //图文笔记管理资源控制器 
            $router->get('news_list', 'NewsController@index');
            $router->get('newscenter', 'NewsCenterController@index');
            $router->get('ajaxGetNews', 'NewsController@ajaxGetNews');
            $router->any('news_add', 'NewsController@add');
            $router->any('news_edit', 'NewsController@edit');
            $router->any('news_del', 'NewsController@del');
            $router->get('news_cate', 'NewsCategoryController@index');
            $router->any('news_cate_add', 'NewsCategoryController@create');
            $router->any('news_cate_edit', 'NewsCategoryController@update');
            $router->any('news_cate_del/{id}', 'NewsCategoryController@destroy');
            $router->any('changeTags', 'NewsController@changeTags');

            //技术博客管理资源控制器 
            $router->get('blog_list', 'BlogController@index');
//            $router->get('blogcenter', 'BlogCenterController@index');
            $router->get('ajaxGetBlog', 'BlogController@ajaxGetBlog');
            $router->any('blog_add', 'BlogController@add');
            $router->any('blog_edit', 'BlogController@edit');
            $router->any('blog_del', 'BlogController@del');
            $router->get('blog_cate', 'BlogCategoryController@index');
            $router->any('blog_cate_add', 'BlogCategoryController@create');
            $router->any('blog_cate_edit', 'BlogCategoryController@update');
            $router->any('blog_cate_del/{id}', 'BlogCategoryController@destroy');

            //论坛 
            $router->get('forum_card', 'ForumController@index');//帖子
            $router->any('forum_com', 'ForumController@comList');//评论
            $router->any('forum_del', 'ForumController@del');//删帖
            $router->any('forum_edit', 'ForumController@edit');//编辑帖
            $router->any('forum_add', 'ForumController@add');//添加帖
            $router->any('forum_black', 'ForumController@black');//黑名单
            $router->get('forum_mod', 'ForumCategoryController@index');
            $router->any('forum_mod_add', 'ForumCategoryController@create');
            $router->any('forum_mod_edit', 'ForumCategoryController@update');
            $router->any('forum_mod_del/{id}', 'ForumCategoryController@destroy');
            $router->any('forum_rep_view', 'ForumController@repView');


            //相册
            $router->get('imageXc_list', 'ImagesController@index');//相册列表
            $router->get('imageList/{id}', 'ImagesController@imageList');//相册照片列表
            $router->get('images_add', 'ImagesController@imagesAdd');//添加照片
            $router->any('imageXc_add', 'ImagesController@add');//相册添加
            $router->any('imageXc_del', 'ImagesController@del');//相册删除
            $router->any('imageXc_edit', 'ImagesController@edit');//相册编辑
            $router->any('imageXc_cate', 'ImagesController@cateList');//相册分类列表
            $router->any('imageXc_cate_add', 'ImagesController@cateAdd');//相册分类添加
            $router->any('imageXc_cate_edit', 'ImagesController@cateEdit');//相册分类编辑
            $router->any('imageXc_cate_del', 'ImagesController@cateDel');//相册分类删除

            //视频
            $router->get('video_list', 'VideoController@index');//视频列表
            $router->any('video_add', 'VideoController@add');//视频添加
            $router->any('video_del', 'VideoController@del');//视频删除
            $router->any('video_edit', 'VideoController@edit');//视频编辑
            $router->any('video_cate', 'VideoController@cateList');//分类列表
            $router->any('video_cate_add', 'VideoController@cateAdd');//分类添加
            $router->any('video_cate_edit', 'VideoController@cateEdit');//分类编辑
            $router->any('video_cate_del', 'VideoController@cateDel');//分类删除

            //广告
            $router->get('adv_list', 'AdvController@index');
            $router->get('ajaxGetAdv', 'AdvController@ajaxGetAdv');
            $router->any('adv_add', 'AdvController@add');
            $router->any('adv_edit', 'AdvController@edit');
            $router->post('adv_del', 'AdvController@del');
            $router->get('adv_addr', 'AdvController@addr');
            $router->get('ajaxGetAddr', 'AdvController@ajaxGetAddr');
            $router->any('adv_addr_add', 'AdvController@addrAdd');
            $router->any('adv_addr_edit', 'AdvController@addrEdit');
            $router->any('adv_addr_del', 'AdvController@addrDel');

            //上传资源
            $router->any('upload_add', 'UploadController@add');
            $router->any('upload_add_qiniu', 'UploadController@addqiniu');
            $router->any('upload_manage', 'UploadController@manage');
            $router->any('upload_del', 'UploadController@del');
            $router->any('upload_add_image', 'UploadController@addimage');
            $router->any('upload_add_video', 'VideoUploadController@addVideo');
            //内容管理
            $router->any('webcontent_add', 'WebContentController@add');
            $router->any('webcontent_edit', 'WebContentController@edit');
            $router->any('webcontent_del', 'WebContentController@del');
            $router->any('webcontent', 'WebContentController@index');
            $router->any('ajaxGetWebContent', 'WebContentController@ajaxGetWebContent');

            //广告站点资源控制器
//            $router->resource('ad_site', 'AdSiteController');
            //广告位置资源控制器
//            $router->resource('ad_slots', 'AdSlotsController');
//            $router->get('shield_ad', 'AdSlotsController@shieldAd');//屏蔽广告
//            $router->post('set_ad_sort', 'AdSlotsController@setAdSort');//设置广告排序
            //友情链接资源控制器
            $router->resource('links', 'LinksController');
            $router->match(['get', 'post'], 'link_list', 'LinksController@index');
            $router->post('links/changeorder', 'LinksController@changeOrder');
            $router->post('links/changestatus', 'LinksController@changeStatus');
            //友情链接资源控制器
//            $router->resource('link_site', 'LinkSiteController');

            //网站配置选项
            $router->get('webconfig', 'WebconfigController@index');
            $router->post('webconfig/modify', 'WebconfigController@modify');
            //网站配置类别
            $router->get('webcatetroylist', 'WebconfigController@webCatetroyList')->name('webconfig.webCatetroyList');
            //网站配置类别添加
            $router->get('webcatetroyadd', 'WebconfigController@webCatetroyAdd')->name('webconfig.webCatetroyAdd');
            //网站配置类别保存
            $router->post('catetroysave', 'WebconfigController@catetroySave')->name('webconfig.catetroySave');
            //网站配置类别删除
            $router->get('catetroydestroy', 'WebconfigController@catetroyDestroy')->name('webconfig.catetroyDestroy');
            //网站配置类别修改
            $router->get('catetroyedit', 'WebconfigController@catetroyEdit')->name('webconfig.catetroyEdit');
            //网站配置保存类别修改
            $router->post('catetroyupdate', 'WebconfigController@catetroyUpdate')->name('webconfig.catetroyUpdate');
            //更新缓存
            $router->get('toplushcache', 'WebconfigController@toPlushCache');    
            //头像上传
//            $router->post('imgupload', 'WorkerHandleController@imgUpload')->name("imgUpload");
            //背景图片上传
            $router->post('bgimgupload', 'WebContentController@bgImgUpload')->name('WebContent.bgImgUpload');
            $router->resource('webcontent', 'WebContentController');
            $router->post('web_upload_url', 'WebContentController@webUploadUrl');
            $router->get('web_upload_url', 'WebContentController@uploadUrl');
            $router->post('web_upload_url', 'WebContentController@webUploadUrl');

//            $router->get('image_gif', 'CollectionController@imageGif');


            //黑名单控制器
//            $router->resource('blacklist', 'BlacklistController');

            //角色资源控制器
//            $router->resource('role', 'RoleController');
//            $router->get('role/permissions/{id}', 'RoleController@permissions');
//            $router->post('role/store_permissions', 'RoleController@storePermissions');
//            //权限资源控制器
//            $router->resource('permission', 'PermissionController');
//            $router->get('permission/create/{id}', 'PermissionController@create');
//            $router->post('permission/change_order', 'PermissionController@changeOrder');
            
        });


        
    }
}