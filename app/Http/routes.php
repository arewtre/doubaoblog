<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//前台路由组
// Home 模块
Route::group(['namespace' => 'Home','middleware' => 'is.mobile'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('news', 'NewsController@index');    // 图文笔记
    Route::get('news_{id}.html', 'NewsController@detail');    // 图文笔记详情
    Route::get('blog', 'BlogController@index');    // 技术博客
    Route::get('blog_{id}.html', 'BlogController@detail');    // 技术博客详情
    Route::get('forum', 'ForumController@index');    // 论坛
    Route::get('guide', 'ForumController@guide');    // 论坛
    Route::get('forum_list/{id}', 'ForumController@forumList');//主题
    Route::get('imageXc', 'ImagesController@index');//相册
    Route::get('imageList/{id}', 'ImagesController@imageList');//相册
    Route::match(['get', 'post'],'forum_list_detail/{id}', 'ForumController@forumListDetail');//帖子详情
    Route::match(['get', 'post'],'login', 'LoginController@login');    // 登录
    Route::get('qqLogin', 'LoginController@qq_login');    // QQ 登录
    Route::get('qq_login_callback', 'LoginController@qqLoginCallback');
    Route::match(['get', 'post'],'loginSetUname', 'LoginController@loginSetUname');
    Route::get('logout', 'LoginController@logout');
    Route::post('search', 'SearchController@index');
});

Route::group(['namespace' => 'Home','middleware' => 'home.login'], function () {
    Route::get('biaotai/{id}/{bt}/{type}', 'NewsController@biaotai');
    Route::post('addrep/{id}/{type}', 'NewsController@addrep');
    Route::match(['get', 'post'],'forumAdd', 'ForumController@forumAdd');
     //上传资源
    Route::any('upload_add', 'UploadController@add');
    Route::any('upload_manage', 'UploadController@manage');
    Route::any('upload_del', 'UploadController@del');
    Route::any('sign', 'SignController@index');
    Route::get('images_add', 'ImagesController@imagesAdd');//添加照片
    Route::any('imageXc_add', 'ImagesController@add');//相册添加
    Route::any('imageXc_del', 'ImagesController@del');//相册删除
    Route::any('imageXc_edit', 'ImagesController@edit');//相册编辑
    Route::any('imageXc_cate', 'ImagesController@cateList');//相册分类列表
    Route::any('imageXc_cate_add', 'ImagesController@cateAdd');//相册分类添加
    Route::any('imageXc_cate_edit', 'ImagesController@cateEdit');//相册分类编辑
    Route::any('imageXc_cate_del', 'ImagesController@cateDel');//相册分类删除
    Route::post('forum_rep' , 'ForumController@forumRep');    // 回帖    
    Route::any('im', 'ImController@index');//聊天
    
});
Route::group(['namespace' => 'Api','prefix' => 'api'], function () {
    Route::match(['get', 'post'],'miniprogram', 'MiniprogramController@index');
    Route::match(['get', 'post'],'upload', 'UploadController@index');
});

// Wap 模块
Route::group(['namespace' => 'Wap','prefix' => 'wap'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('news', 'NewsController@index');    // 图文笔记
    Route::get('news_{id}.html', 'NewsController@detail');    // 图文笔记详情
    Route::get('blog', 'BlogController@index');    // 技术博客
    Route::get('blog_{id}.html', 'BlogController@detail');    // 技术博客详情
    Route::get('forum', 'ForumController@index');    // 论坛
    Route::get('forum_list/{id}', 'ForumController@forumList');
    Route::match(['get', 'post'],'forum_list_detail/{id}', 'ForumController@forumListDetail');
    Route::match(['get', 'post'], 'login', 'LoginController@login');
    Route::match(['get', 'post'], 'search', 'SearchController@index');
    Route::get('qqLogin', 'LoginController@qq_login');    // QQ 登录
    Route::get('qq_login_callback', 'LoginController@qqLoginCallback');
    Route::get('loginSetUname', 'LoginController@loginSetUname');
    Route::get('logout', 'LoginController@logout');
    Route::get('imageAlbum/{id}', 'ForumController@image_album');
    Route::get('imageXc', 'ImagesController@index');//相册
    Route::match(['get', 'post'], 'imageList/{id}', 'ImagesController@imageList');//相册
    Route::get('imageAlbumXc/{id}', 'ImagesController@image_album');
    Route::get('guide', 'ForumController@guide');
    
});

Route::group(['namespace' => 'Wap','prefix' => 'wap','middleware' => 'wap.login'], function () {
    Route::get('profile', 'ProfileController@index');
    Route::match(['get', 'post'],'reply', 'ForumController@reply');
    Route::get('favorite', 'ForumController@favorite');
    Route::get('like/{id}', 'ForumController@zan');
    Route::post('reply/{id}', 'NewsController@reply');
    Route::match(['get', 'post'],'sendForum', 'ForumController@sendForum');
    Route::get('chooseMod', 'ForumController@chooseMod');
    Route::any('upload_add_qiniu', 'UploadController@addqiniu');
    Route::any('upload_add_qiniu_video', 'VideoUploadController@addVideo');
    Route::match(['get', 'post'],'forum_reply', 'ForumController@reply');
    Route::match(['get', 'post'],'image_reply', 'ImagesController@reply');
});
//后台用户登录注册路由
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function(){
    //Route::auth();
   // Route::get('index', 'IndexController@index');
    
    Route::any('login', 'LoginController@login');
    Route::get('code', 'LoginController@code');
});
//后台路由组
Route::group(['namespace' => 'Admin', 'prefix' => 'admin','middleware' => 'admin.login'], function(){
//Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function(){
    //Route::auth();
    Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);
    Route::get('index', 'IndexController@index');
    Route::get('main', 'IndexController@main');
    
    Route::match(['get', 'post'],'info', 'UserController@info');
    Route::match(['get', 'post'],'userList', 'UserController@index');
    Route::match(['get', 'post'],'user_add', 'UserController@addUser');
    Route::post('user_del', 'UserController@userDel');
    Route::match(['get', 'post'],'memberList', 'UserController@member');
    Route::get('logout', 'LoginController@logout');
    Route::any('pass', 'UserController@pass');
    
    //图文笔记管理资源控制器 
    Route::get('news_list', 'NewsController@index');
    Route::get('newscenter', 'NewsCenterController@index');
    Route::get('ajaxGetNews', 'NewsController@ajaxGetNews');
    Route::any('news_add', 'NewsController@add');
    Route::any('news_edit', 'NewsController@edit');
    Route::any('news_del', 'NewsController@del');
    Route::get('news_cate', 'NewsCategoryController@index');
    Route::any('news_cate_add', 'NewsCategoryController@create');
    Route::any('news_cate_edit', 'NewsCategoryController@update');
    Route::any('news_cate_del/{id}', 'NewsCategoryController@destroy');
    Route::any('changeTags', 'NewsController@changeTags');
    
    //技术博客管理资源控制器 
    Route::get('blog_list', 'BlogController@index');
    Route::get('blogcenter', 'BlogCenterController@index');
    Route::get('ajaxGetBlog', 'BlogController@ajaxGetBlog');
    Route::any('blog_add', 'BlogController@add');
    Route::any('blog_edit', 'BlogController@edit');
    Route::any('blog_del', 'BlogController@del');
    Route::get('blog_cate', 'BlogCategoryController@index');
    Route::any('blog_cate_add', 'BlogCategoryController@create');
    Route::any('blog_cate_edit', 'BlogCategoryController@update');
    Route::any('blog_cate_del/{id}', 'BlogCategoryController@destroy');
    
    //论坛 
    Route::get('forum_card', 'ForumController@index');//帖子
    Route::any('forum_com', 'ForumController@comList');//评论
    Route::any('forum_del', 'ForumController@del');//删帖
    Route::any('forum_black', 'ForumController@black');//黑名单
    Route::get('forum_mod', 'ForumCategoryController@index');
    Route::any('forum_mod_add', 'ForumCategoryController@create');
    Route::any('forum_mod_edit', 'ForumCategoryController@update');
    Route::any('forum_mod_del/{id}', 'ForumCategoryController@destroy');
    Route::any('forum_rep_view', 'ForumController@repView');
    
    
    //相册
    Route::get('imageXc_list', 'ImagesController@index');//相册列表
    Route::get('imageList/{id}', 'ImagesController@imageList');//相册照片列表
    Route::get('images_add', 'ImagesController@imagesAdd');//添加照片
    Route::any('imageXc_add', 'ImagesController@add');//相册添加
    Route::any('imageXc_del', 'ImagesController@del');//相册删除
    Route::any('imageXc_edit', 'ImagesController@edit');//相册编辑
    Route::any('imageXc_cate', 'ImagesController@cateList');//相册分类列表
    Route::any('imageXc_cate_add', 'ImagesController@cateAdd');//相册分类添加
    Route::any('imageXc_cate_edit', 'ImagesController@cateEdit');//相册分类编辑
    Route::any('imageXc_cate_del', 'ImagesController@cateDel');//相册分类删除
    
    //视频
    Route::get('video_list', 'VideoController@index');//视频列表
    Route::any('video_add', 'VideoController@add');//视频添加
    Route::any('video_del', 'VideoController@del');//视频删除
    Route::any('video_edit', 'VideoController@edit');//视频编辑
    Route::any('video_cate', 'VideoController@cateList');//分类列表
    Route::any('video_cate_add', 'VideoController@cateAdd');//分类添加
    Route::any('video_cate_edit', 'VideoController@cateEdit');//分类编辑
    Route::any('video_cate_del', 'VideoController@cateDel');//分类删除
    
    //广告
    Route::get('adv_list', 'AdvController@index');
    Route::get('ajaxGetAdv', 'AdvController@ajaxGetAdv');
    Route::any('adv_add', 'AdvController@add');
    Route::any('adv_edit', 'AdvController@edit');
    Route::post('adv_del', 'AdvController@del');
    Route::get('adv_addr', 'AdvController@addr');
    Route::get('ajaxGetAddr', 'AdvController@ajaxGetAddr');
    Route::any('adv_addr_add', 'AdvController@addrAdd');
    Route::any('adv_addr_edit', 'AdvController@addrEdit');
    Route::any('adv_addr_del', 'AdvController@addrDel');
    
    //上传资源
    Route::any('upload_add', 'UploadController@add');
    Route::any('upload_add_qiniu', 'UploadController@addqiniu');
    Route::any('upload_manage', 'UploadController@manage');
    Route::any('upload_del', 'UploadController@del');
    Route::any('upload_add_image', 'UploadController@addimage');
    Route::any('upload_add_video', 'VideoUploadController@addVideo');
    //内容管理
    Route::any('webcontent_add', 'WebContentController@add');
    Route::any('webcontent_edit', 'WebContentController@edit');
    Route::any('webcontent_del', 'WebContentController@del');
    Route::any('webcontent', 'WebContentController@index');
    Route::any('ajaxGetWebContent', 'WebContentController@ajaxGetWebContent');
    
    //广告站点资源控制器
    Route::resource('ad_site', 'AdSiteController');
    //广告位置资源控制器
    Route::resource('ad_slots', 'AdSlotsController');
    Route::get('shield_ad', 'AdSlotsController@shieldAd');//屏蔽广告
    Route::post('set_ad_sort', 'AdSlotsController@setAdSort');//设置广告排序
    //友情链接资源控制器
    Route::resource('links', 'LinksController');
    Route::match(['get', 'post'], 'link_list', 'LinksController@index');
    //友情链接资源控制器
    Route::resource('link_site', 'LinkSiteController');
    
    //网站配置选项
    Route::get('webconfig', 'WebconfigController@index');
    Route::post('webconfig/modify', 'WebconfigController@modify');
    //网站配置类别
    Route::get('webcatetroylist', 'WebconfigController@webCatetroyList')->name('webconfig.webCatetroyList');
    //网站配置类别添加
    Route::get('webcatetroyadd', 'WebconfigController@webCatetroyAdd')->name('webconfig.webCatetroyAdd');
    //网站配置类别保存
    Route::post('catetroysave', 'WebconfigController@catetroySave')->name('webconfig.catetroySave');
    //网站配置类别删除
    Route::get('catetroydestroy', 'WebconfigController@catetroyDestroy')->name('webconfig.catetroyDestroy');
    //网站配置类别修改
    Route::get('catetroyedit', 'WebconfigController@catetroyEdit')->name('webconfig.catetroyEdit');
    //网站配置保存类别修改
    Route::post('catetroyupdate', 'WebconfigController@catetroyUpdate')->name('webconfig.catetroyUpdate');
    //更新缓存
    Route::get('toplushcache', 'WebconfigController@toPlushCache');    
    //头像上传
    Route::post('imgupload', 'WorkerHandleController@imgUpload')->name("imgUpload");
    //背景图片上传
    Route::post('bgimgupload', 'WebContentController@bgImgUpload')->name('WebContent.bgImgUpload');
    Route::resource('webcontent', 'WebContentController');
    Route::post('web_upload_url', 'WebContentController@webUploadUrl');
    Route::get('web_upload_url', 'WebContentController@uploadUrl');
    Route::post('web_upload_url', 'WebContentController@webUploadUrl');
    
    Route::get('image_gif', 'CollectionController@imageGif');
    
   
    //黑名单控制器
    Route::resource('blacklist', 'BlacklistController');
    
    //角色资源控制器
    Route::resource('role', 'RoleController');
    Route::get('role/permissions/{id}', 'RoleController@permissions');
    Route::post('role/store_permissions', 'RoleController@storePermissions');
    //权限资源控制器
    Route::resource('permission', 'PermissionController');
    Route::get('permission/create/{id}', 'PermissionController@create');
    Route::post('permission/change_order', 'PermissionController@changeOrder');
});
