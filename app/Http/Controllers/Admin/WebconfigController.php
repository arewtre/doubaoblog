<?php
namespace App\Http\Controllers\Admin;
use App\Facades\Resources;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\WebConfig\WebconfigRequest;
use App\Http\Requests\Admin\WebConfig\WebconfigMake;
use App\Http\Requests\Admin\WebConfig\WebconfigCatetroyRequest;
use App\Http\Model\WebConfigCatetroy;
use App\Http\Model\WebConfig;
use Site,Cache;
class WebconfigController extends CommonController{
    public function __construct(){
    //
    }
    /**
     * to show index
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $config='';
        $catetroy = WebConfigCatetroy::where('status',1)->orderBy('id')->get();
        if(count($catetroy) > 0){
            foreach($catetroy as $v){
                $catetroyArray[$v->id] = $v->describe;
            }
        }

        $config =Site::getAll();

        $status=$request->only('status')['status'];//用来显示 修改成功

         return  view('admin.webconfig.index',compact('config','status','catetroyArray'));

    }

    /**
     * to edit webconfig
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function modify(WebconfigRequest $request){

        $input = $request->except(['_method','_token']);

        foreach($input['keyvalue'] as $key=>$value){

            WebConfig::where('id',$key)->update(['keyvalue' => $value]);

        }

        Cache::forget('config');

       return redirect('admin/webconfig?status=modify');

    }

    /**
     * to show  config list
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toList(Request $request){

        $status = $request->status;

        if($status==1){

            flash('删除成功！', 'success');

        }
        $catetroy = WebConfigCatetroy::orderBy('id')->get();
        if(count($catetroy) > 0){
            foreach($catetroy as $v){
                $catetroyArray[$v->id] = $v->describe;
            }
        }
        $config = WebConfig::orderBy('categroy')->orderBy('sort')->get();
        $current = '';
        foreach($config as $v){
            if($current != $v->categroy && !empty($current)){
                $v->noSame = 1;
            }else{
                $v->noSame =0;
            }
            $current = $v->categroy;
        }

        return  view('admin.webconfig.tolist',compact('config','catetroyArray'));

    }
    /**
     * to create  sign
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $Catetroy = WebConfigCatetroy::orderBy('id','desc')->get();
        return  view('admin.webconfig.create',compact('Catetroy'));

    }
    /**
     * to save sign
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(WebconfigMake $request){

        $input = $request->only(['sign','keyname','keyvalue','tip','type','categroy','sort']);

        if(!empty($request->make) and $request->make=='add'){
            //to check sign
            $checkSign = WebConfig::checkSign($input['sign'])->toArray();

            if(!$checkSign){

                if(WebConfig::create($input)){
                    flash('['.$input['sign'].'->'.$input['keyname'].']标签添加成功！', 'success');
                    return redirect('admin/signcreate');
                }

            }else{

                flash('['.$input['sign'].']标签已存在！', 'false');
                return redirect('admin/signcreate');

            }
        }
    }
    /**
     * to edit config
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){

        $input = $request->only(['id']);
        $Catetroy = WebConfigCatetroy::orderBy('id','desc')->get();
        $config = WebConfig::where('id',$input['id'])->first();

      return  view('admin.webconfig.edit',compact('config','Catetroy'));

    }
    /**
     * to Save edit config
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editSave(WebconfigMake $request){

        $input = $request->only(['id','sign','keyname','keyvalue','tip','type','categroy','sort']);

        if(!empty($request->make) and $request->make=='modify'){

            if(WebConfig::where('id',$input['id'])->update($input)){

                flash('['.$input['sign'].'->'.$input['keyname'].']标签更新成功！', 'success');
                return redirect('admin/signedit?id='.$input['id']);

            }else{

                flash('['.$input['sign'].'->'.$input['keyname'].']标签重复提交或更新失败！', 'false');
                return redirect('admin/signedit?id='.$input['id']);

            }
        }
    }
    /**
     * to destroy  config
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
        $input = $request->only('id');
        if(!empty($input['id'])){
            if(WebConfig::where('id',$input['id'])->take(1)->delete()){

                return redirect('admin/signlist?status=1');

            }else{

                return redirect('admin/signlist?status=2');

            }
        }
    }

    /**
     * 配置类别列表
     * @return mixed
     */
    public function webCatetroyList(){
        $WebConfigCatetroy = WebConfigCatetroy::orderBy('id')->get();
        return  view('admin.webconfig.catetroyList',compact('WebConfigCatetroy'));
    }

    /**
     * 配置类别创建
     * @return mixed
     */
    public function webCatetroyAdd(){
        return  view('admin.webconfig.catetroyCreate');
    }

    /**
     * 配置类别保存
     * @param WebconfigCatetroyRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function catetroySave(WebconfigCatetroyRequest $request){
        $request->only('describe');

        if(!empty($request->describe)){
            WebConfigCatetroy::create(['describe'=>$request->describe]);
            $request->session()->flash('message','[ 添加成功！]');
            return  redirect("/admin/webcatetroylist");
        }else{
            return back();
        }
    }

    /**
     * 配置类别删除
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function catetroyDestroy(Request $request){
        $request->only("id");
        WebConfigCatetroy::destroy($request->id);
        $request->session()->flash('message','[ 删除成功！]');
        return  redirect("/admin/webcatetroylist");
    }

    /**
     * 配置类别修改页面
     * @param Request $request
     * @return mixed
     */
    public function catetroyEdit(Request $request){
        $request->only("id");
        if($WebConfigCatetroy = WebConfigCatetroy::where('id',$request->id)->first()){
            return  view('admin.webconfig.catetroyEdit',compact("WebConfigCatetroy"));
        }else{
            $exception = "没有找到相关配置类别";
            return  view('errors.404',compact('exception'));
        }
    }

    /**
     * 配置类别更新
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function catetroyUpdate(Request $request){
        $request->only("id","describe");
        if(!empty($request->describe)){
            WebConfigCatetroy::where('id',$request->id)->update(['describe'=>$request->describe]);
            $request->session()->flash('message','[ 更新成功！]');
            return  redirect("/admin/webcatetroylist");
        }else{
            return back();
        }
    }

    /**
     * 删除系统所有缓存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function toPlushCache(Request $request){
        Cache::flush();
        Resources::plushCache();
        $request->session()->flash('message','[ 缓存更新成功！]');
        return redirect('/admin/');
    }
}