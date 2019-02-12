<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Model\Member;
use Site;
class GeneratedController extends CommonController
{
    public function siteMap()
    {
        $view = cache()->remember('generated.sitemap', function () {
            $posts = Post::all();
            // return generated xml (string) , cache whole file
            return view('generated.sitemap', compact('posts'))->render();
        });
        return response($view)->header('Content-Type', 'text/xml');
    }

    public function feed()
    {
        $view = cache()->remember('generated.feed', function () {
            $posts = Post::all(); 
            // return generated xml (string) , cache whole file
            return view('generated.feed', compact('posts'))->render(); 
        });
        return response($view)->header('Content-Type', 'text/xml');
    }
    
}
