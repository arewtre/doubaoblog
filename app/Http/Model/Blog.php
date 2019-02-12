<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model{
    protected $table = 'blog';
    protected $primaryKey = 'art_id';
    protected $guarded = [];
    
    
    protected function getPrevArticleId($id)
    {
        return Blog::where('blog.art_id', '<', $id)
                ->where("blog.is_display",1)
                ->join('blog_category', 'blog.cate_id', '=', 'blog_category.id')
                ->max('art_id');
    }
    
    protected function getNextArticleId($id)
    {
        return Blog::where('blog.art_id', '>', $id)
                ->where("blog.is_display",1)
                ->join('blog_category', 'blog.cate_id', '=', 'blog_category.id')
                ->min('art_id');
    }

}
