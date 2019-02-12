<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model{
    protected $table = 'forum';
    protected $primaryKey = 'art_id';
    protected $guarded = [];
    
    
    protected function getPrevArticleId($id)
    {
        return Forum::where('forum.art_id', '<', $id)
                ->where("forum.is_display",1)
                ->join('forum_category', 'forum.cate_id', '=', 'forum_category.id')
                ->max('art_id');
         
    }
    
    protected function getNextArticleId($id)
    {
        return Forum::where('forum.art_id', '>', $id)
                ->where("forum.is_display",1)
                ->join('forum_category', 'forum.cate_id', '=', 'forum_category.id')
                ->min('art_id');
    }
    
    protected function posts()
    {
        return $this->hasManyThrough('App\Http\Model\ForumCategory', 'App\Http\Model\Member', 'pid', 'id');
    }

}
