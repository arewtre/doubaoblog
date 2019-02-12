<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model{
    protected $table = 'news';
    protected $primaryKey = 'art_id';
    protected $guarded = [];
    
    
    protected function getPrevArticleId($id,$type)
    {
        return News::where('news.art_id', '<', $id)
                ->where("news.is_display",1)
                ->where("news.type",$type)
                ->join('news_category', 'news.cate_id', '=', 'news_category.id')
                ->max('art_id');
    }
    
    protected function getNextArticleId($id,$type)
    {
        return News::where('news.art_id', '>', $id)
                ->where("news.is_display",1)
                ->where("news.type",$type)
                ->join('news_category', 'news.cate_id', '=', 'news_category.id')
                ->min('art_id');
    }

}
